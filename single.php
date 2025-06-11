<?php get_header(); ?>

<div class="container">
    <div class="sidebar">
        <?php if (is_active_sidebar('profile-sidebar')) : ?>
            <?php dynamic_sidebar('profile-sidebar'); ?>
        <?php endif; ?>
    </div>
    
    <div class="content">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article class="single-post">
                    <h1><?php the_title(); ?></h1>
                    <div class="post-meta">
                        Posted on <?php the_date(); ?> by <?php the_author(); ?>
                    </div>
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
