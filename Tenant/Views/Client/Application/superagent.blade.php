<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Add Super Agent</h4>
</div>
{!!Form::open(array('route' => 'tenant.agents.store', 'class' => 'form-horizontal form-left', 'id' => 'add-superagent'))!!}
<div class="modal-body">
    @include('Tenant::Agent/form')
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
        Add
    </button>
</div>
{!!Form::close()!!}