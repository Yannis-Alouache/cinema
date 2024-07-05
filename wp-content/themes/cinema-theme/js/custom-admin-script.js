jQuery(document).ready(function ($) {
    $('#upload_image_button').click(function () {
        var custom_uploader = wp.media({
            multiple: false
        });
        custom_uploader.on('select', function () {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#film_image').val(attachment.url);
        });
        custom_uploader.open();
    });
});