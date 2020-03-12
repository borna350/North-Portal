<?php

namespace App\Http\Controllers;

use App\{Agreement, CodeOfConduct, EmployeeDetails};
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\View\View;

class AgreementController extends Controller
{
    /**
     * @return Factory|View
     */
    function index ()
    {
        $activeMenu = 'profile';
        $q = EmployeeDetails::orderBy('firstname')->with('activeAgreement', 'activeCodeofconduct', 'activeAgreement.amendments');

        /// if employee is not admin
        if (auth()->user()->is_admin == 0) {
            $q->where('id', auth()->user()->id);
        }
        $users = $q->get();

        return view('agreement-list-new', compact('users', 'activeMenu'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    function store (Request $request)
    {
        $conditions = ['emp_id' => $request->input('employee_id'), 'status' => 'A'];

        // get file upload type
        $type = $request->input('agreement_type') == 'EA' ?: 'COC';
        // set file directory for upload
        $path = $type == 'EA' ? 'agreement' : 'codeofconduct';

        try {
            if ($request->hasFile('agreement_file')) {

                $name = fileUpload('agreement_file',Agreement::$agreementFileLocation,true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'File not saved');
        }

        if ($type == 'EA') {
            // if it is an amendment, then attach it to an agreement
            if ($request->input('is_amendment', false)) {
                $currentAgreement = Agreement::where($conditions)->first();
                Agreement::create([
                    'emp_id' => $request->employee_id,
                    'agreement' => $name,
                    'parent_id' => $currentAgreement['id']
                ]);
                $msg = 'Agreement added successfully';
            } else {
                // set old agreement, if it exists, to "D"
                Agreement::where($conditions)->update(['status' => 'D']);
                Agreement::create([
                    'emp_id' => $request->employee_id,
                    'agreement' => $name
                ]);

                $msg = 'Agreement updated successfully';
            }
        } elseif ($type == 'COC') {
            // set old agreement, if it exists, to "D"
            CodeOfConduct::where($conditions)->update(['status' => 'D']);

            CodeOfConduct::create([
                'emp_id' => $request->employee_id,
                'coc_agreement' => $name,
            ]);
            $msg = 'Code of conduct updated successfully';
        }
        return redirect()->back()->with('alert-info', $msg);
    }

    /**
     * Filter agreement
     * @param Request $request
     * @return JsonResponse
     */
    public function search (Request $request)
    {
        try {
            $q = EmployeeDetails::latest()->with('activeAgreement', 'activeCodeofconduct', 'activeAgreement.amendments');

            if (!auth()->user()->is_admin) {
                $q->where('id', auth()->user()->id);
            }

            if ($search = $request->input('search')) {
                $q->where(DB::raw("CONCAT(firstname, ' ', lastname)"), 'like', '%' . $search . '%');
            }
            $data = $q->get();

            foreach ($data as $datum) {
                $datum->formatted_date = $datum->created_at ? $datum->created_at->format('M d, Y') : 'N/A';

                if ($datum->activeAgreement) {
                    $datum->active_agreement_url = fileUrl($datum->activeAgreement->agreement, true);

                    $routes = [];
                    $routes['destroy'] = route('agreements.destroy', $datum->activeAgreement->id);
                    $datum->active_agreement_routes = $routes;

                    if (count($datum->activeAgreement->amendments)) {
                        foreach ($datum->activeAgreement->amendments as $amendment) {
                            $amendment->amendment_url = fileUrl($amendment->agreement, true);

                            $routes = [];
                            $routes['destroy'] = route('agreements.destroy', $amendment->id);
                            $amendment->amendment_routes = $routes;
                        }
                    }
                }

                if ($datum->activeCodeofconduct) {
                    $datum->active_code_of_conduct_url = fileUrl($datum->activeCodeofconduct->coc_agreement, true);

                    $routes = [];
                    $routes['destroy'] = route('agreements.destroy', $datum->activeCodeofconduct->id);
                    $datum->active_code_of_conduct_routes = $routes;
                }
            }

            return response()->json(['status' => 200, 'data' => $data]);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Agreement $agreement
     * @param Request $request
     * @return JsonResponse
     */
    function destroy (Agreement $agreement, Request $request)
    {
        if ($request->type == 'EA') {
            $agreement = Agreement::where('id', $agreement->id)->first();
        } else {
            $agreement = CodeOfConduct::where('id', $agreement->id)->first();
        }

        $agreement->delete();
        return response()->json([
            'success' => 'Agreement deleted successfully!'
        ]);
    }
}
