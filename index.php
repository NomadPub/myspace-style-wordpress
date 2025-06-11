<?php get_header(); ?>

<div class="container">
    <div class="sidebar">
        <?php if (is_active_sidebar('profile-sidebar')) : ?>
            <?php dynamic_sidebar('profile-sidebar'); ?>
        <?php endif; ?>
    </div>
    
    <div class="content">
        <div class="status-update">
            <h2><?php bloginfo('name'); ?> is working on myspace plans!</h2>
        </div>
        
        <div class="blog-section">
            <h3>Latest Blog Entries</h3>
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="blog-entry">
                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <div class="blog-meta">
                            Posted on <?php the_date(); ?> | <a href="<?php the_permalink(); ?>">View more</a>
                        </div>
                        <div class="blog-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p>No posts found.</p>
            <?php endif; ?>
        </div>
        
        <div class="blurbs-section">
            <h3>About me:</h3>
            <div class="blurbs-content">
                <?php 
                $about_text = get_theme_mod('myspace_about_text', 'I\'m here to help you. Send me a message if you\'re confused by anything.');
                echo wp_kses_post($about_text);
                ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>