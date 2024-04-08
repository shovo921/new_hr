<div class="modal fade" id="edit_{{$role->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="exampleModalLabel1">Update User - {{$role->name}}</h5>
            </div>
            {{Form::model($role,['route'=>['role.update',$role->id],'method'=>'put'])}}
            <div class="modal-body">

                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Name : <span style="color:red">*</span></label>
                    {{Form::text('name',null,['class'=>'form-control','readonly'])}}
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Permissions : <span style="color:red">*</span></label>
                    {{Form::select('permissions[]',$permissions,$role->permissions,['class'=>'form-control select2 select2-multiple','data-placeholder'=>"Select Permission",'multiple','required'])}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

            {{Form::close()}}
        </div>
    </div>
</div>