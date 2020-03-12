<?php

namespace App\Http\Controllers;

use App\Journal;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class JournalController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index () {
        $data = Journal::get();
        $activeMenu = 'classroom';
        return view('journal.index', compact('activeMenu'))->with('data', $data);
    }

    /**
     * Filter journal
     * @param Request $request
     * @return JsonResponse
     */
    public function searchJournal (Request $request) {

        $data = $this->_searchJournal('search');
        if (count($data)) {
            foreach ($data as $datum) {
                $routes = [];
                $routes['edit'] = route('journal.edit', $datum->id);
                $routes['update'] = route('journal.store', $datum->id);
                $routes['destroy'] = route('journal.destroy', $datum->id);
                $datum->routes = $routes;
                $datum->formatted_date = $datum->date->format('M d, Y');
            }
        }
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * @param $searchField
     *
     * @return mixed
     */
    private function _searchJournal ($searchField) {
        $query = Journal::orderByDesc('date');
        $query->dateSearch('date');
        return $query->get();
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store (Request $request) {
        $rules = [
            'date'    => 'required',
            'title'   => 'required|string|max:191',
            'details' => 'required|string|max:491',
        ];
        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {

            $data = $request->all();
            $id = $request->input('id');
            if ($id) {
                $check = Journal::findOrFail($id);
                $check->update($data);
            }
            else {
                $check = Journal::create($data);
            }

            if ($check) {
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'fail']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Journal $journal
     *
     * @return JsonResponse
     */
    public function edit (Journal $journal) {
        return response()->json(['status' => 'success', 'data' => $journal]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Journal $journal
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy (Journal $journal) {

        if ($journal->delete() == 1) {
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
