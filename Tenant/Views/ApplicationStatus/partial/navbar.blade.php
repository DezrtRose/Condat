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
        <li class="{{ Request::is('tenant/applications/enquiry', 'tenant/applications/*/apply_offer', 'tenant/applications/*/cancel_application') ? 'active' : '' }}"><a href="{{ route('applications.enquiry.index') }}">Enquiry</a></li>
        
        <li class=" {{ Request::is('tenant/applications/offer_letter_processing', 'tenant/applications/*/offer_letter_received') ? 'active' : '' }}"><a href="{{ route('applications.offer_letter_processing.index')}}">Offer letter processing</a></li>
        
        <li class="{{ Request::is('tenant/applications/offer_letter_issued', 'tenant/applications/*/coe_processing', 'tenant/applications/*/apply_coe' ) ? 'active' : ''}}" ><a href="{{ route('applications.offer_letter_issued.index') }}">Offer letter issued</a></li>
        
        <li class="{{ Request::is('tenant/applications/coe_processing', 'tenant/applications/*/coe_issued', 'tenant/applications/*/COE_issued') ? 'active' : ''}}" ><a href="{{ route('applications.coe_processing.index') }}">COE processing</a></li>
        
        <li class="{{ Request::is('tenant/applications/coe_issued') ? 'active' : ''}}" ><a href="{{ route('applications.coe_issued.index') }}">COE issued</a></li>
        
        <li class="{{ Request::is('tenant/applications/enrolled') ? 'active' : ''}}" ><a href="#">Enrolled</a></li>
        
        <li class="{{ Request::is('tenant/applications/completed') ? 'active' : ''}}" ><a href="#">Completed</a></li>
        
        <li class="{{ Request::is('tenant/applications/cancelled') ? 'active' : ''}}" ><a href="#">Cancelled</a></li>
        
        <li class="{{ Request::is('tenant/applications/advanced_search') ? 'active' : ''}}" ><a href="#">Advanced search</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</section>