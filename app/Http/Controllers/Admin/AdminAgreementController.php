<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminAgreementController extends Controller {

    /**
     * @param Request $request
     *
     * @return Factory|View
     */
    public function agreementlist (Request $request) {
        $employee = DB::table('employee_details as ed')->leftjoin('agreements as a', 'ed.id', '=', 'a.emp_id')->leftjoin('codeofconduct as coc', 'ed.id', '=', 'coc.emp_id')
            ->select('ed.id', 'ed.firstname', 'ed.created_at', 'ed.lastname', 'ed.personalemail', 'a.agreement', 'coc.coc_agreement')
            //->where(array('a.status'=>'A','coc.status'=>'A'))
            ->get();

        return view('admin.agreement-list', ['employee' => $employee]);
        // print_r($employee);

        // echo 'wqedwd'; die();
        //return view('agreement-list')->with('employee', $employee);
    }

}
