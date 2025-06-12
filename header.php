<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
    <div class="header-top">
        <div class="search-container">
            <form role="search" method="get" action="<?php echo home_url('/'); ?>">
                <input type="search" placeholder="Search..." value="<?php echo get_search_query(); ?>" name="s">
                <select name="search_type">
                    <option value="MySpace">MySpace</option>
                </select>
                <input type="submit" value="Search">
            </form>
        </div>
        <div class="powered-by">
            powered by <span class="google-text">Google</span>
        </div>
    </div>
    
    <nav class="main-navigation">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container' => false,
            'menu_class' => 'nav-menu',
            'fallback_cb' => 'myspace_fallback_menu'
        ));
        ?>
    </nav>
</header>

<?php
function myspace_fallback_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . home_url() . '">Home</a></li>';
    echo '<li><a href="#">Browse</a></li>';
    echo '<li><a href="#">Search</a></li>';
    echo '<li><a href="#">Mail</a></li>';
    echo '<li><a href="#">Blog</a></li>';
    echo '<li><a href="#">Music</a></li>';
    echo '</ul>';
}
?>
