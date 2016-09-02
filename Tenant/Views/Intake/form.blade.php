<div class="modal-body">
    <div class="form-group">
        <label for="intake_date" class="col-sm-3 control-label">Intake Date: </label>

        <div class="col-sm-8">
            <div class="input-group date" id="intake_date">
                {!!Form::text('intake_date', null, array('class' => 'form-control'))!!}
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-sm-3 control-label">Description: </label>

        <div class="col-sm-8">
            <textarea name="description" class="form-control" id="description"></textarea>
        </div>
    </div>
</div>
{!! Condat::registerModal() !!}
<script type="text/javascript">
    $("#intake_date").datepicker({
        autoclose: true
    });
</script>