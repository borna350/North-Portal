<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\{Mail\MaintenanceNotify, User, Expenses, Company, Project, Purchases, Categorys, MaintenanceTicket};
use DB;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    function index ()
    {
        if (auth()->user()->is_admin) {
            $activeMenu = 'admin';
        }
        else {
            $activeMenu = 'submit';
        }
        $data['maintanance'] = MaintenanceTicket::where(['delete_status' => NULL, 'status' => NULL])->with('employee:id,firstname,lastname')->get();
        $data['maintanance1'] = MaintenanceTicket::where(['delete_status' => NULL, 'status' => 1])->orWhere(['status' => 2])->with('employee:id,firstname,lastname')->get();
        $data['category'] = Categorys::all();
        $data['users'] = User::where('is_admin', 0)->get();
        return view('maintenance.index', $data, compact('activeMenu'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    function store (Request $request) {
        $request->validate([
            'user' => 'nullable|array'
        ]);
        $data = $request->all();
        unset($data['user']);
        $maintenance = MaintenanceTicket::create($data);

        if (count($request->user)) {
            $maintenance->users()->attach($request->user);
            Mail::to(User::find($request->user)->pluck('email'))->send(new MaintenanceNotify($request));
        }
        $msg = 'Ticket Added successfully';
        return redirect()->back()->with('alert-info', $msg);
    }

    /**
     * Show the form for editing the specified resource.
     * @param MaintenanceTicket $maintenanceTicket
     * @return JsonResponse
     */
    function edit (MaintenanceTicket $maintenanceTicket)
    {
        try {
            $data = MaintenanceTicket::with('users')->findOrFail($maintenanceTicket->id);

            return response()->json(['status' => 200, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param MaintenanceTicket $maintenanceTicket
     * @return RedirectResponse
     */
    function update (Request $request, MaintenanceTicket $maintenanceTicket)
    {
        $id = $maintenanceTicket->id;
        $data = $request->except('_method');
        unset($data['user']);
        $try = MaintenanceTicket::where(['id' => $id])->update($data);
        $maintenance = MaintenanceTicket::findOrFail($id);
        $msg = 'Updated a ticket';
        $maintenance->users()->detach();

        if (count($request->user)) {
            $maintenance->users()->attach($request->user);
            Mail::to(User::find($request->user)->pluck('email'))->send(new MaintenanceNotify($request));
        }

        return redirect()->back()->with('alert-info', $msg);
    }

    /**
     * Remove the specified resource from storage.
     * @param MaintenanceTicket $maintenanceTicket
     * @return JsonResponse
     */
    function destroy (MaintenanceTicket $maintenanceTicket)
    {
        MaintenanceTicket::destroy($maintenanceTicket->id);
        $msg = 'Ticket deleted';
        session()->flash('alert-info', $msg);

        return response()->json(['success']);
    }

    /**
     * Change ticket status in progress
     * @param MaintenanceTicket $maintenanceTicket
     * @return JsonResponse
     */
    function ticketInProgress (MaintenanceTicket $maintenanceTicket)
    {
        $id = $maintenanceTicket->id;
        MaintenanceTicket::where(['id' => $id])->update(['status' => 1]);

        return response()->json(['status' => 200]);
    }

    /**
     * Change ticket status in cancel
     * @param MaintenanceTicket $maintenanceTicket
     * @return JsonResponse
     */
    public function ticketCancel (MaintenanceTicket $maintenanceTicket)
    {
        $id = $maintenanceTicket->id;
        MaintenanceTicket::where(['id' => $id])->update(['status' => 2]);

        return response()->json(['status' => 200]);
    }

    /**
     * Filter agreement
     * @param Request $request
     * @return JsonResponse
     */
    public function search (Request $request)
    {
        try {
            $tagged = [];
            if (!auth()->user()->is_admin) {
                $tagged = array_unique(auth()->user()->tickets->pluck('id')->toArray());
                $ids = MaintenanceTicket::where('emp_id', auth()->user()->id)->pluck('id')->toArray();
                $tagged = array_merge($tagged, $ids);
            }
            $data = MaintenanceTicket::select('maintenance_tickets.*')
                ->with('employee')
                ->leftjoin('employee_details AS emp', 'emp.id', '=', 'maintenance_tickets.emp_id')
                ->where(function ($q) use ($request, $tagged) {
                    if (isset($request->search)) {
                        $q->where(function ($query) use ($request) {
                            $query->where('maintenance_tickets.subject', 'like', '%' . $request->search . '%')
                                ->orWhere('maintenance_tickets.status', 'like', '%' . $request->search . '%')
                                ->orWhere(DB::raw("CONCAT(emp.firstname, ' ', emp.lastname)"), 'like', '%' . $request->search . '%')
                                ->orWhere('maintenance_tickets.updated_at', 'like', '%' . $request->search . '%');
                        });
                    }
                    if (isset($request->from) && isset($request->to)) {
                        $q->whereBetween('maintenance_tickets.updated_at', [$request->from, $request->to]);
                    }
                    if ($request->id == 'completed') {
                        $q->where('maintenance_tickets.status', '>', 0);
                    } else {
                        $q->whereNull('maintenance_tickets.status');
                    }
                    if (!auth()->user()->is_admin) {
                        $q->whereIn('maintenance_tickets.id', $tagged);
                    }
                })->get();

            if (count($data)) {
                foreach ($data as $datum) {
                    $routes = [];
                    $routes['commentStore'] = route('maintenance_tickets.comment.store', $datum->id);
                    $routes['commentUpdate'] = route('maintenance_tickets.comment.update', $datum->id);
                    $routes['edit'] = route('maintenance_tickets.edit', $datum->id);
                    $routes['update'] = route('maintenance_tickets.update', $datum->id);
                    $routes['show'] = route('maintenance_tickets.show', $datum->id);
                    $routes['destroy'] = route('maintenance_tickets.destroy', $datum->id);
                    $routes['ticket_inprogress'] = route('maintenance_tickets.ticket_inprogress', $datum->id);
                    $routes['ticket_cancel'] = route('maintenance_tickets.ticket_cancel', $datum->id);
                    $datum->routes = $routes;
                }
            }

            foreach ($data as $datum) {
                $datum->updated_at_formatted = date('d M, Y', strtotime($datum->updated_at));
            }
            return response()->json(['status' => 200, 'data' => $data]);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     * @param MaintenanceTicket $maintenanceTicket
     * @return Factory|View
     */
    public function show (MaintenanceTicket $maintenanceTicket)
    {
        if (auth()->user()->is_admin) {
            $activeMenu = 'admin';
        } else {
            $activeMenu = 'submit';
        }

        $show = MaintenanceTicket::with('employee')->findOrFail($maintenanceTicket->id);

        if ($show->comment) {
            $route = route('maintenance_tickets.comment.update', $show->id);
        } else {
            $route = route('maintenance_tickets.comment.store', $show->id);
        }

        $editRoute = route('maintenance_tickets.edit', $maintenanceTicket->id);
        $deleteRoute = route('maintenance_tickets.destroy', $maintenanceTicket->id);

        return view('maintenance.show', compact('show', 'user', 'activeMenu', 'route', 'editRoute', 'deleteRoute'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @param MaintenanceTicket $maintenanceTicket
     * @return JsonResponse
     */
    public function commentStore (Request $request, MaintenanceTicket $maintenanceTicket)
    {
        $rules = [
            'comment' => 'string|max:491',
        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            $data = MaintenanceTicket::findOrFail($maintenanceTicket->id);
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
     * @param Request $request
     * @param MaintenanceTicket $maintenanceTicket
     * @return JsonResponse
     */
    public function commentUpdate (Request $request, MaintenanceTicket $maintenanceTicket)
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
            $data = MaintenanceTicket::findOrFail($maintenanceTicket->id);
            $data->comment = $request->comment;

            if ($data->update()) {
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'fail']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }
    }
}
