$(document).ready(function () {
    $('#nav-home').removeClass('active');
    $('#nav-user').addClass('active');

    $('.btn-follow').on('click', function(e) {
        e.preventDefault();
        followerId = $(this).data('user-followed-id');
        followStatus = $(this).data('follow') == 1;
        var formData = new FormData();
        formData.append('follower_id', followerId);
        formData.append('is_follow', followStatus);
        url = $('#home-url').data('url');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url + '/follow',
            processData : false,
            cache: false,
            contentType: false,
            method:'POST',
            data : formData,
            success: function(data) {
                if (data.success) {
                    toastr.success(data.message);

                    setInterval(function() {
                        window.location.reload();
                    }, 500);
                } else {
                    toastr.warning(data.message);

                    setInterval(function() {
                        window.location.reload();
                    }, 500);
                }
            },
            error: function() {}
        });
    });
});
