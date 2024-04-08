<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="exampleModalLabel1">Create New User</h5>
            </div>
            {{Form::open(['route'=>'system-users.store','method'=>'post'])}}
            <div class="modal-body">

                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Name : <span style="color:red">*</span></label>
                    {{Form::text('name',null,['class'=>'form-control','required'])}}
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Mobile No : <span style="color:red">*</span></label>
                    {{Form::text('mobile_no',null,['class'=>'form-control','required'])}}
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Email :</label>
                    {{Form::text('email',null,['class'=>'form-control'])}}
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Role : <span style="color:red">*</span></label>
                    {{Form::select('role',$roles,null,['class'=>'form-control','placeholder'=>'Select Role','required'])}}
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Password : <span style="color:red">*</span></label>
                    {{Form::password('password',['class'=>'form-control','required','id'=>'Password'])}}
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Confirm Password : <span style="color:red">*</span> <span id="msg"></span></label>
                    {{Form::password('password_confirmation',['class'=>'form-control','required','id'=>'ConfirmPassword'])}}

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

