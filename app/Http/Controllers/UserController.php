<?php

namespace App\Http\Controllers;

use App\{Company, User, EmployeeDetails};
use App\Mail\PasswordReset;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\{Auth, Hash, Mail, Storage};
use Illuminate\Validation\{Rule, ValidationException};
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Spatie\Permission\Models\{Permission, Role};

class UserController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        if (auth()->user()->is_admin == 1) {
            //Get all users and pass it to the view
            $activeMenu = 'admin';
            $users = User::with('employee_details')->orderBy('name')->get();
            return view('users.index', compact('activeMenu', 'users'));
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        if (auth()->user()->is_admin == 1) {
            //Get all roles and pass it to the view
            $companies = Company::Latest()->get();
            $activeMenu = 'admin';
            $user = new User();

            $roles = Role::with([
                'permissions' => function ($q) {
                    $q->orderBy('orderval')->orderBy('name');
                }
            ])->has('permissions')->orderBy('orderval')->get();
            $permissions = Permission::pluck('name', 'id');
            $route = '#';
            return view('users.edit', compact('user', 'activeMenu', 'companies', 'roles', 'permissions', 'route'));
        } else {
            abort(401);
        }
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'password' => 'Password must contain a lower case, uppercase, number and special character',
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {

        $isAdmin = auth()->user()->is_admin;
        $id = $request->input('id');

        //Validate name, email and password fields
        $rules = [
            'firstname' => 'required|max:120',
            'lastname' => 'required|max:120',
            'company_id' => 'nullable|integer',
            'email' => Rule::unique('users')->ignore($id) // require unique email address
        ];

        // morph input fields to match user table
        $input['name'] = $request->input('firstname') . ' ' . $request->input('lastname');
        $input['email'] = $request->input('workemail');

        // if password is entered or it's a new user
        if ($request->input('password') || !$id) {
            //$rules['password'] = 'required|min:6|confirmed';
            $rules['password'] = ['required', 'string', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/'];
            $input['password'] = Hash::make($request->input('password'));
        }
        $this->validate($request, $rules);

        // check for admin details
        $input['is_admin'] = $request->input('is_admin', 0);

        // employee details array start
        $user_array = $request->only([
            'firstname',
            'lastname',
            'dob',
            'personalemail',
            'phone_no',
            'address',
            'workemail',
            'profile_pic',
            'marital_status',
            'no_ofchildren',
            'family_inarea',
            'familycircumstance',
            'prsnl_belief',
            'known_medical_conditions',
            'allergies',
            'dietary_restrictions',
            'known_health_concerns',
            'aversion_phyactivity',
            'emergency_contact_name',
            'reltn_emergency_contact',
            'emergency_contact_phone',
            'emergency_contact_email'
        ]);

        if (isset($request->company_id)) {
            $user_array['company_id'] = $request->company_id;
        }

        if ($id) {
            $user = User::find($id);
            $user->update($input);
            $emp_id = $id;
            /*            $user_detailsupdate = EmployeeDetails::find($id);
                        $user_detailsupdate->update($user_array);*/
            $msg = 'User successfully updated';
        } else {
            $user = User::create($input);

            $msg = 'User successfully Added';
        }

        // profile pic code
        if ($request->hasFile('profile_pic')) {
            if (isset($emp_id) && $profile_pic = EmployeeDetails::find($id)->profile_pic) {
                Storage::delete($profile_pic);
            }
            $profilepicname = fileUpload('profile_pic', User::$profileLocation);
            $user_array['profile_pic'] = $profilepicname;
        }
        // end profile pic

        if (isset($emp_id)) {
            //$user->employee_details()->update($user_array);
            EmployeeDetails::where('id', '=', $emp_id)->update($user_array);
        } else {
            $user->employee_details()->create($user_array);
        }

        // permissions actions.  Use initial "is Admin" status, in case this user is the one being edited
        if ($isAdmin) {
            $user->syncPermissions($request->input('permission', []));
        }

        // Ticket Admin check
        if (isset($request->is_ticket_admin)) {
            User::where('is_ticket_admin', 1)->update(['is_ticket_admin' => 0]);
            $user->is_ticket_admin = 1;
            $user->save();
        }
        //Redirect to the users.index view and display message
        return redirect()->route('users.index')->with('alert-info', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return RedirectResponse|Redirector
     */
    public function show($id)
    {
        return redirect('users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param int $id
     *
     * @return Factory|View
     */
    public function edit(Request $request, $id)
    {
        $activeMenu = 'admin';
        $companies = Company::Latest()->get();
        $u = User::findOrFail($id); //Get user with specified id
        //DB::enableQueryLog();
        $user = EmployeeDetails::find($u->id);
        /* $query = DB::getQueryLog();
        print_r($query);
        die;*/
        if (!$user) {
            $user = new EmployeeDetails();
            // separate first / last name from user table
            [$user->firstname, $user->lastname] = explode(' ', $u->name);
            $user->workemail = $u->email;
        }

        if (!$user->workemail) {
            $user->workemail = $u->email;
        }
        $user->is_admin = $u->is_admin; // lazy load details from admin
        $user->id = $u->id; // override ID to match User table instead of Employee Details
        $roles = Role::with([
            'permissions' => function ($q) {
                $q->orderBy('orderval')->orderBy('name');
            }
        ])->has('permissions')->orderBy('orderval')->get();
        // $permissions = Permission::pluck('name', 'id');

        if (isset($request->permission) && count($request->permission)) {
            $permissions = Permission::find($request->permission)->pluck('name', 'id');
            $u->givePermissionTo(['permissions']);
        } else {
            $permissions = '-';
        }
        $route = route('reset.stuff.password', $u->id);
        return view('users.edit', compact('user', 'activeMenu', 'companies', 'roles', 'permissions', 'route'));

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($id)
    {
        //Find a user with a given id and delete
        $user = User::find($id);
        $success = $user->exists ? true : false;
        $user->delete();
        return response()->json(['success' => $success]);
    }

    /**
     * Force login
     * @param User $user
     * @return RedirectResponse
     */
    public function forceLogin (User $user)
    {
        // only allow forced login when user is an admin
        if (Auth::user()->is_admin === 1 && !request()->input('return')) {
            session(['was-admin-id' => Auth::user()->id, 'was-admin' => Auth::user()->remember_token]);
            Auth::loginUsingId($user->id);
        } elseif (session('was-admin-id') == $user->id && session('was-admin') == $user->remember_token) {
            session()->forget(['was-admin', 'was-admin-id']);
            Auth::loginUsingId($user->id);
        } else {
            return redirect()->back();
        }
        return redirect()->route('home');
    }

    /**
     * change Admin Password
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function changeUserPassword (Request $request, $id)
    {
        try {
            $user = User::find($id);
            $pass = '';
            $symbols = [];
            $length = 8;
            $used_symbols = '';
            $characters = "lower_case,upper_case,numbers,special_symbols";
            $symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
            $symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $symbols["numbers"] = '1234567890';
            $symbols["special_symbols"] = '!?~@#-_+<>[]{}';
            $characters = explode(",", $characters);
            foreach ($characters as $key => $value) {
                $used_symbols .= $symbols[$value];
            }
            $symbols_length = strlen($used_symbols) - 1;
            for ($i = 0; $i < $length; $i++) {
                $n = rand(0, $symbols_length);
                $pass .= $used_symbols[$n];
            }
            $user->password = bcrypt($pass);
            $user->save();

            if ($user->update() == 1) {
                $success = true;
                $message = "Password send your email";
            } else {
                $success = false;
                $message = "There is a problem";
            }

            // Send email
            if ($user->employee_details) {
                $emails = [];

                if ($user->employee_details->personalemail) {
                    $emails[] = $user->employee_details->personalemail;
                }

                if ($user->employee_details->workemail) {
                    $emails[] = $user->employee_details->workemail;
                }

                if (count($emails)) {
                    Mail::to($emails)->send(new PasswordReset($pass));
                } else {
                    $message = "You have no email!";
                }
            }

            return response()->json([
                'success' => $success,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'error' => $e->getMessages()]);
        }
    }

    /**
     * Change employee password
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function changeStuffPassword (Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $pass = '';
            $symbols = [];
            $length = 8;
            $used_symbols = '';
            $characters = "lower_case,upper_case,numbers,special_symbols";
            $symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
            $symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $symbols["numbers"] = '1234567890';
            $symbols["special_symbols"] = '!?~@#-_+<>[]{}';
            $characters = explode(",", $characters);
            foreach ($characters as $key => $value) {
                $used_symbols .= $symbols[$value];
            }
            $symbols_length = strlen($used_symbols) - 1;
            for ($i = 0; $i < $length; $i++) {
                $n = rand(0, $symbols_length);
                $pass .= $used_symbols[$n];
            }
            $user->password = bcrypt($pass);
            $user->save();

            if ($user->update() == 1) {
                $success = true;
                $message = "Password send your email";
            } else {
                $success = false;
                $message = "There is a problem";
            }

            // Send email
            if ($user->employee_details) {
                $emails = [];

                if ($user->employee_details->personalemail) {
                    $emails[] = $user->employee_details->personalemail;
                }

                if ($user->employee_details->workemail) {
                    $emails[] = $user->employee_details->workemail;
                }

                if (count($emails)) {
                    Mail::to($emails)->send(new PasswordReset($pass));
                } else {
                    $message = "You have no email!";
                }
            }
            return response()->json([
                'success' => $success,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'error' => $e->getMessages()]);
        }
    }

    /**
     * Filter user
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function search (Request $request)
    {
        try {
            $data = User::with('employee_details')->orderBy('name')->where(function ($q) use ($request) {

                // ->where('is_admin', '!=', 1)

                if (isset($request->search)) {
                    $q->where('name', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%');
                }
            })->get();

            if (count($data)) {
                foreach ($data as $datum) {
                    $datum->formatted_date = $datum->created_at ? $datum->created_at->format('M d, Y') : 'N/A';
                }
            }

            return response()->json(['status' => 200, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}
