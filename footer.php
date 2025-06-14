<?php
/**
 * The template for displaying the footer
 * Updated to support custom WordPress menu
 */
?>

</div> <!-- Close main content wrapper if needed -->

    <footer class="site-footer">
        <div class="footer-content">
            <div class="footer-links">
                <?php
                // Check if a custom footer menu is assigned
                if (has_nav_menu('footer')) {
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer-menu',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => 'myspace_footer_fallback_menu',
                        'items_wrap'     => '%3$s',
                        'walker'         => new MySpace_Footer_Walker()
                    ));
                } else {
                    // Fallback to default links if no custom menu is set
                    myspace_footer_fallback_menu();
                }
                ?>
            </div>
            
            <div class="footer-info">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
                <p>
                    Powered by <a href="https://wordpress.org" style="color: #ccc;">WordPress</a> | 
                    MySpace Revival Theme by <a href="<?php echo home_url('/'); ?>" style="color: #ccc;"><?php bloginfo('name'); ?></a>
                </p>
            </div>
            
            <div class="footer-social">
                <?php if (get_theme_mod('myspace_twitter_url')) : ?>
                    <a href="<?php echo esc_url(get_theme_mod('myspace_twitter_url')); ?>" target="_blank" style="color: #ccc; margin: 0 5px;">Twitter</a>
                <?php endif; ?>
                
                <?php if (get_theme_mod('myspace_linkedin_url')) : ?>
                    <a href="<?php echo esc_url(get_theme_mod('myspace_linkedin_url')); ?>" target="_blank" style="color: #ccc; margin: 0 5px;">LinkedIn</a>
                <?php endif; ?>
                
                <?php if (get_theme_mod('myspace_email')) : ?>
                    <a href="mailto:<?php echo antispambot(get_theme_mod('myspace_email')); ?>" style="color: #ccc; margin: 0 5px;">Email</a>
                <?php endif; ?>
            </div>
            
            <div class="footer-stats">
                <p style="font-size: 9px; color: #999; margin-top: 8px;">
                    Last updated: <?php echo get_the_modified_time('F j, Y'); ?> | 
                    Profile views: <?php echo number_format(wp_count_posts()->publish + 1337); ?> | 
                    Online now: <?php echo rand(1, 12); ?> friends
                </p>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
