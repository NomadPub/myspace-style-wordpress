<?php
/**
 * The template for displaying the footer
 * Updated to support custom WordPress menu and Customizer options
 */
?>
</div> <!-- Close main content wrapper if needed -->

<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-links">
            <?php
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
                myspace_footer_fallback_menu();
            }
            ?>
        </div>

        <div class="footer-info">
            <br/>
            <p><?php echo esc_html(get_theme_mod('footer_text', '© ' . date('Y') . ' ' . get_bloginfo('name') . '. All rights reserved.')); ?></p>
            <br/>
            <p>
                Powered by <a href="https://wordpress.org" style="color: #ccc;">WordPress</a>
            </p>
        </div>

        <div class="footer-social">
            <?php if ($twitter = get_theme_mod('myspace_twitter_url')) : ?>
                <a href="<?php echo esc_url($twitter); ?>" target="_blank" style="color: #ccc; margin: 0 5px;">Twitter</a>
            <?php endif; ?>

            <?php if ($linkedin = get_theme_mod('myspace_linkedin_url')) : ?>
                <a href="<?php echo esc_url($linkedin); ?>" target="_blank" style="color: #ccc; margin: 0 5px;">LinkedIn</a>
            <?php endif; ?>

            <?php if ($email = get_theme_mod('myspace_email')) : ?>
                <a href="mailto:<?php echo antispambot($email); ?>" style="color: #ccc; margin: 0 5px;">Email</a>
            <?php endif; ?>
        </div>

        <div class="footer-stats">
            <p style="font-size: 9px; color: #999; margin-top: 8px;">
                Last updated: <?php echo get_the_modified_time('F j, Y'); ?> 
                Profile views: <?php echo number_format(wp_count_posts()->publish + 1337); ?> 
                Online now: <?php echo rand(1, 12); ?> friends
            </p>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
