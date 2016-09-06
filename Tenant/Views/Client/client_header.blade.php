<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-sm-2">

                <img src="{{ ($client->filename != null)? url($client->shelf_location.'/'.$client->filename) : asset('assets/img/default-user.png') }}"
                     class="img-rounded"
                     alt="{{$client->first_name}} {{$client->middle_name}} {{$client->last_name}}"
                     height="150"/>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#url-modal">
                    <i class="fa fa-upload"></i>Upload From URL
                </button>

            </div>
            <div class="col-sm-10">
                <div class="container">
                    <div class="pull-right">
                        <a href="{{ route('tenant.client.compose', $client->client_id) }}"
                           class="btn btn-flat btn-success"><i class="fa fa-envelope"></i> Email</a>
                        <a href="{{ route('tenant.client.edit', $client->client_id) }}"
                           class="btn btn-flat btn-primary"><i class="fa fa-edit"></i> Edit</a>
                    </div>
                    <h4>{{$client->first_name}} {{$client->middle_name}} <b>{{$client->last_name}}</b></h4>
                    <i class="fa fa-phone"></i> {{$client->number}} | <i
                            class="fa fa-envelope"></i> {{$client->email}} </br>
                    <address>
                        {{ $client->street }}&nbsp;,
                        {{ $client->suburb }}&nbsp;
                        {{ $client->state }}&nbsp;
                        {{ $client->postcode }}&nbsp;
                        <strong>{{ get_country($client->country_id) }}</strong>
                    </address>
                </div>
                <div class="container">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                        data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand visible-xs" href="#">AMS</a>
                            </div>

                            @include('Tenant::Client/navbar')
                        </div>
                        <!--/.container-fluid -->
                    </nav>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="url-modal" tabindex="-1" role="dialog" aria-labelledby="url-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Save Image From URL</h4>
                </div>
                {!!Form::open(['route' => ['tenant.client.urlUpload', $client->client_id], 'method'=> 'post', 'files' => 'true', 'class' => 'form-left'])!!}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">URL * </label>
                        <input type="text" class="form-control" name="url" />
                    </div>
                    <div class="form-group">
                        <label for="">Title * </label>
                        <input type="text" class="form-control" name="title" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
                        Save
                    </button>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>

</div>