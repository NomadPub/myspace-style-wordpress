<?php get_header(); ?>

<div class="container">
    <div class="sidebar">
        <?php if (is_active_sidebar('profile-sidebar')) : ?>
            <?php dynamic_sidebar('profile-sidebar'); ?>
        <?php endif; ?>
    </div>
    
    <div class="content">
        <div class="search-results">
            <h1>Search Results for: "<?php echo get_search_query(); ?>"</h1>
            
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="search-result">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p class="search-meta">
                            <?php echo get_post_time('F j, Y'); ?> - <?php echo get_post_type(); ?>
                        </p>
                        <div class="search-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
                
                <div class="pagination">
                    <?php echo paginate_links(); ?>
                </div>
            <?php else : ?>
                <p>No results found for your search.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>