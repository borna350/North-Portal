<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TimeoffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    function timeOffList ()
    {
        if (auth()->user()->is_admin) {
            $activeMenu = 'admin';
        } else {
            $activeMenu = 'submit';
        }

        return view('timeoff.index', compact('activeMenu'));
    }
}
