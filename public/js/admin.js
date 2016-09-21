$(document).ready(function () {
    $('.new-option').on('click', function (event) {
        parent = $('.hidden .table-add-answer');
        newOption = parent.clone();
        parent = $('#option-wrap .col-md-10');
        parent.append(newOption);
        event.preventDefault();
    });

    $('.remove-option').on('click', function (event) {
        $('#option-wrap .table-word-answer:last').remove();
        event.preventDefault();
    });

    $('#image-category').on('click', function () {
        $('#file-category-photo').trigger('click');
    });

    $('#file-category-photo').change(function (event) {
        var reader = new FileReader();
        reader.onload = function(e) {
             $( '#image-category' ).attr('src',e.target.result);
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    $(function () {
        $('.btn-save').on('click', function () {
            var formData = $(this).parents('.form-create-word');
            var category = formData.find('.category-id').val();
            var wordContent = formData.find('.word-content').val();
            var answerContent = formData.find('.answer-content').val();

            if (category == '' || wordContent == '' || answerContent == '' || answerContent === undefined) {
                alert('Please Fill All Required Field !');
            } else {
                formData.submit();
            }
        });
    });
});
