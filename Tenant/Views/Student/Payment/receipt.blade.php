<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sample Invoice</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-xs-6">
            <h1>

                <img src="sample invoice_files/logo.png" height="50px">

            </h1>
        </div>
        <div class="col-xs-6 text-right">
            <h2>PAYMENT RECEIPT</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>{{ $agency->name }}</h4>
                </div>
                <div class="panel-body">
                    <p>{{ $agency->abn }}

                    <h3>
                        <small>{{ $agency->street }}</small>
                    </h3>
                    <h3>
                        <small>{{ $agency->suburb }} {{ $agency->state }} {{ $agency->postcode }}</small>
                    </h3>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-5 col-xs-offset-2 text-right">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Paid By</h4>
                </div>
                <div class="panel-body">
                    <p>
                        Thom Zheng

                    <h3>
                        <small>Receipt No #{{ format_id($payment->student_payments_id, 'SI') }}</small>
                    </h3>
                    <h3>
                        <small>Payment Date {{ format_date($payment->date_paid) }}</small>
                    </h3>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- / end client details section -->
    <table class="table table-bordered">
        <thead class="thead-default">
        <tr>

            <th>
                <h4>Description</h4>
            </th>
            <th>
                <h4>Payment Method</h4>
            </th>

            <th class="text-right">
                <h4>Amount</h4>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>

            <td>{{ $payment->description }}</td>
            <td>{{ $payment->payment_method }}</td>
            <td class="text-right">${{ float_format($payment->amount) }}</td>

        </tr>

        </tbody>
    </table>
    <div class="row Text-center">

        <p>
        <h4>
            THANK YOU FOR YOUR PAYMENT
        </h4>
        </p>
        <p>
            &nbsp;
        </p>


    </div>
    <div class="row">
        <div class="col-xs-5">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4>Bank details</h4>
                </div>
                <div class="panel-body">
                    <p>{{ $bank['account_name'] }}</p>

                    <p><strong>BSB</strong> : {{ $bank['bsb'] }} | <strong>Account Number</strong>
                        : {{ $bank['number'] }}</p>

                    <p>{{ $bank['name'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-xs-7">
            <div class="span7">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4>Contact Details</h4>
                    </div>
                    <div class="panel-body">
                        <p><strong>Ph</strong> : {{ $agency->number }} </p>

                        <p><strong>Email</strong> : {{ $agency->email }} </p>

                        <p><strong>Website</strong> : {{ $agency->website }}</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>