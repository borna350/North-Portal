@component('mail::message')
# Expense {{ $isUpdate ? 'updated' : 'created' }}

<table style="width: 600px">
    <tr>
        <th style="text-align:left;width: 110px">Company</th>
        <td>{{ $data->company ? \App\Company::find($data->company)->companyname : '' }}</td>
    </tr>
    <tr>
        <th style="text-align:left;width: 110px">Date</th>
        <td>{{ date('d M, Y', strtotime($data->date)) }}</td>
    </tr>
    <tr>
        <th style="text-align:left;width: 110px">Category</th>
        <td>{{ $data->category ? \App\Categorys::find($data->category)->categoryname : '' }}</td>
    </tr>
    <tr>
        <th style="text-align:left;width: 110px">Purchase via</th>
        <td>{{ $data->purchase ? \App\Purchases::find($data->purchase)->purchasename : '' }}</td>
    </tr>
    <tr>
        <th style="text-align:left;width: 110px">Project</th>
        <td>{{ $data->project ? \App\Project::find($data->project)->projectname : '' }}</td>
    </tr>
    <tr>
        <th style="text-align:left;width: 110px">Receipt</th>
        <td><a href="{{ fileUrl($data->receipt) }}">{{ fileUrl($data->receipt) }}</a></td>
    </tr>
    <tr>
        <th style="text-align:left;width: 110px">Description</th>
        <td>{{ $data->description }}</td>
    </tr>
    <tr>
        <th style="text-align:left;width: 110px">Subtotal</th>
        <td>{{ $data->subtotal }}</td>
    </tr>
    <tr>
        <th style="text-align:left;width: 110px">GST</th>
        <td>{{ $data->gst }}</td>
    </tr>
    <tr>
        <th style="text-align:left;width: 110px">PST</th>
        <td>{{ $data->pst }}</td>
    </tr>
    <tr>
        <th style="text-align:left;width: 110px">Total</th>
        <td>{{ $data->total }}</td>
    </tr>
</table>

@component('mail::button', ['url' => url('expenses')])
Edit
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
