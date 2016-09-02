<?php $current = Request::segment(4); ?>
<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><strong>{{$institute->name}}</strong></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <ul class="nav navbar-nav">
                        <li class="{{($current == '')? 'active' : ''}}"><a href={{url("tenant/institute/$institute->institution_id")}}>Dashboard</a>
                        </li>
                        <li class="{{($current == 'courses')? 'active' : ''}}"><a href={{url("tenant/institutes/$institute->institution_id/courses")}}>Courses</a>
                        </li>
                        <li class="{{($current == 'intakes')? 'active' : ''}}"><a href={{url("tenant/institutes/$institute->institution_id/intakes")}}>Intakes</a>
                        </li>
                        <li class="{{($current == 'document')? 'active' : ''}}"><a href={{url("tenant/institutes/$institute->institution_id/document")}}>Documents</a>
                        </li>
                    </ul>
                </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>
</div>