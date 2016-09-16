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
        <li class="{{ Request::is('tenant/client/payments') ? 'active' : '' }}"><a href="{{ route('accounts.client.payments') }}">Client Payments</a></li>
        
        <li class="{{ Request::is('tenant/institutes/payments') ? 'active' : '' }}"><a href="{{ route('accounts.institutes.payments') }}">Institute Payments</a></li>
        
        <li class="{{ Request::is('tenant/subagent/payments') ? 'active' : '' }}"><a href="{{ route('accounts.subagent.payments') }}">SubAgent Payments</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</section>