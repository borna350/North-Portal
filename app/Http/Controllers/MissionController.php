<?php

namespace App\Http\Controllers;

use App\Mission;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index ()
    {
        $activeMenu = 'classroom';
        $mission = Mission::Latest()->where('status', 1)->first();

        return view('mission.index', compact('activeMenu', 'mission'));
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
        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);
        // Create new model instance
        $mission = new Mission();

        if ($request->hasFile('file')) {
            $missionFile = fileUpload('file', Mission::$missionFileLocation, true);
            $mission->file = $missionFile;
        }
        $mission->save();
        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    /**
     * Display the specified resource.
     * @param Mission $mission
     * @return void
     */
    public function show (Mission $mission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param Mission $mission
     * @return void
     */
    public function edit (Mission $mission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Mission $mission
     * @return RedirectResponse
     */
    public function update (Request $request, Mission $mission)
    {
        // Validate form data
        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);
        Mission::where('status', 1)
            ->update(['status' => 0]);

        // Create new model instance
        $mission = new Mission();

        if ($request->hasFile('file')) {
            if (isset($file)) {
                Storage::delete($file);
            }
            $missionFile = fileUpload('file', Mission::$missionFileLocation, true);
            $mission->file = $missionFile;
        }
        $mission->save();

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Mission $mission
     * @return void
     */
    public function destroy (Mission $mission)
    {
        //
    }
}
