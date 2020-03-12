<?php

namespace App\Http\Controllers;

use App\User;

use App\{Company, Expenses, EmployeeDetails};
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Validation\{Rule, ValidationException};
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return Factory|View
     */
    public function home ()
    {
        $activeMenu = 'dashboard';
        return view('dashboard', compact('activeMenu'));
    }

    /**
     * Display admin landing page
     *
     * @return Factory|View
     */
    public function employeeModule ()
    {
        $activeMenu = 'submit';
        return view('employee-module', compact('activeMenu'));
    }

    /**
     * Display benefits landing page
     *
     * @return Factory|View
     */
    public function benefitsModule ()
    {
        $activeMenu = 'benefits';
        return view('benefits-module', compact('activeMenu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Factory|View
     */
    public function editProfile ()
    {
        $emp_id = auth()->user()->id;
        $activeMenu = 'profile';
        $findUser = User::where('id', '!=', auth()->user()->id)->with('employee_details')->orderBy('name')->get();
        // return $findUser;
        $companies = Company::Latest()->get();
        $data['user'] = DB::table('users as u')->join('employee_details as ed', 'u.id', '=', 'ed.id')->select('ed.*')->where('u.id', '=', $emp_id)->first();
        $route = route('reset.password', $emp_id);
        return view('home', $data, compact('activeMenu', 'companies', 'findUser', 'route'));
    }


    /**
     * Show the form for editing the specified resource.
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function editEmployee (Request $request)
    {
        $id = $request->input('id');
        //Validate name, email and password fields
        $rules = [
            'firstname' => 'required|max:120',
            'lastname' => 'required|max:120',
            'company_id' => 'nullable|integer',
            'report_to' => 'nullable|integer',
            'email' => Rule::unique('users')->ignore($id) // require unique email address
        ];

        // morph input fields to match user table
        $input['name'] = $request->input('firstname') . ' ' . $request->input('lastname');
        $input['email'] = $request->input('workemail');

        // if password is entered or it's a new user
        if ($request->input('password') || !$id) {
            //$rules['password'] = 'required|min:6|confirmed';
            $rules['password'] = ['required', 'string', 'min:8', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/'];
            $input['password'] = Hash::make($request->input('password'));
        }
        $this->validate($request, $rules);

        // check for admin details
        $input['is_admin'] = $request->input('is_admin', 0);

        // employee details array start
        $user_array = $request->only([
            'firstname',
            'lastname',
            'compensation_details',
            'benefits_opt_in',
            'report_to',
            'base_salary',
            'position',
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
            'emergency_contact_email',
            'is_ticket_admin'
        ]);

        if (isset($request->company_id)) {
            $user_array['company_id'] = $request->company_id;
        }

        if ($id) {
            $user = User::findOrFail($id);
            $user->update($input);
            $emp_id = $id;
            $msg = 'User successfully updated';
        } else {
            $user = User::create($input);

            $msg = 'User successfully Added';
        }

        //profile pic  code
        if ($request->hasFile('profile_pic')) {
            if (isset($emp_id) && $profile_pic = EmployeeDetails::findOrFail($id)->profile_pic) {
                Storage::delete($profile_pic);
            }
            $profilepicname = fileUpload('profile_pic', EmployeeDetails::$profileLocation);
            $user_array['profile_pic'] = $profilepicname;
        }

        // end profile pic
        if (isset($emp_id)) {
            //$user->employee_details()->update($user_array);
            EmployeeDetails::where('id', '=', $emp_id)->update($user_array);
        } else {
            $user->employee_details()->create($user_array);
        }

        //Redirect to the users.index view and display message
        return redirect()->route('home')->with('alert-info', $msg);
    }
}
