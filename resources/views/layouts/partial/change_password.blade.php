<div class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="exampleModalLabel1">Change Password</h5>
            </div>
            {{Form::open(['route'=>'change-password','method'=>'post'])}}
            <div class="modal-body">
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Current Password : <span style="color:red">*</span></label>
                    {{Form::password('current_password',['class'=>'form-control','required'])}}
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">New Password : <span style="color:red">*</span></label>
                    {{Form::password('password',['class'=>'form-control','required','id'=>'cPassword'])}}
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Confirm Password : <span style="color:red">*</span> <span id="cmsg"></span></label>
                    {{Form::password('password_confirmation',['class'=>'form-control','required','id'=>'ConfirmCPassword'])}}
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
@push('scripts')
<script>
    $(document).ready(function(){
        $("#cPassword").keyup(function(){
            if($("#ConfirmCPassword").val() !== '') {
                if ($("#Password").val() != $("#ConfirmPassword").val()) {
                    $("#cmsg").html("Password do not match").css("color", "red");
                } else {
                    $("#cmsg").html("Password matched").css("color", "green");
                }
            } else {
                $("#cmsg").empty();
            }
        });
        $("#ConfirmCPassword").keyup(function(){
            if($("#Password").val() !== '') {
                if ($("#cPassword").val() != $("#ConfirmPassword").val()) {
                    $("#cmsg").html("Password do not match").css("color", "red");
                } else {
                    $("#cmsg").html("Password matched").css("color", "green");
                }
            }else {
                $("#cmsg").empty();
            }
        });
    });
</script>
@endpush
