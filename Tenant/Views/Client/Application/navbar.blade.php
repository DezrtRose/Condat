<?php $current = Request::segment(4); ?>
<div class="container">
    <div class="row">
        <div class="client-navbar" style="display: none;">
            @include('Tenant::Client/client_header')
        </div>
    </div>
    {{--<span class="btn btn-success btn-small btn-flat menu-toggle"><i class="fa fa-bars"></i> Toggle Client Menu</span>--}}

    <div class="row">
        {{--<div class="menu-opener">
            <span class="menu-opener-inner"></span>
        </div>--}}
    </div>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                {{--<a class="navbar-brand visible-xs" href="#">AMS</a>--}}
                <a class="navbar-brand menu-toggle" href=""><i class="fa fa-user"></i> Show Client Menu</a>
            </div>

            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="{{($current == 'show')? 'active' : ''}}"><a
                                href="{{route('tenant.application.show', $application->application_id)}}">Dashboard</a>
                    </li>
                    <li><a href="{{route('tenant.application.details', $application->application_id)}}">Application Details</a></li>
                    <li class="{{($current == 'details')? 'active' : ''}}"><a
                                href="{{route('tenant.application.college', $application->application_id)}}">College
                            Accounts</a></li>
                    <li class="{{($current == 'students')? 'active' : ''}}"><a
                                href="{{route('tenant.application.students', $application->application_id)}}">Students
                            Accounts</a></li>
                    <li class="{{($current == 'subagents')? 'active' : ''}}"><a
                                href="{{route('tenant.application.subagents', $application->application_id)}}">Sub Agent
                            Accounts</a></li>
                    <li><a href="{{url("tenant/clients/$client->client_id/innerdocument")}}">Documents</a></li>
                    <li class="{{($current == 'notes')? 'active' : ''}}"><a href="{{route('tenant.application.notes', $application->application_id)}}">Notes</a></li>
                </ul>
            </div>
            <!--/.nav-collapse -->

        </div>
        <!--/.container-fluid -->
    </nav>


    @if(isset($stats))
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Invoice Amount</span>
                        <span class="info-box-number">${{ $stats['invoice_amount'] }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Paid Amount</span>
                        <span class="info-box-number">${{ $stats['total_paid'] }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Due Amount</span>
                        <span class="info-box-number">${{ $stats['due_amount'] }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
    @endif
    @include('flash::message')
</div>

<script class="cssdeck" type="text/javascript">
    /*$(".menu-opener").click(function () {
     $(".menu-opener").toggleClass("active");
     $(".client-navbar, .menu-opener-inner").slideToggle();
     });*/

    $(".menu-toggle").click(function (e) {
        e.preventDefault();
        $(".client-navbar").slideToggle();
    });
</script>