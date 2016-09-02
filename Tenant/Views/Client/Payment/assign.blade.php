<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Assign To Invoice</h4>
</div>
<?php $action = (isset($college) && $college == true)? 'tenant/college/payment/'.$payment_id.'/assign' : 'tenant/payment/'.$payment_id.'/assign'; ?>
{!!Form::open(['url' => $action, 'id' => 'add-invoice', 'class' => 'form-horizontal form-left'])!!}
<div class="modal-body">
    <div class="form-group">
        {!!Form::label('invoice_id', 'Invoice', array('class' => 'col-sm-4 control-label')) !!}
        <div class="col-sm-8">
            {!!Form::select('invoice_id', $invoice_array, null, array('class' => 'form-control', 'id'=>'invoice_id'))!!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
        Assign
    </button>
</div>
{!!Form::close()!!}