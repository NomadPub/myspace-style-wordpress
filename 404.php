<?php get_header(); ?>

<div class="container">
    <div class="sidebar">
        <?php if (is_active_sidebar('profile-sidebar')) : ?>
            <?php dynamic_sidebar('profile-sidebar'); ?>
        <?php endif; ?>
    </div>
    
    <div class="content">
        <div class="error-404">
            <h1>Page Not Found</h1>
            <p>Sorry, but the page you were looking for could not be found.</p>
            <p>You can try searching for what you are looking for using the form below:</p>
            
            <?php get_search_form(); ?>
            
            <h3>Recent Posts</h3>
            <ul>
                <?php
                $recent_posts = wp_get_recent_posts(array('numberposts' => 5));
                foreach($recent_posts as $post) :
                ?>
                    <li><a href="<?php echo get_permalink($post['ID']); ?>"><?php echo $post['post_title']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<?php get_footer(); ?>