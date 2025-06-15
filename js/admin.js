jQuery(document).ready(function($) {
    // Media uploader for profile image
    var mediaUploader;
    
    $(document).on('click', '.upload-image-button', function(e) {
        e.preventDefault();
        var button = $(this);
        var input = button.siblings('input[type="url"]');
        
        // If the uploader object has already been created, reopen the dialog
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        
        // Create the media uploader
        mediaUploader = wp.media({
            title: 'Choose Profile Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        
        // When a file is selected, grab the URL and set it as the text field's value
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            input.val(attachment.url);
        });
        
        // Open the uploader dialog
        mediaUploader.open();
    });
});