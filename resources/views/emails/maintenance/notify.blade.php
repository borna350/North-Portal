@component('mail::message')
# Tech maintenance ticket

<table style="width: 600px">
    <tr>
        <th style="text-align:left;width: 110px">Subject</th>
        <td>{{ $data->subject }}</td>
    </tr>
    <tr>
        <th style="text-align:left;width: 110px">Description</th>
        <td>{{ $data->description }}</td>
    </tr>
    <tr>
        <th style="text-align:left;width: 110px">Website</th>
        <td>{{ $data->website }}</td>
    </tr>
    <tr>
        <th style="text-align:left;width: 110px">Priority</th>
        <td>
            @if($data->priority == 1)
                Low
            @elseif($data->priority == 2)
                Normal
            @else
                Critical
            @endif
        </td>
    </tr>
    <tr>
        <th style="text-align:left;width: 110px">Category</th>
        <td>{{ $data->category ? \App\Categorys::find($data->category)->categoryname : '' }}</td>
    </tr>
</table>

@component('mail::button', ['url' => route('maintenance_tickets.index')])
Edit
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
