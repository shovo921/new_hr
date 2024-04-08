<div class="form-body">
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10">Institute Name : </label>
        {!! Form::text('institute_name', $value = null, array('id'=>'institute_name', 'class' => 'form-control')) !!}
    </div>
    <div class="form-group col-md-offset-4">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Back</button>
    </div>
</div> 

