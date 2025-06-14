<?php
function myspace_theme_setup() {
    // Add theme support
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    add_theme_support('widgets');
    add_theme_support('custom-logo');
    
    // Register navigation menu
    register_nav_menus(array(
        'primary' => 'Primary Menu',
    ));
}
add_action('after_setup_theme', 'myspace_theme_setup');

// Enqueue styles and scripts
function myspace_theme_scripts() {
    wp_enqueue_style('myspace-style', get_stylesheet_uri());
    wp_enqueue_script('myspace-script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'myspace_theme_scripts');

// Register widget areas
function myspace_widgets_init() {
    register_sidebar(array(
        'name'          => 'Profile Sidebar',
        'id'            => 'profile-sidebar',
        'description'   => 'Profile section widgets',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'myspace_widgets_init');

// Enhanced Profile Widget (combining basic and enhanced features)
class MySpace_Profile_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'myspace_profile',
            'Profile Picture',
            array('description' => 'Display profile picture with basic info')
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        $name = !empty($instance['name']) ? $instance['name'] : 'User';
        $status = !empty($instance['status']) ? $instance['status'] : '';
        $statusauth = !empty($instance['statusauth']) ? $instance['statusauth'] : '';
        $age = !empty($instance['age']) ? $instance['age'] : '';
        $gender = !empty($instance['gender']) ? $instance['gender'] : '';
        $location = !empty($instance['location']) ? $instance['location'] : '';
        $image = !empty($instance['image']) ? $instance['image'] : '';
        
        echo '<div class="profile-section">';
        echo '<h2 class="profile-name">' . esc_html($name) . '</h2>';

        if ($image) {
            echo '<img src="' . esc_url($image) . '" alt="Profile Picture" class="profile-pic">';
        }
        
        if ($status) {
            echo '<p class="profile-status"> ' . esc_html($status) . '</p>';
        }
        if ($statusauth) {
            echo '<p><strong>-</strong> ' . esc_html($statusauth) . '</p>';
        }
        
        
        
        echo '<div class="profile-details">';
        if ($gender) echo '<p><strong>Gender:</strong> ' . esc_html($gender) . '</p>';
        if ($age) echo '<p><strong>Age:</strong> ' . esc_html($age) . '</p>';
        if ($location) echo '<p><strong>Location:</strong> ' . esc_html($location) . '</p>';
        echo '</div>';
        
        if (get_theme_mod('myspace_show_last_login', true)) {
            $last_login = myspace_get_last_login();
            if ($last_login) {
                echo '<div class="last-login">Last Login: ' . $last_login . '</div>';
            }
        }
        
        echo '<div class="view-links">';
        echo '<a href="' . home_url('/pics') . '">Pics</a> | ';
        echo '<a href="' . home_url('/videos') . '">Videos</a>';
        echo '</div>';
        
        echo '</div>';
        
        echo $args['after_widget'];
    }

    public function form($instance) {
        $name = !empty($instance['name']) ? $instance['name'] : '';
        $status = !empty($instance['status']) ? $instance['status'] : '';
        $statusauth = !empty($instance['statusauth']) ? $instance['statusauth'] : '';
        $age = !empty($instance['age']) ? $instance['age'] : '';
        $gender = !empty($instance['gender']) ? $instance['gender'] : '';
        $location = !empty($instance['location']) ? $instance['location'] : '';
        $image = !empty($instance['image']) ? $instance['image'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('name'); ?>">Name:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>" type="text" value="<?php echo esc_attr($name); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('status'); ?>">Status Quote:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('status'); ?>" name="<?php echo $this->get_field_name('status'); ?>" type="text" value="<?php echo esc_attr($status); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('statusauth'); ?>">Quote Author:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('statusauth'); ?>" name="<?php echo $this->get_field_name('statusauth'); ?>" type="text" value="<?php echo esc_attr($statusauth); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('age'); ?>">Age:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('age'); ?>" name="<?php echo $this->get_field_name('age'); ?>" type="text" value="<?php echo esc_attr($age); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('gender'); ?>">Gender:</label>
            <select class="widefat" id="<?php echo $this->get_field_id('gender'); ?>" name="<?php echo $this->get_field_name('gender'); ?>">
                <option value="">Select Gender</option>
                <option value="Male" <?php selected($gender, 'Male'); ?>>Male</option>
                <option value="Female" <?php selected($gender, 'Female'); ?>>Female</option>
                <option value="Non-binary" <?php selected($gender, 'Non-binary'); ?>>Non-binary</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('location'); ?>">Location:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('location'); ?>" name="<?php echo $this->get_field_name('location'); ?>" type="text" value="<?php echo esc_attr($location); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('image'); ?>">Profile Image URL:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="url" value="<?php echo esc_attr($image); ?>">
            <button type="button" class="button upload-image-button">Choose Image</button>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['name'] = (!empty($new_instance['name'])) ? strip_tags($new_instance['name']) : '';
        $instance['status'] = (!empty($new_instance['status'])) ? strip_tags($new_instance['status']) : '';
        $instance['statusauth'] = (!empty($new_instance['statusauth'])) ? strip_tags($new_instance['statusauth']) : '';
        $instance['age'] = (!empty($new_instance['age'])) ? strip_tags($new_instance['age']) : '';
        $instance['gender'] = (!empty($new_instance['gender'])) ? strip_tags($new_instance['gender']) : '';
        $instance['location'] = (!empty($new_instance['location'])) ? strip_tags($new_instance['location']) : '';
        $instance['image'] = (!empty($new_instance['image'])) ? esc_url_raw($new_instance['image']) : '';
        return $instance;
    }
}

// Mood Widget
class MySpace_Mood_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'myspace_mood',
            'Mood Status',
            array('description' => 'Display current mood')
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        $mood = !empty($instance['mood']) ? $instance['mood'] : 'happy';
        echo '<div class="mood-section">';
        echo '<p><strong>Mood:</strong> ' . esc_html($mood) . ' <span class="mood-emoji">🫠</span></p>';
        echo '</div>';
        echo $args['after_widget'];
    }

    public function form($instance) {
        $mood = !empty($instance['mood']) ? $instance['mood'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('mood'); ?>">Current Mood:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('mood'); ?>" name="<?php echo $this->get_field_name('mood'); ?>" type="text" value="<?php echo esc_attr($mood); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['mood'] = (!empty($new_instance['mood'])) ? strip_tags($new_instance['mood']) : '';
        return $instance;
    }
}

// Contact Widget
class MySpace_Contact_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'myspace_contact',
            'Contact Options',
            array('description' => 'Display contact options')
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        echo '<div class="contact-section">';
        echo '<h3>Contacting ' . get_bloginfo('name') . '</h3>';
        echo '<div class="contact-options">';
        echo '<a href="/contact" class="contact-link">📧 Send Message</a>';
        echo '<a href="#" class="contact-link">👥 Add to Friends</a>';
        echo '<a href="#" class="contact-link">💬 Instant Message</a>';
        echo '<a href="#" class="contact-link">👥 Add to Group</a>';
        echo '<a href="mailto:' . get_option('admin_email') . '" class="contact-link">📨 Forward to Friend</a>';
        echo '<a href="#" class="contact-link">⭐ Add to Favorites</a>';
        echo '<a href="/blocked" class="contact-link">🚫 Block User</a>';
        echo '<a href="#" class="contact-link">📊 Rank User</a>';
        echo '</div>';
        echo '</div>';
        echo $args['after_widget'];
    }
}

