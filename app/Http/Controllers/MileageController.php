<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{JsonResponse, Request, Response};
use Illuminate\Support\Facades\{Auth, DB};
use App\{Company, Mileage};
use Illuminate\View\View;

class MileageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    public function index (Request $request)
    {
        $type = auth()->user()->is_admin;
        if ($type) {
            $activeMenu = 'admin';
        } else {
            $activeMenu = 'submit';
        }

        if ($type == '1') {
            $data['mileage_list'] = Mileage::where('status', '<>', 'D')->orderByDesc('date')->with('employee:id,firstname,lastname')->get();
        } else {
            $data['mileage_list'] = Auth::user()->mileage()->where('status', 'A')->orderByDesc('date')->get();

        }
        $data['companies'] = Company::all();
        $date_key = $request->date;
        return view('mileage-list', $data, compact('activeMenu'))->with('date_key', $date_key);
    }

    /**
     * Filter mileage
     * @param Request $request
     * @return JsonResponse
     */
    public function searchPendingMileage (Request $request)
    {
        $data = $this->searchMileage('search', true);

        if (count($data)) {
            foreach ($data as $datum) {
                $routes = [];
                $routes['edit'] = route('mileages.edit', $datum->id);
                $routes['update'] = route('mileages.update', $datum->id);
                $routes['destroy'] = route('mileages.destroy', $datum->id);
                $routes['pending'] = route('mileages.pending', $datum->id);
                $routes['approve'] = route('mileages.approve', $datum->id);
                $routes['reject'] = route('mileages.reject', $datum->id);
                $datum->routes = $routes;
                $datum->formatted_date = $datum->date ? $datum->date->format('M d, Y') : 'N/A';
            }
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Filter mileage
     * @param string $searchField
     * @param bool $isPending
     * @return mixed
     */
    private function searchMileage ($searchField, $isPending = true)
    {
        $query = Mileage::orderByDesc('date')->with('employee');

        if ($search = request()->input($searchField)) {
            $query->whereHas('employee', function ($sql) use ($search) {
                $sql->where('firstname', 'LIKE', '%' . $search . '%');
                $sql->orWhere('lastname', 'LIKE', '%' . $search . '%');
            });
        }

        $query->dateSearch('date');
        $query->isEmployee();

        // pending has not status
        if ($isPending) {
            $query->whereNull('status');
        } else {
            $query->whereNotNull('status');
        }

        return $query->get();
    }

    /**
     * Filter history mileage
     * @param Request $request
     * @return JsonResponse
     */
    public function searchHistoryMileage (Request $request)
    {
        $data = $this->searchMileage('history_search', false);

        if (count($data)) {
            foreach ($data as $datum) {
                $routes = [];
                $routes['pending'] = route('mileages.pending', $datum->id);
                $routes['destroy'] = route('mileages.destroy', $datum->id);
                $datum->routes = $routes;
                $datum->formatted_date = $datum->date ? $datum->date->format('M d, Y') : 'N/A';
            }
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store (Request $request)
    {
        // Validate form data
        $rules = [
            'companyname' => 'required|string|max:191',
            'date' => 'required|date',
            'vehicle' => 'required|string|max:191',
            'kilometers' => 'required|string|max:191',
            'reasonformileage' => 'required|string|max:191',
        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 200, 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            $mileagearray = [
                'emp_id' => auth()->user()->id,
                'company' => $request->companyname,
                'date' => $request->date,
                'vehicle' => $request->vehicle,
                'kilometers' => $request->kilometers,
                'reasonmileage' => $request->reasonformileage,
            ];

            DB::table('mileages')->insert($mileagearray);

            return response()->json(['status' => 200, 'data' => 'Created successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param Mileage $mileage
     * @return JsonResponse
     */
    public function edit (Request $request, Mileage $mileage)
    {
        $q = Mileage::where('id', $mileage->id);

        // if not admin, ensure they are only loading their own data
        if (!auth()->user()->is_admin) {
            $q->where('emp_id', auth()->user()->id);
        }

        $data['mileage'] = $q->firstOrFail();
        $data['companies'] = Company::all();

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Mileage $mileage
     * @return JsonResponse
     */
    public function update (Request $request, Mileage $mileage)
    {
        $input = $request->only(['company', 'date', 'vehicle', 'kilometers', 'reasonmileage']);

        if ($id = $mileage->id) {
            $data = Mileage::findOrFail($id);

            if ($data->update($input)) {
                return response()->json(['status' => 'success']);
            }
        } else {
            $input['emp_id'] = Auth::user()->id;
            $data = Mileage::create($input);
            if ($data) {
                return response()->json(['status' => 'success']);
            }
        }

        return response()->json(['status' => 'fail']);
    }

    /**
     * Change the resource status pending.
     * @param Mileage $mileage
     * @return JsonResponse
     */
    public function mileagePending (Mileage $mileage)
    {
        $data = Mileage::findOrFail($mileage->id);
        $data->status = null;
        $data->save();

        if ($data->update()) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'fail']);
    }

    /**
     * Change the resource status approve.
     * @param Mileage $mileage
     * @return JsonResponse
     */
    public function mileageApprove (Mileage $mileage)
    {
        $data = Mileage::findOrFail($mileage->id);
        $data->status = 'A';
        $data->save();

        if ($data->update()) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'fail']);
    }

    /**
     * Change the resource status reject.
     * @param Mileage $mileage
     * @return JsonResponse
     */
    public function mileageReject (Mileage $mileage)
    {
        $data = Mileage::findOrFail($mileage->id);
        $data->status = 'D';
        $data->save();

        if ($data->update()) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'fail']);
    }

    /**
     * Remove the specified resource from storage.
     * @param Mileage $mileage
     * @return JsonResponse
     */
    public function destroy (Mileage $mileage)
    {
        $mileage = Mileage::findOrFail($mileage->id);
        if ($mileage->delete() == 1) {
            $success = true;
            $message = "Mileage deleted successfully";
        } else {
            $success = false;
            $message = "Mileage not found";
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

}
