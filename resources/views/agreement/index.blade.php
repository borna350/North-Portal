@extends('layouts.main')
@section('title', 'Agreement')
@section('content1')
    <div class="well-default-trans">
        <div class="tab-pane fade employeeagreements" id="nav-agreements" role="tabpanel">
            <h3>Agreement</h3>
            <div style="width:100%;">
                <table style="width:100%;">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Employee Name</th>
                        <th>Employee Agreement</th>
                        <th>Code of Conduct</th>
                    </tr>
                    </thead>
                    @if (isset($employee))
                        @foreach ($employee as $user)
                            <tbody>
                            <tr style="margin-bottom:10px;">
                                <td>{{$user->created_at}}</td>
                                <td>{{$user->firstname}}</td>
                                <td>
                                    @if($user->agreement)
                                        <a href="javascript:void(0);" onclick="show_modal_agreement('{{$user->id}}','EA')">Edit</a>
                                        <a href="{{asset('agreement/'.$user->agreement)}}" target="_blank">View</a>
                                        <a href="javascript:void(0);" onclick="delete_agreement('{{$user->id}}','EA')" class="down">DELETE</a>
                                    @else
                                        <a href="javascript:void(0);" onclick="show_modal_agreement('{{$user->id}}','EA')">Upload</a>
                                    @endif
                                </td>
                                <td>
                                    @if($user->coc_agreement)
                                        <a href="javascript:void(0);" onclick="show_modal_agreement('{{$user->id}}','COC')">Edit</a>
                                        <a href="{{asset('codeofconduct/'.$user->coc_agreement)}}" target="_blank">View</a>
                                        <a href="javascript:void(0);" onclick="delete_agreement('{{$user->id}}','COC')" class="down">DELETE</a>
                                    @else
                                        <a href="javascript:void(0);" onclick="show_modal_agreement('{{$user->id}}','COC')">Upload</a>
                                    @endif
                                </td>
                            </tr>
                            <tr class="spacer"></tr>
                            </tbody>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection
