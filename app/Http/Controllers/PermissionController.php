<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{RedirectResponse, Request};

//Importing laravel-permission models
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\{Role, Permission};

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index ()
    {
        if (auth()->user()->is_admin == 1) {
            $permissions = Permission::all(); //Get all permissions
            return view('permissions.index')->with('permissions', $permissions);
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create ()
    {
        if (auth()->user()->is_admin == 1) {
            $roles = Role::get(); //Get all roles
            return view('permissions.create')->with('roles', $roles);
        } else {
            abort(401);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store (Request $request)
    {
        if (auth()->user()->is_admin == 1) {
            $this->validate($request, [
                'name' => 'required|max:40',
            ]);
            $name = $request['name'];
            $permission = new Permission();
            $permission->name = $name;
            $roles = $request['roles'];
            $permission->save();

            if (!empty($request['roles'])) { //If one or more role is selected
                foreach ($roles as $role) {
                    $r = Role::where('id', '=', $role)->firstOrFail(); //Match input role to db record

                    $permission = Permission::where('name', '=', $name)->first(); //Match input //permission to db record
                    $r->givePermissionTo($permission);
                }
            }

            return redirect()->route('permissions.index')->with('alert-info', 'Permission' . $permission->name . ' added!');
        } else {
            abort(401);
        }
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return RedirectResponse|Redirector
     */
    public function show ($id)
    {
        if (auth()->user()->is_admin == 1) {
            return redirect('permissions');
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Factory|View
     */
    public function edit ($id)
    {
        if (auth()->user()->is_admin == 1) {
            $permission = Permission::findOrFail($id);
            return view('permissions.edit', compact('permission'));
        } else {
            abort(401);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update (Request $request, $id)
    {
        if (auth()->user()->is_admin == 1) {
            $permission = Permission::findOrFail($id);
            $this->validate($request, [
                'name' => 'required|max:40',
            ]);
            $input = $request->all();
            $permission->fill($input)->save();

            return redirect()->route('permissions.index')->with('alert-info', 'Permission' . $permission->name . ' updated!');
        } else {
            abort(401);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy ($id)
    {
        $permission = Permission::findOrFail($id);

        //Make it impossible to delete this specific permission
        if ($permission->name == "Admin Panel") {
            return redirect()->route('permissions.index')->with('alert-info', 'Cannot delete this Permission!');
        }
        $permission->delete();

        return redirect()->route('permissions.index')->with('alert-info', 'Permission deleted!');
    }
}