// URL Widget
class MySpace_URL_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'myspace_url',
            'MySpace URL',
            array('description' => 'Display MySpace URL')
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        $url = !empty($instance['url']) ? $instance['url'] : home_url();
        echo '<div class="url-section">';
        echo '<h4>MySpace URL:</h4>';
        echo '<input type="text" value="' . esc_url($url) . '" readonly class="myspace-url">';
        echo '</div>';
        echo $args['after_widget'];
    }

    public function form($instance) {
        $url = !empty($instance['url']) ? $instance['url'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('url'); ?>">URL:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="url" value="<?php echo esc_attr($url); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['url'] = (!empty($new_instance['url'])) ? esc_url_raw($new_instance['url']) : '';
        return $instance;
    }
}

// Interests Widget
class MySpace_Interests_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'myspace_interests',
            'Interests',
            array('description' => 'Display interests and hobbies')
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        $interests = !empty($instance['interests']) ? $instance['interests'] : '';
        echo '<div class="interests-section">';
        echo '<h3>Interests</h3>';
        echo '<div class="interest-category">';
        echo '<h4>General</h4>';
        echo '<p>' . nl2br(esc_html($interests)) . '</p>';
        echo '</div>';
        echo '</div>';
        echo $args['after_widget'];
    }

    public function form($instance) {
        $interests = !empty($instance['interests']) ? $instance['interests'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('interests'); ?>">Interests (comma separated):</label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('interests'); ?>" name="<?php echo $this->get_field_name('interests'); ?>" rows="4"><?php echo esc_textarea($interests); ?></textarea>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['interests'] = (!empty($new_instance['interests'])) ? sanitize_textarea_field($new_instance['interests']) : '';
        return $instance;
    }
}

