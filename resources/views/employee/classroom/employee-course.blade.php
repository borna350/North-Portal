@extends('layouts.main',['activeMenu' => 'classroom'])
@section('title', $course->name)

@section('content1')

    {{--@if ($course->s3_path)
        <iframe name="pdf_iframe" src="{{ $course->s3_url }}" class="invoice-pdf-frame"></iframe>
    @endif--}}

    <div class="course-cover" style="background-image: url('{{ fileUrl($course->image_path) }}')">
        <div class="course_title">{{$course->name}}</div>
    </div>

    <div class="well-default-trans">
        <div class="tab-pane" id="nav-mileage" role="tabpanel" aria-labelledby="nav-mileage-tab">
            <div class="mileage inner-tab-box">
                <div class="col-md-12">
                    <div class="col-sm-12" id="pending_div">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table _table _table-bordered _table-v-middle">
                                    @php $sl = 0; @endphp
                                    @php $curStatus = ''; $curChapterID = 0; @endphp
                                    @foreach ($course->chapters()->withCount('questions')->get() AS $chapter)
                                        @php
                                            $sl++;
                                            $lastStatus = $curStatus; $curStatus = $course->getStatus($chapter->id);
                                            $lastChapterID = $curChapterID; $curChapterID = $chapter->id;
                                        @endphp
                                    <tr style="box-shadow: 1px 2px 5px #e6e6e6;">
                                        <td class="text-center" width="35px"><span class="chapter-node @if($curStatus == 'complete') completed @endif @if($curStatus == 'unavailable') unavailable @endif"></span></td>
                                        <td width="120px">Chapter {{$sl}}</td>
                                        <td>{{$chapter->chapter_name}}</td>
                                        <td class="text-right">@if($curStatus == 'complete')<a style="border: none" href="{{ route('employee.classroom.take-course',$chapter->id) }}"><img width="40px" src="{{asset('img/bicon.png')}}" alt="Report"></a>@endif</td>
                                        <td class="text-right" width="130px">
                                            @if($curStatus !== 'complete' && $curStatus !== 'unavailable')<a href="{{ route('employee.classroom.repeat-chapter',$chapter->id) }}?section=7&qid=20" class="completed m-f-w" >Start</a>@endif
                                            @if($curStatus == 'complete')<a href="javascript:void(0)" class="completed m-f-w" >Completed</a>@endif
                                            @if($curStatus == 'unavailable')<a href="javascript:void(0)" class="danger m-f-w" >Unavailable</a>@endif

                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <!-- repeat chapter -->
    <script type="text/javascript">
        $('.confirm-repeat').click(function () {
            return confirm('Are you sure you want to start over?  All your previous answers will be reset ... ');
        })
    </script>
@endpush
