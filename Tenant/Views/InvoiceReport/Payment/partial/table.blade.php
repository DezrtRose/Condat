<table id="payments" class="table table-bordered table-striped dataTable">
    <thead>
    <tr>
        <th>Payment ID</th>
        <th>Payment Date</th>
        <th>Amount</th>
        <th>Payment Type</th>
        <th>Invoice Id</th>
        <th>Description</th>
        <th></th>
    </tr>
    </thead>
    <tbody> <?php //dd($payments->toArray()) ?>

    @foreach($payments as $key => $payment)
        <tr>
            <td>{{ format_id($payment->client_payment_id, 'CPI') }}</td>
            <td>{{ format_date($payment->date_paid) }}</td>
            <td>{{ format_price($payment->amount) }}</td>
            <td>{{ $payment->payment_type }}</td>
            <td>{{ format_id($payment->invoice_id, 'SI')}}</td>
            <td>{{ $payment->description }}</td>
            <td>
                <a href="{{url("tenant/students/payment/receipt/" . $payment->student_payments_id)}}" title="Print Payment"><i
                            class="processing btn btn-primary btn-sm glyphicon glyphicon-print"
                            data-toggle="tooltip" data-placement="top"
                            title="Print Payment"></i></a>
                <a href="{{route("application.students.editPayment", $payment->student_payments_id)}}" title="Edit Payment"><i
                            class="processing btn btn-primary btn-sm glyphicon glyphicon-pencil"
                            data-toggle="tooltip" data-placement="top" title="Edit Payment"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>