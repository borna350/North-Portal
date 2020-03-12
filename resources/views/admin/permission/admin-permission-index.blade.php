@extends('layouts.main')

@section('title','Admin Permissions')

@section('content1')
    <div class="well-default-trans">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="text-left">Roles</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <a class="btn btn-primary" href="{{ route('admin.roles.create') }}"><i class="fa fa-plus fa-sm"></i> Add Category</a>
                    <a class="btn btn-primary" href="{{ route('admin.permissions.create') }}"><i class="fa fa-plus fa-sm"></i> Add Permission</a>
                </div>
                <div class="col-sm-12">
                    <br>
                    <table class="table _table _table-bordered">
                        @foreach ($roles AS $role)
                            <tr class="del-role-{{ $role->id }}">
                                <td><a href="{{ route('admin.roles.edit',$role->id) }}">{{ $role->name }}</a></td>
                                <td class="text-right">
                                    <a class="text-danger deletejson" data-token="{{ csrf_token() }}" data-url="{{ route('admin.roles.destroy',$role->id) }}" data-id="{{ $role->id }}" data-section="role">Delete</a>
                                </td>
                            </tr>
                            <tr class="spacer">
                            @foreach ($role->permissions()->orderBy('orderval')->orderBy('name')->get() AS $permission)
                                <tr class="del-permission-{{ $permission->id }}">
                                    <td class="text-right"><a href="{{ route('admin.permissions.edit',$permission->id) }}">{{ $permission->orderval }}) {{ $permission->name }}</a></td>
                                    <td class="text-right">
                                        <a class="text-danger deletejson" data-token="{{ csrf_token() }}" data-url="{{ route('admin.permissions.destroy',$permission->id) }}" data-id="{{ $permission->id }}" data-section="permission">Delete</a>
                                    </td>
                                </tr><tr class="spacer">
                            @endforeach
                            <tr class="spacer">
                            <tr class="spacer">
                            <tr class="spacer">
                            <tr class="spacer">
                            <tr class="spacer">
                        @endforeach
                    </table>
                </div>
            </div>


        </div>
    </div>

@endsection
