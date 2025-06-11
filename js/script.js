jQuery(document).ready(function($) {
    // Handle contact links
    $('.contact-link').on('click', function(e) {
        var href = $(this).attr('href');
        if (href === '#') {
            e.preventDefault();
            alert('This feature would connect to MySpace functionality!');
        }
    });
    
    // Make URL field selectable
    $('.myspace-url').on('click', function() {
        $(this).select();
    });
    
    // Smooth scroll for internal links
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        var target = $(this.getAttribute('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 500);
        }
    });
    
    // Add hover effects to widgets
    $('.widget').hover(
        function() {
            $(this).css('box-shadow', '0 2px 8px rgba(0,0,0,0.15)');
        },
        function() {
            $(this).css('box-shadow', 'none');
        }
    );
});