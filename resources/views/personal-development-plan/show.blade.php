@extends('layouts.main')
@section('title', 'Personal development | Single view')
@section('content1')
        <div class="well-default-trans">
            <div class="row">
                <div class="col-sm-12">
                    <div class="text-center" style="width: 400px; margin: auto; ">
                        <h5 class="mb-3">
                            <span class="active-span" id="pending_span">{{$show->employee->firstname}} {{$show->employee->lastname}} Personal Development Plan</span>
                        </h5>
                        <div style="width: 100%; display: table; font-weight:500; font-size: 14px" class="mb-4">
                            <span class="float-left">Start Date : {{ date("j F, Y", strtotime($show->start_date)) }}</span>
                            <span class="float-right">End Date : {{date("j F, Y", strtotime($show->end_date)) }}</span>
                        </div>
                        @if(auth()->user()->id == $show->emp_id)
                            {{ Form::open(array('id'=>'personal_development_form')) }}
                            {!! Form::hidden('id', $show->id,['id' => 'personal_development_id']) !!}
                                <div class="text_outer">
                                    {!! Form::textarea('comment', null, ['id' => 'edit_comment', 'class' => 'form-control', 'placeholder' => 'write here.....', 'style' => 'min-height: 100px']) !!}
                                </div>
                                <div class="row margin-top-30">
                                    <div class="form-group" style="width:100%;">
                                        <div class="col-md-12 col-sm-12">
                                            <button type="button" onclick="{{ $show->comment ? 'updateComment' : 'createNewComment' }}()" class="btn-dark contact_btn" data-form="expences" id="create">Save</button>
                                        </div>
                                    </div>
                                </div>
                                {{ Form::close() }}
                        @else
                            <div style="width: 100%; display: table; font-weight:500; font-size: 14px" class="mb-4">
                                <span class="float-centre">Description : {{$show->description}}</span>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    <script type="text/javascript">
        let updateRoute = null;
        let route = '@php echo $route; @endphp';

        function createNewComment() {
            event.preventDefault();
            let id = $('#personal_development_id').val();
            $.ajax({
                method: "POST",
                url: route,
                data: new FormData(document.getElementById('personal_development_form')),
                dataType: 'JSON',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function (response) {
                    $.toaster({message: 'Created successfully', title: 'Success', priority: 'success'});
                }
            });
        }

        function updateComment() {
            event.preventDefault();
            let id = $('#personal_development_id').val();

            $.ajax({
                method: "POST",
                url: route,
                data: new FormData(document.getElementById('personal_development_form')),
                dataType: 'JSON',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function (response) {
                    $.toaster({message: 'Updated successfully', title: 'Success', priority: 'success'});
                }

            });
        }
    </script>
@endsection
