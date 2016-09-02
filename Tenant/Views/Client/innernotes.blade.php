@extends('layouts.tenant')
@section('title', 'Client View')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/client')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
@stop
@section('content')

     <div class="container">
        <div class="row">
            <div class="client-navbar">
                <div class="col-sm-12 col-md-2">
                    <div class="container">
                        <img src="https://scontent-lax3-1.xx.fbcdn.net/v/t1.0-9/1936510_10207216981375364_4596889339024157957_n.jpg?oh=f3031e9add8769ca489e5865a54b6bc4&oe=57B0E02E"
                             class="img-rounded" alt="Cinque Terre" width="150" height="150">
                    </div>
                </div>
                <div class="col-sm-12 col-md-10">
                    <div class="row">
                        <h4>{{$client->first_name}} {{$client->middle_name}} <b>{{$client->last_name}}</b></h4>

                        <p>University of Western Sydney</p>

                        <p>
                            Graduate Diploma of Professional Accounting
                        </p>
                    </div>
                    <div class="row">
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li><a href={{url("tenant/clients/$client->client_id")}}>Dashboard</a></li>
                                <li><a href={{url("tenant/clients/$client->client_id/personal_details")}}>Personal
                                        Details</a></li>
                                <li class="active"><a href={{url("tenant/clients/$client->client_id/applications")}}>College
                                        Application</a></li>
                                <li><a href={{url("tenant/clients/$client->client_id/accounts")}}>Accounts</a></li>
                                <li><a href={{url("tenant/clients/$client->client_id/document")}}>Documents</a></li>
                                <li><a href={{url("tenant/clients/$client->client_id/notes")}}>Notes</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>

    <div class="content">
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
                <a class="navbar-brand visible-xs" href="#">AMS</a>
                <a class="navbar-brand menu-toggle" href="#"><i class="fa fa-user"></i> Show Client Menu</a>
            </div>

            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Dashboard</a></li>
                    <li><a href="#">Application Details</a></li>
                    <li><a href="#">College Invoice</a></li>
                    <li><a href="#">Students Payments</a></li>
                    <li><a href="#">Sub Agent Payments</a></li>
                    <li ><a href="{{url("tenant/clients/$client->client_id/innerdocument")}}">Documents</a></li>
                    <li><a href="{{url("tenant/clients/$client->client_id/innernotes")}}">Notes</a></li>
                </ul>
            </div>
            <!--/.nav-collapse -->

        </div>
        <!--/.container-fluid -->
    </nav>

   
    <div class="col-xs-12 mainContainer">
        @include('flash::message')

         <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add Notes:</h3>
            </div>

            <!-- /.box-header -->
            <div class="box-body">

                <form action='' method="POST">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <textarea name="description" class="form-control" id="description"></textarea>
                    </div>
                    <div class="checkbox form-group">
                        <label><input type="checkbox" id="remind" name="remind" value="1"> Add to Reminder</label>
                    </div>
                    <div id="reminderDate" style="display: none">
                        <div class="form-group">
                            <label for="reminder_date" class="control-label">Reminder Date</label>

                            <div class="">
                                <div class='input-group date'>
                                    <input type="text" name="reminder_date" class="form-control datepicker"
                                           id="reminder_date" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>


            </div>
        </div>
        <!-- /.box -->
    </div>

   
    <div class="col-md-8 col-xs-12">
            <div class="box box-primary">
                <div class="box-body table-responsive">
                     @if(count($client_notes) > 0)
                  
                    <hr/>
              
                    <table id="table-lead" class="table table-hover">
            
                        <thead>
                        <tr>
                             <th>Added By</th>
                            <th>Notes</th>
                            <th>Remind me</th>
                             <th>Reminder date</th>
                              <th>Processing</th>                               
                         
                        </tr>
                        </thead>
                        <tbody>

                  @foreach($client_notes as $key => $client_note)
                        
                            <tr>
                                <td>{{ get_tenant_name($client_note->added_by_user_id)}}</td>
                                <td>{{ $client_note->description }}</td>
                                <td>{{ ($client_note->remind == 1) ? 'yes' : 'no' }}</td>
                                 <td>{{($client_note->remind == 1) ? format_date($client_note->reminder_date) : ''}}</td>
                                 <td><a href="" target="_blank"><i class="fa fa-eye"></i> View</a>&nbsp;&nbsp;
                                    <a href="{{route('tenant.client.innernotes.delete', $client_note->notes_id)}}" target="_blank" onClick="return confirm('Are you sure want to delete this record')" target="_blank"><i class="fa fa-trash"></i> Delete</a>
                                </td>
                               
                            </tr>
                             @endforeach
                        </tbody>

                    </table>
                   @else
                        <p class="text-muted well">
                            No note uploaded yet.
                        </p>
                   @endif
                </div>
            </div>
        </div>     </div>
    </div>
    <!-- Bootstrap date picker -->
    <script type="text/javascript">
        $(function () {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                startDate: '+0d',
                autoclose: true,
                todayHighlight: true
            });

        });

        $(document).ready(function () {
            $('#remind').change(function () {
                if (this.checked)
                    $('#reminderDate').fadeIn('slow');
                else
                    $('#reminderDate').fadeOut('slow');

            });
        });

    </script>
     <script class="cssdeck" type="text/javascript">
        /*$(".menu-opener").click(function () {
            $(".menu-opener").toggleClass("active");
            $(".client-navbar, .menu-opener-inner").slideToggle();
        });*/
        $(".menu-toggle").click(function () {
        $(".client-navbar").slideToggle();
    });
    </script>

@stop


       
    