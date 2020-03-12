<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index ()
    {
        // Get all resources
        $activeMenu = 'benefits';
        $plan = Plan::Latest()->where('status', 1)->first();
        return view('plan.index', compact('activeMenu', 'plan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create ()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store (Request $request)
    {
        // Validate form data
        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);
        // Create new model instance
        $plan = new Plan();

        if ($request->hasFile('file')) {
            $planFile = fileUpload('file', Plan::$planFileLocation, true);
            $plan->file = $planFile;
        }
        $plan->save();
        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Plan $plan
     * @return void
     */
    public function show (Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Plan $plan
     * @return void
     */
    public function edit (Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Plan $plan
     * @return RedirectResponse
     */
    public function update (Request $request, Plan $plan)
    {
        // Validate form data
        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        Plan::where('status', 1)
            ->update(['status' => 0]);

        // Create new model instance
        $plan = new Plan();

        if ($request->hasFile('file')) {
            if (isset($file)) {
                Storage::delete($file);
            }
            $planFile = fileUpload('file', Plan::$planFileLocation, true);
            $plan->file = $planFile;
        }
        $plan->save();
        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Plan $plan
     * @return void
     */
    public function destroy(Plan $plan)
    {

    }
}
