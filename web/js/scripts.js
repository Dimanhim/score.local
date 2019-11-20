$(document).ready(function() {
    $('.changeble-default select').on('change', function() {
        if($(this).val() != 0) {
            $('.costs-name').fadeOut();
            $('.costs-category').fadeOut();
        }
        else {
            $('.costs-name').fadeIn();
            $('.costs-category').fadeIn();
        }
    });
});