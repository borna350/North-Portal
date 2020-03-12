<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\User;
use Illuminate\View\View;

class AdminPaystatementController extends Controller {

    /**
     * @return Factory|View
     */
    function paystatement () {
        $data['user_list'] = User::where('user_type', 'employee')->get();

        //print_r($data['user_list']);
        return view('admin.paystatement', $data);
        //echo 'hello';
    }
}
