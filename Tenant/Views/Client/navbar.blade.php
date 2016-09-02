<?php $current = Request::segment(4); ?>
<div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <li class="{{($current == '')? 'active' : ''}}"><a href={{url("tenant/clients/$client->client_id")}}>Dashboard</a></li>
        <li class="{{($current == 'personal_details')? 'active' : ''}}"><a href={{url("tenant/clients/$client->client_id/personal_details")}}>Personal Details</a></li>
        <li class="{{($current == 'applications')? 'active' : ''}}"><a href={{url("tenant/clients/$client->client_id/applications")}}>College Application</a></li>
        <li class="{{($current == 'accounts')? 'active' : ''}}"><a href={{url("tenant/clients/$client->client_id/accounts")}}>Accounts</a></li>
        <li class="{{($current == 'document')? 'active' : ''}}"><a href={{url("tenant/clients/$client->client_id/document")}}>Documents</a></li>
        <li class="{{($current == 'notes')? 'active' : ''}}"><a href={{url("tenant/clients/$client->client_id/notes")}}>Notes</a></li>
    </ul>
</div><!--/.nav-collapse -->