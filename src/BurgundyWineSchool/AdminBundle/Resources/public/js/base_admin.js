// Increase blocks size when closing the sidebar menu
$( "#menu-button" ).click(function() {
    $( "#sidebar" ).toggle();
    if ($("#sidebar").css('display') == 'none') {
        ($(".main-content").css("margin-left", 0));
    } else {
        ($(".main-content").css("margin-left", 220));
    }
});

// hide notif blocks
function hideBlock(elem) {
    $(elem).closest(".block").hide();
}