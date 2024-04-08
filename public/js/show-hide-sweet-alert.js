function showBasicSweetAlert(type, msg, html = '') {

    swal({
        title: type.toUpperCase() + ' !',
        text: msg,
        type: type,
        timer: 3000,
        showConfirmButton: true
    }, function(){
        window.location.href = "http://localhost/hrms/public/login";
    })
}
function showChangePasswordSweetAlert(type, msg,image_url, html = '') {

    swal({
        title: type.toUpperCase() + ' !',
        text: msg,
        type: type,
        timer: 3000,
        imageUrl: image_url,
        imageHeight: 260,
        imageAlt: 'Loading'
    })
}

function showWithHtmlSweetAlert(type, html = '') {   
    console.log(html);
    swal({
        title: type.toUpperCase() + ' !',
        type: type,
        content: html,
        timer: 30000
    })
}

function showConfirmSweetAlert(form) {
    
    swal({
        title: "Are you sure?",
        text: "You won't be able to revert this !",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function(isConfirm){
        if (isConfirm)  $('form[name='+form+']').submit();
    });

}
function showNewConfirmSweetAlert(form,msg) {
    
    swal({
        title: "Are you sure?",
        text: msg,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Confirm",
        closeOnConfirm: false
    }, function(isConfirm){
        if (isConfirm)  $('form[name='+form+']').submit();
    });

}
