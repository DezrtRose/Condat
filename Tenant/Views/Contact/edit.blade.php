<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Edit Contact</h4>
</div>
{!!Form::model($contact, array('route' => ['tenant.contact.update', $contact->company_contact_id], 'class' => 'form-horizontal form-left', 'id' => 'edit-address'))!!}
<div class="modal-body">
    @include('Tenant::Contact/form')
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
        Update
    </button>
</div>
{!!Form::close()!!}