// FIXED Music Widget - This is the key fix for your Apple Music embed
class MySpace_Music_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'myspace_music',
            'Music Player',
            array('description' => 'Embed music from Spotify or Apple Music')
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        $embed_code = !empty($instance['embed_code']) ? $instance['embed_code'] : '';
        echo '<div class="music-section">';
        echo '<h3>Music</h3>';
        if ($embed_code) {
            // Use custom kses rules to allow iframe with specific attributes
            echo wp_kses($embed_code, $this->get_allowed_html());
        }
        echo '</div>';
        echo $args['after_widget'];
    }

    public function form($instance) {
        $embed_code = !empty($instance['embed_code']) ? $instance['embed_code'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('embed_code'); ?>">Embed Code (Spotify/Apple Music):</label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('embed_code'); ?>" name="<?php echo $this->get_field_name('embed_code'); ?>" rows="6"><?php echo esc_textarea($embed_code); ?></textarea>
            <small>Paste your Apple Music or Spotify embed code here. Make sure it's from the official sharing options.</small>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['embed_code'] = (!empty($new_instance['embed_code'])) ? wp_kses($new_instance['embed_code'], $this->get_allowed_html()) : '';
        return $instance;
    }
    
    // Custom allowed HTML for music embeds
    private function get_allowed_html() {
        return array(
            'iframe' => array(
                'src' => array(),
                'width' => array(),
                'height' => array(),
                'frameborder' => array(),
                'allow' => array(),
                'sandbox' => array(),
                'style' => array(),
                'title' => array(),
                'loading' => array(),
                'allowfullscreen' => array(),
                'allowtransparency' => array()
            ),
            'div' => array(
                'class' => array(),
                'id' => array(),
                'style' => array()
            )
        );
    }
}

// Custom Widget: MySpace Banner
class MySpace_Banner_Widget extends WP_Widget {
    function __construct() {
        parent::__construct('myspace_banner_widget', 'MySpace Banner');
    }

    function widget($args, $instance) {
        // Store message in a transient so index.php can access it
        $message = !empty($instance['message']) ? $instance['message'] : '';
        set_transient('myspace_banner_message', $message, 0);
    }

    function form($instance) {
        $message = !empty($instance['message']) ? $instance['message'] : '';
        echo '<p><label for="' . $this->get_field_id('message') . '">Banner Message:</label>';
        echo '<input class="widefat" id="' . $this->get_field_id('message') . '" name="' . $this->get_field_name('message') . '" type="text" value="' . esc_attr($message) . '"></p>';
    }

    function update($new_instance, $old_instance) {
        $instance = [];
        $instance['message'] = sanitize_text_field($new_instance['message']);
        return $instance;
    }
}

// Register all widgets - SINGLE registration to avoid conflicts
function register_myspace_widgets() {
    register_widget('MySpace_Profile_Widget');
    register_widget('MySpace_Mood_Widget');
    register_widget('MySpace_Contact_Widget');
    register_widget('MySpace_URL_Widget');
    register_widget('MySpace_Interests_Widget');
    register_widget('MySpace_Music_Widget');
    register_widget('MySpace_Banner_Widget');
}
add_action('widgets_init', 'register_myspace_widgets');

// Admin scripts for media uploader
function myspace_admin_scripts() {
    wp_enqueue_media();
    wp_enqueue_script('myspace-admin', get_template_directory_uri() . '/js/admin.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'myspace_admin_scripts');

// Customizer Settings
function myspace_customize_register($wp_customize) {
    // Add MySpace section
    $wp_customize->add_section('myspace_options', array(
        'title' => 'MySpace Options',
        'priority' => 120,
    ));
    
    // About text setting
    $wp_customize->add_setting('myspace_about_text', array(
        'default' => 'I\'m here to help you. Send me a message if you\'re confused by anything.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('myspace_about_text', array(
        'label' => 'About Me Text',
        'section' => 'myspace_options',
        'type' => 'textarea',
    ));
    
    // Header background color
    $wp_customize->add_setting('myspace_header_color', array(
        'default' => '#2e5fb5',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'myspace_header_color', array(
        'label' => 'Header Background Color',
        'section' => 'myspace_options',
    )));
    
    // Enable/disable features
    $wp_customize->add_setting('myspace_show_last_login', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    
    $wp_customize->add_control('myspace_show_last_login', array(
        'label' => 'Show Last Login',
        'section' => 'myspace_options',
        'type' => 'checkbox',
    ));
}
add_action('customize_register', 'myspace_customize_register');

// Custom login tracking
function myspace_track_login($user_login, $user) {
    update_user_meta($user->ID, 'last_login', current_time('mysql'));
}
add_action('wp_login', 'myspace_track_login', 10, 2);

// Add last login to profile widget
function myspace_get_last_login($user_id = null) {
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    
    $last_login = get_user_meta($user_id, 'last_login', true);
    if ($last_login) {
        return date('n/j/Y', strtotime($last_login));
    }
    return false;
}

// Custom CSS from customizer
function myspace_customizer_css() {
    $header_color = get_theme_mod('myspace_header_color', '#2e5fb5');
    ?>
    <style type="text/css">
        .site-header {
            background: linear-gradient(to bottom, <?php echo esc_attr($header_color); ?> 0%, <?php echo esc_attr($header_color); ?>aa 50%, <?php echo esc_attr($header_color); ?> 100%);
        }
        .header-top {
            background: <?php echo esc_attr($header_color); ?>dd;
        }
        .nav-menu li {
            border-right-color: <?php echo esc_attr($header_color); ?>88;
        }
        .nav-menu li:first-child {
            border-left-color: <?php echo esc_attr($header_color); ?>88;
        }
    </style>
    <?php
}
add_action('wp_head', 'myspace_customizer_css');

?>
