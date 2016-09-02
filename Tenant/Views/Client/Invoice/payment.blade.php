<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Add Payment</h4>
</div>
{!!Form::open(['id' => 'add-payment', 'class' => 'form-horizontal form-left'])!!}
<div class="modal-body">
    @if($type == 1)
        <?php $pay_type = 3; //for different payment method ?>
        @include('Tenant::College/Payment/form')
    @elseif($type == 2)
        @include('Tenant::Student/Payment/form')
    @else
        @include('Tenant::SubAgent/Payment/form')
    @endif
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
        Add
    </button>
</div>
{!!Form::close()!!}