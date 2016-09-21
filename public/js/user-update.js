$(document).ready(function () {
    $('.user-avatar').on('click', function () {
        $('#file-account-avatar').trigger('click');
    });

    $('#file-account-avatar').change(function (event) {
        var reader = new FileReader();
        reader.onload = function(e) {
             $( '#user-account-avatar' ).attr('src',e.target.result);
        };
        reader.readAsDataURL(event.target.files[0]);
    });
});
