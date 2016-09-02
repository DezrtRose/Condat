<section class="margin-to-up margin-to-down">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="{{ Request::is('tenant/client_invoice_report/invoice_pending') ? 'active' : '' }}"><a href="{{ route('client.invoice.pending') }}">Pending Invoices</a></li>
        
        <li class="{{ Request::is('tenant/client_invoice_report/invoice_paid') ? 'active' : '' }}"><a href="{{ route('client.invoice.paid') }}">Paid Invoices</a></li>
        
        <li class="{{ Request::is('tenant/client_invoice_report/invoice_future') ? 'active' : '' }}"><a href="{{ route('client.invoice.future') }}">Future Invoices</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</section>