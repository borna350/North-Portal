<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\{PersonalDevelopmentPlan, EmployeeDetails, User};
use Illuminate\Http\Request;

class PersonalDevelopmentPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index ()
    {
        $activeMenu = 'classroom';
        $data = PersonalDevelopmentPlan::get();
        $user = User::get();

        return view('personal-development-plan.index', compact('data', 'user', 'activeMenu'));
    }

    /**
     * Filter personal development plan .
     * @param string $searchField
     * @return JsonResponse
     */
    private function search($searchField)
    {
        $query = PersonalDevelopmentPlan::orderByDesc('start_date');
        $query->dateSearch('start_date');
        // $query->isEmployee();
        return $query->get();
    }

    /**
     * Filter archive personal development plan .
     * @param Request $request
     * @return JsonResponse
     */
    public function searchArchive(Request $request)
    {
        $data = $this->search('search');

        if (count($data)) {
            foreach ($data as $datum) {
                $routes = [];
                $routes['commentStore'] = route('personal_development_plans.comment.store', $datum->id);
                $routes['commentUpdate'] = route('personal_development_plans.comment.update', $datum->id);
                $routes['edit'] = route('personal_development_plans.edit', $datum->id);
                $routes['update'] = route('personal_development_plans.update', $datum->id);
                $routes['show'] = route('personal_development_plans.show', $datum->id);
                $routes['destroy'] = route('personal_development_plans.destroy', $datum->id);
                $datum->routes = $routes;
                $datum->formatted_date = $datum->start_date ? $datum->start_date->format('M d, Y') : 'N/A';
            }
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:191',
            'description' => 'required|string|max:491',
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            $data = $request->all();

            $check = PersonalDevelopmentPlan::create($data);

            if ($check) {
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'fail']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function commentStore(Request $request, $id)
    {
        // Validate form data
        $rules = [
            'comment' => 'string|max:491',
        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            // return $request->all();
            $data = PersonalDevelopmentPlan::findOrFail($id);
            $data->comment = $request->comment;

            if ($data->save()) {
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'fail']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function commentUpdate(Request $request, $id)
    {
        // Validate form data
        $rules = [
            'comment' => 'string|max:491',
        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            // return $request->all();
            $data = PersonalDevelopmentPlan::findOrFail($id);
            $data->comment = $request->comment;

            if ($data->update()) {
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'fail']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     * @param PersonalDevelopmentPlan $personalDevelopmentPlan
     * @return Factory|View
     */
    public function show(PersonalDevelopmentPlan $personalDevelopmentPlan)
    {
        $activeMenu = 'classroom';
        $show = PersonalDevelopmentPlan::with('employee')->findOrFail($personalDevelopmentPlan->id);

        if ($show->comment) {
            $route = route('personal_development_plans.comment.update', $show->id);
        } else {
            $route = route('personal_development_plans.comment.store', $show->id);
        }

        return view('personal-development-plan.show', compact('show', 'user', 'activeMenu', 'route'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PersonalDevelopmentPlan $personalDevelopmentPlan
     * @return JsonResponse
     */
    public function edit(PersonalDevelopmentPlan $personalDevelopmentPlan)
    {
        $data = PersonalDevelopmentPlan::findOrFail($personalDevelopmentPlan->id);
        $data['user'] = User::get();

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PersonalDevelopmentPlan $personalDevelopmentPlan
     * @return JsonResponse
     */
    public function update(Request $request, PersonalDevelopmentPlan $personalDevelopmentPlan)
    {
        // Validate form data
        $rules = [
            'description' => 'string|max:491',
        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            // return $request->all();
            $data = PersonalDevelopmentPlan::findOrFail($personalDevelopmentPlan->id);
            $data->emp_id = $request->emp_id;
            $data->title = $request->title;
            $data->description = $request->description;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            // $data->comment = $request->comment;

            if ($data->update()) {
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'fail']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PersonalDevelopmentPlan $personalDevelopmentPlan
     * @return JsonResponse
     */
    public function destroy(PersonalDevelopmentPlan $personalDevelopmentPlan)
    {
        $benefit = PersonalDevelopmentPlan::findOrFail($personalDevelopmentPlan->id);
        if ($benefit->delete() == 1) {
            $success = true;
            $message = "Journal deleted successfully";
        } else {
            $success = false;
            $message = "journal not found";
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
