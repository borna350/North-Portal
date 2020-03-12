<?php

namespace App\Http\Controllers;

use App\Mail\NotifyAdmin;
use App\Message;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index ()
    {
        if (auth()->user()->is_admin) {
            $activeMenu = 'admin';
        } else {
            $activeMenu = 'submit';
        }

        return view('concern.index', compact('activeMenu'));
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store (Request $request)
    {
        // Validate form data
        $rules = [
            'subject' => 'required|string|max:191',
            'description' => 'required|string',
            'emp_id' => 'required|integer',
        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 200, 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            $input = $request->all();
            $input['is_anonymous'] = isset($request->is_anonymous) ? 1 : 0;
            $input['is_contact'] = isset($request->is_contact) ? 1 : 0;
            $message = Message::create($input);

            Mail::to(User::where('is_admin', 1)->pluck('email'))->send(new NotifyAdmin($request));

            return response()->json(['status' => 200, 'data' => $message]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Message $message
     * @return JsonResponse
     */
    public function show (Message $message)
    {
        try {
            $message = Message::findOrFail($message->id);

            return response()->json(['status' => 200, 'data' => $message]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Message $message
     * @return JsonResponse
     */
    public function edit (Message $message)
    {
        try {
            $message = Message::findOrFail($message->id);

            return response()->json(['status' => 200, 'data' => $message]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Message $message
     * @return JsonResponse
     */
    public function update (Request $request, Message $message)
    {
        // Validate form data
        $rules = [
            'subject' => 'required|string|max:191',
            'description' => 'required|string',
            'emp_id' => 'required|integer',
        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 200, 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            $message = Message::findOrFail($message->id);
            $message->subject = $request->subject;
            $message->description = $request->description;
            $message->is_anonymous = isset($request->is_anonymous) ? 1 : 0;
            $message->is_contact = isset($request->is_contact) ? 1 : 0;
            $message->emp_id = $request->emp_id;
            $message->save();

            Mail::to(User::where('is_admin', 1)->pluck('email'))->send(new NotifyAdmin($request));

            return response()->json(['status' => 200, 'data' => $message]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Message $message
     * @return JsonResponse
     */
    public function destroy (Message $message)
    {
        try {
            Message::destroy($message->id);

            return response()->json(['status' => 200, 'message' => 'Message deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Filter agreement
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function search (Request $request)
    {
        try {
            $data = Message::where(function ($q) use ($request) {
                if (isset($request->search)) {
                    $q->where(function ($query) use ($request) {
                        $query->where('subject', 'like', '%' . $request->search . '%')
                            ->orWhere('description', 'like', '%' . $request->search . '%')
                            ->orWhere('created_at', 'like', '%' . $request->search . '%');
                    });
                }
                if ($request->id == 'history') {
                    $q->whereNotNull('status');
                } else {
                    $q->whereNull('status');
                }
            })->isEmployee()->dateSearch()->get();

            if (count($data)) {
                foreach ($data as $datum) {
                    $routes = [];
                    $routes['show'] = route('messages.show', $datum->id);
                    $routes['edit'] = route('messages.edit', $datum->id);
                    $routes['update'] = route('messages.update', $datum->id);
                    $routes['destroy'] = route('messages.destroy', $datum->id);
                    $routes['status'] = route('messages.status.update', $datum->id);
                    $datum->routes = $routes;
                }
            }

            foreach ($data as $key => $datum) {
                if (auth()->user()->is_admin == 0 && ($datum->is_anonymous || $datum->is_contact)) {
                    $data->forget($key);
                }

                $datum->created_at_formatted = date('d M, Y', strtotime($datum->created_at));
            }

            return response()->json(['status' => 200, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Message $message
     * @return JsonResponse
     */
    public function statusUpdate (Request $request, Message $message)
    {
        try {
            $message = Message::findOrFail($message->id);
            $message->status = 1;
            $message->save();

            return response()->json(['status' => 200, 'message' => 'Status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}
