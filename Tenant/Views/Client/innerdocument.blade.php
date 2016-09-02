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
                    <li><a href="{{url("tenant/clients/$client->client_id/innerdocument")}}">Documents</a></li>
                    <li><a href="{{url("tenant/clients/$client->client_id/innernotes")}}">Notes</a></li>
                </ul>
            </div>
            <!--/.nav-collapse -->

        </div>
        <!--/.container-fluid -->
    </nav>

   
    <div class="col-xs-12 mainContainer">
        @include('flash::message')

        <div class="col-md-4 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Upload File</h3>
                </div>

                <div class="box-body">
                    {!! Form::open(['files' => true, 'method' => 'post']) !!}
                    <div class="form-group @if($errors->has('type')) {{'has-error'}} @endif">
                        {!!Form::label('type', 'Document Type *', array('class' => '')) !!}
                        {!!Form::text('type', null, array('class' => 'form-control'))!!}
                        @if($errors->has('type'))
                            {!! $errors->first('type', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('description')) {{'has-error'}} @endif">
                        {!!Form::label('description', 'Description *', array('class' => '')) !!}
                        {!!Form::textarea('description', null, array('class' => 'form-control'))!!}
                        @if($errors->has('description'))
                            {!! $errors->first('description', '<label class="control-label"
                                                                      for="inputError">:message</label>') !!}
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('document')) {{'has-error'}} @endif">
                        {!!Form::label('document', 'File *', array('class' => '')) !!}
                        {!!Form::file('document', null, array('class' => 'form-control'))!!}
                        @if($errors->has('document'))
                            {!! $errors->first('document', '<label class="control-label"
                                                                   for="inputError">:message</label>') !!}
                        @endif
                    </div>

                    <div class="form-group pull-right clearfix">
                        {!! Form::submit('Upload', ['class' => "btn btn-primary"]) !!}
                    </div>
                    {!! Form::close() !!}

                    <div class="clearfix"></div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8 col-xs-12">
            <div class="box box-primary">
                <div class="box-body table-responsive">
                    <h3 class="text-center">Uploaded Files</h3>
                    <hr/>
                    @if(count($documents) > 0)
                    <table id="table-lead" class="table table-hover">
                        <thead>
                        <tr>
                            <th>Uploaded On</th>
                            <th>Uploaded By</th>
                            <th>Filename</th>
                            <th>Document Type</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($documents as $key => $document)
                            <tr>
                                <td>{{format_datetime($document->document->created_at)}}</td>
                                <td>{{ get_tenant_name($document->document->user_id) }}</td>
                                <td>{{ $document->document->name }}</td>
                                <td>{{ $document->document->type }}</td>
                                <td>{{ $document->document->description }}</td>
                                <td><a href="{{ $document->document->shelf_location }}"
                                       target="_blank"><i class="fa fa-eye"></i> View</a>
                                    <a href="{{route('tenant.client.document.download', $document->document_id)}}"
                                       target="_blank"><i class="fa fa-download"></i> Download</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                        <p class="text-muted well">
                            No documents uploaded yet.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {!! Condat::js('client/document.js'); !!}
    <script type="text/javascript">
        $(function() {
            $('#profile-image').on('click', function() {
                $('#profile-image-upload').click();
            });
        });
    </script>
     <script class="cssdeck" type="text/javascript">
        $(".menu-toggle").click(function () {
        $(".client-navbar").slideToggle();
    });
    </script>
@stop
