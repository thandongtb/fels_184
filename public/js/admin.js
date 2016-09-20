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
});
