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
                <article class="single-page">
                    <h1><?php the_title(); ?></h1>
                    <div class="page-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>