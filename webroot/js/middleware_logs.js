var id = -1;
jQuery(document).ready(function($) {
    // Stuff to do as soon as the DOM is ready. Use $() w/o colliding with other libs;
    $('#message').popover();
    // $('#message' + id).popover();
});

$('.message').on('click', function(){
    id = $(this).attr('data-id');
    // alert(id);
    $('#message' + id).popover();
    // alert($('#message' + id).attr('data-content'));

});