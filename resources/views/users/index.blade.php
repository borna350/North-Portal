@extends('layouts.main')

@section('title', 'Users')

@section('content1')
    <div class="well-default-trans">
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <h4>Employee List</h4>
                    {{--<input type="text" placeholder="Search user" onkeyup="searchAdmin()" class="form-control-new" name="search" id="search">--}}
                </div>
            </div>
            <div class="col-sm-1">
                <div id="wait"></div>
            </div>
            <div class="col-sm-9">
                <div class="form-group">
                    <a href="{{ route('users.create') }}" class="btn btn-success pull-right">Add User</a>
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-warning pull-right mr-2">Permissions</a>
                </div>
            </div>
        </div>

        <div id="wait" style="display:none;position:absolute;top:50%;left:50%;padding:2px;"><img src='{{ asset('img/demo_wait.gif') }}' width="64" height="64" /><br>Loading..</div>

        <table class="table _table _table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Date/Time Added</th>
                <th></th>
            </tr>
            </thead>

            <tbody id="users">
            @php $delSection = 'users'; @endphp
            </tbody>
        </table>

        <div id="paginate"></div>
    </div>

@endsection

@section('js')
    <script !src="">
        let from = to = null;
        function searchAdmin() {
            $('#users').html('');
            $('#wait').css('display', 'inline-block'); // wait for loader
            let search = $('#search').val();
            let data = {
                search: search,
                from: from,
                to: to,
            };

            $.ajax({
                type: 'get',
                url: "{{ route('users.search') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    $('#wait').css('display', 'none');

                    if (results.status == 200) {
                        renderHTML(results.data);
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        $(document).ready(function(){
            var date = new Date(), y = date.getFullYear(), m = date.getMonth();
            /*from = formatDate(new Date(y, m, 1));
            to = formatDate(new Date(y, m + 1, 0));*/
            searchAdmin();
            $('#date').flatpickr({
                mode: "range",
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: [from, to],
                onChange: function(selectedDates, dateStr, instance) {
                    from = formatDate(selectedDates[0]);
                    to = formatDate(selectedDates[1]);
                    if (selectedDates[0] === undefined || (selectedDates[0] !== undefined && selectedDates[1] !== undefined)) {
                        if (selectedDates[0] === undefined) {
                            from = to = null;
                        }
                        searchAdmin();
                    }
                },
            });

            setTimeout(function () {
                $('.deletejson').click(function ($e) {
                    $e.preventDefault();

                    if (confirm($confirmText)) {
                        const $id = $(this).data('id');
                        const $section = $(this).data('section');
                        const $url = $(this).data('url');
                        const $token = $(this).data('token');
                        console.log('deleting and hide row: ' + $section + ' - ' + $id + ' ... ');
                        $(".ajax-delete-msg").hide();

                        $.ajax({
                            url: $url,
                            data: {id: $id, _method: 'DELETE', '_token': $token, timeing: new Date()},
                            type: 'DELETE',
                            dataType: 'JSON',
                            cache: false,
                            success: function ($ret) {
                                $(".ajax-delete-msg").show(); // .fadeOut(6000);
                                $('.del-' + $section + '-' + $id).html($ret.msg).addClass('text-danger').hide("slow");
                            }
                        });
                    }
                });
            }, 1000);
        });

        function renderHTML(result) {
            $('#paginate').pagination({
                dataSource: result,
                pageSize: 10,
                totalNumber: result.length,
                callback: function(data, pagination) {
                    let html = '';
                    data.forEach(function myFunction(value, index, array) {
                        date = value.formatted_date;

                        html += `<tr class="del-{{ $delSection }}-${value.id}">
                        <td> ${value.name} ${is_admin === 1 && auth_id != value.id ? '<a class="remove-default-style" href="force-login/' + value.id + '"><i class="fa fa-sign-in"></i></a>' : ''}</td>
                        <td> ${value.email} </td>
                        <td> ${date} </td>
                        <td class="text-right">
                            <a href="{{ url('/') }}/users/${value.id}/edit">Edit</a>
                            <a class="down deletejson" data-token="{{ csrf_token() }}" data-url="{{ url('/') }}/users/${value.id}" data-id="${value.id}" data-section="{{ $delSection }}">Delete</a>
                        </td>
                    </tr><tr class="spacer"></tr>`;
                    });
                    $('#users').html(html);
                }
            });
        }
    </script>
@endsection
