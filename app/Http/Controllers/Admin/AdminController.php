<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{RedirectResponse,Request};
use Illuminate\View\View;
use App\{User,Expenses,Company,Project,Purchases,Categorys,MaintenanceTicket};
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {

    /**
     * Display a listing of the resource.
     * @return Factory|View
     */
    public function index () {
        return view('admin/registration');
    }

    /**
     * Display expense report.
     * @return Factory|View
     */
    public function expences_report () {
        $data['expence'] = Expenses::where(['delete_status' => NULL, 'status' => NULL])->get();
        $data['companies'] = Company::all();
        $data['project'] = Project::all();
        $data['purchases'] = Purchases::all();
        $data['category'] = Categorys::all();

        return view('admin/expencesreport', $data);
    }

    /**
     * Display mileage list.
     * @return Factory|View
     */
    public function milegebook () {
        $data['mileage_list'] = DB::table('mileages')->get();
        $data['companies'] = Company::all();

        return view('admin/mileagebook', $data);
    }

    /**
     * Display tech maintenance list.
     * @return Factory|View
     */
    public function tech_maintanance () {
        $data['maintanance'] = MaintenanceTicket::where(['delete_status' => NULL, 'status' => NULL])->get();
        $data['maintanance1'] = MaintenanceTicket::where(['delete_status' => NULL, 'status' => 1])->orWhere(['status' => 2])->get();
        $data['category'] = Categorys::all();

        return view('admin/tech_maintanance', $data);
    }

    /**
     * Display time off.
     * @return Factory|View
     */
    public function timeoff () {
        return view('admin/timeoff');
    }

    /**
     * Display report of concern.
     * @return Factory|View
     */
    public function reportconcern () {
        return view('admin/reportconcern');
    }

    /**
     * user registration.
     * @param Request $request
     *
     * @return RedirectResponse
     */
    protected function add_registration (Request $request) {
        $name = '';
        if ($request->hasFile('profilepic')) {
            $file = $request->file('profilepic');
            $name = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $request->file('profilepic')->move("public/profile", $name);
        }
        $employee_detailsarray = [
            'firstname'                => $request->firstname,
            'lastname'                 => $request->lastname,
            'personalemail'            => $request->personalemail,
            'dob'                      => $request->dob,
            'phone_no'                 => $request->phone,
            'address'                  => $request->address,
            'profile_pic'              => $name,
            'no_ofchildren'            => $request->noofchildren,
            'family_inarea'            => $request->familyinarea,
            'familycircumstance'       => $request->familycircumstance,
            'prsnl_belief'             => $request->personal_belief,
            'known_medical_conditions' => $request->medical_conditions,
            'allergies'                => $request->allergies,
            'dietary_restrictions'     => $request->dietary_restrictions,
            'known_health_concerns'    => $request->mental_concerns,
            'aversion_phyactivity'     => $request->aversion_phyactivity,
            'emergency_contact_name'   => $request->emergency_contact_name,
            'reltn_emergency_contact'  => $request->rel_emer_contact,
            'emergency_contact_email'  => $request->emergency_email,
            'emergency_contact_phone'  => $request->emer_contact_phone,
        ];

        $check_email = user::where(['email' => $request->personalemail])->count();
        if ($check_email == 1) {
            return back()->with('error', 'This Email Already Available Please Try Another EMail !!');
        }
        $Employee_detail = EmployeeDetails::create($employee_detailsarray);
        $last_id = $Employee_detail->id;
        $user_detail = User::create([
            'id'        => $last_id,
            'name'      => $request->firstname . ' ' . $request->lastname,
            'password'  => Hash::make($request->password),
            'email'     => $request->personalemail,
            'user_type' => 'employee'
        ]);
        if ($user_detail) {
            //$role = Role::create(['name' => 'Employe']);
            //$permission = Permission::create(['name' => 'Employe Panel']);
            $role = Role::findByid(2);
            $permission = Permission::findByid(2);
            $role->givePermissionTo($permission);
            $permission->assignRole($role);
            $user_detail->givePermissionTo('Employee Panel');
            $user_detail->assignRole('Employee');
        }

        return back()->with('message', 'Your information is submitted Successfully');

    }

}
