<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="exampleModalLabel1">Create New Role</h5>
            </div>
            {{Form::open(['route'=>'role.store','method'=>'post'])}}
            <div class="modal-body">

                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Name : <span style="color:red">*</span></label>
                    {{Form::text('name',null,['class'=>'form-control','required','placeholder'=> 'Role Name'])}}
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Permissions : <span style="color:red">*</span></label>
                    {{Form::select('permissions[]',$permissions,null,['class'=>'form-control select2-multiple','data-placeholder'=>" Permissions",'multiple','required'])}}
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

            {{Form::close()}}
        </div>
    </div>
</div>