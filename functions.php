<?php
/**
 * Brizy Starter Theme functions and definitions
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! isset( $content_width ) ) {
	$content_width = 1920; // pixels
}

define( 'THEME_DIR', get_template_directory() );
define( 'THEME_URI', get_template_directory_uri() );

/**
 * Set up theme support
 */
if ( ! function_exists( 'brizy_starter_theme_setup' ) ) {
	function brizy_starter_theme_setup() {
        /**
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Brizy Starter Theme, use a find and replace
         * to change 'brizy-starter-theme' to the name of your theme in all the template files.
         */
        load_theme_textdomain( 'brizy-starter-theme', get_template_directory() . '/languages' );

        /**
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );
	
	add_theme_support( 'woocommerce' );
		
        /**
         * Enable support for Post Thumbnails on posts and pages.
         */
        add_theme_support( 'post-thumbnails' );

        /**
         * No need for default images as Brizy generates its own.
         */
        remove_image_size('medium_large');
        add_image_size('medium_large', 150, 150, true);
        remove_image_size('medium');
        add_image_size('medium', 150, 150, true);
        remove_image_size('large');
        add_image_size('large', 150, 150, true);

        register_nav_menus(
            array(
                'primary'   => __( 'Primary Menu', 'brizy-starter-theme' ),
                'secondary' => __( 'Secondary Menu', 'brizy-starter-theme' ),
                'footer'    => __( 'Footer Menu', 'brizy-starter-theme' )
            )
        );

        /**
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            )
        );

        /**
         * Add support for core custom logo.
         */
        add_theme_support(
            'custom-logo',
            array(
                'height'      => 150,
                'width'       => 150,
                'flex-width'  => true,
                'flex-height' => true,
            )
        );

        // TGM
        //include_once(THEME_DIR . '/includes/tgm/class-tgm-plugin-activation.php');
        //add_action('tgmpa_register', 'brizy_starter_theme_plugins');

	}
}
add_action( 'after_setup_theme', 'brizy_starter_theme_setup' );

/**
 * Theme Scripts & Styles
 */
if ( ! function_exists( 'brizy_starter_theme_scripts_styles' ) ) {
	function brizy_starter_theme_scripts_styles() {
        wp_enqueue_style( 'brizy-starter-theme-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
	}
}
add_action( 'wp_enqueue_scripts', 'brizy_starter_theme_scripts_styles' );

if ( ! function_exists( 'brizy_starter_theme_post_thumbnail' ) ) :
    /**
     * Displays post thumbnail.
     */
    function brizy_starter_theme_post_thumbnail() {

        if ( is_singular() ) :
            ?>

            <figure class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </figure><!-- .post-thumbnail -->

        <?php
        else :
            ?>

            <figure class="post-thumbnail">
                <a class="post-thumbnail-inner" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                    <?php the_post_thumbnail( 'post-thumbnail' ); ?>
                </a>
            </figure>

        <?php
        endif; // End is_singular().
    }
endif;

if ( ! function_exists( 'brizy_starter_theme_entry_footer' ) ) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function brizy_starter_theme_entry_footer() {

        // Hide author, post date, category and tag text for pages.
        if ( 'post' === get_post_type() ) {

            // Posted by
            brizy_starter_theme_posted_by();

            // Posted on
            brizy_starter_theme_posted_on();

            $categories_list = get_the_category_list( __( ', ', 'brizy-starter-theme' ) );
            if ( $categories_list ) {
                printf(
                    '<span class="cat-links"><span class="screen-reader-text">%1$s</span>%2$s</span>',
                    __( 'Posted in', 'brizy-starter-theme' ),
                    $categories_list
                );
            }

            $tags_list = get_the_tag_list( '', __( ', ', 'brizy-starter-theme' ) );
            if ( $tags_list ) {
                printf(
                    '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
                    __( 'Tags:', 'brizy-starter-theme' ),
                    $tags_list
                );
            }
        }

        // Comment count.
        if ( ! is_singular() ) {
            brizy_starter_theme_comment_count();
        }
    }
endif;

if ( ! function_exists( 'brizy_starter_theme_posted_by' ) ) :
    /**
     * Prints HTML with meta information about theme author.
     */
    function brizy_starter_theme_posted_by() {
        printf(
            '<span class="byline"><span class="screen-reader-text">%1$s</span><span class="author vcard"><a class="url fn n" href="%2$s">%3$s</a></span></span>',
            __( 'Posted by', 'brizy-starter-theme' ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_html( get_the_author() )
        );
    }
endif;

if ( ! function_exists( 'brizy_starter_theme_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function brizy_starter_theme_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr( get_the_date( DATE_W3C ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( DATE_W3C ) ),
            esc_html( get_the_modified_date() )
        );

        printf(
            '<span class="posted-on"><a href="%1$s" rel="bookmark">%2$s</a></span>',
            esc_url( get_permalink() ),
            $time_string
        );
    }
endif;



if ( ! function_exists( 'brizy_starter_theme_comment_count' ) ) :
    /**
     * Prints HTML with the comment count for the current post.
     */
    function brizy_starter_theme_comment_count() {
        if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<span class="comments-link">';

            comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'brizy-starter-theme' ), get_the_title() ) );

            echo '</span>';
        }
    }
endif;

/**
 * After Import Setup
 *
 * Set the Classic Home Page as front
 * page and assign the menu to
 * the main menu location.
 */
add_action('pt-ocdi/after_import', 'brizy_ocdi_after_import_setup');
function brizy_ocdi_after_import_setup() {
    $primary_menu = get_term_by('name', 'Primary Menu', 'nav_menu');
    if (!$primary_menu) {
        $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
    }
    if ($primary_menu) {
        set_theme_mod('nav_menu_locations', array('primary' => $primary_menu->term_id));
    }

    $secondary_menu = get_term_by('name', 'Secondary Menu', 'nav_menu');
    if ($secondary_menu) {
        set_theme_mod('nav_menu_locations', array('secondary' => $secondary_menu->term_id));
    }

    $footer_menu = get_term_by('name', 'Footer Menu', 'nav_menu');
    if ($footer_menu) {
        set_theme_mod('nav_menu_locations', array('footer' => $footer_menu->term_id));
    }

    $front_page_id = get_page_by_title('Home') ?  : get_page_by_title('Homepage');
    if ($front_page_id) {
        update_option('page_on_front', $front_page_id->ID);
        update_option('show_on_front', 'page');
    }
    $blog_page_id = get_page_by_title('Blog');
    if ($blog_page_id) {
        update_option('page_for_posts', $blog_page_id->ID);
    }
}

if ( ! function_exists( 'brizy_starter_theme_register_sidebar' ) ) :
    function brizy_starter_theme_register_sidebar() {
        register_sidebars( 2, array( 'name' => 'Sidebar %d', 'brizy-starter-theme' ) );
	register_sidebars( 4, array( 'name' => 'Footer %d', 'brizy-starter-theme' ) );
    }
    add_action( 'widgets_init', 'brizy_starter_theme_register_sidebar' );
endif;


/** * * * * * * * * * * * * * * * * * * * * * Change this with your info * * * * * * * * * * * * * * * * * * * * * * */

/**
 * TGM
 *
 * An addon which helps theme to install
 * and activate different plugins.
 */
/**
if ( ! function_exists( 'brizy_starter_theme_plugins' ) ) {
    function brizy_starter_theme_plugins() {
        $plugins = array(
            array(
                'name'      => esc_html__('Brizy', 'brizy-starter-theme'),
                'slug'      => 'brizy',
                'required'  => true
            ),
            array(
                'name'      => esc_html__('Brizy Pro', 'brizy-starter-theme'),
                'slug'      => 'brizy-pro',
                'source'    => THEME_DIR . '/includes/plugins/brizy-pro.zip',
                'required'  => false
            ),
            array(
                'name'       => esc_html__('One Click Demo Import', 'brizy-starter-theme'),
                'slug'       => 'one-click-demo-import',
                'required'   => false
            ),

        );
        $config = array(
            'id'           => 'tgmpa',
            'default_path' => '',
            'menu'         => 'tgmpa-install-plugins',
            'parent_slug'  => 'themes.php',
            'capability'   => 'edit_theme_options',
            'has_notices'  => true,
            'dismissable'  => true,
            'dismiss_msg'  => '',
            'is_automatic' => false,
            'message'      => ''
        );
        tgmpa($plugins, $config);
    }
}
*/

/**
 * How to predefine demo imports?
 *
 * This question is for theme authors.
 * To predefine demo imports, you just have to add the following code structure,
 * with your own values to your theme (using the `pt-ocdi/import_files` filter):
 */
/**
function brizy_ocdi_import_files() {
    $uri = 'http://www.your_domain.com/';
    return array(
        array(
            'import_file_name'           => 'Architekt',
            'categories'                 => array( 'Business', 'Category 2' ),
            'import_file_url'            => $uri .'architekt/demo-content.xml',
            'import_customizer_file_url' => $uri .'architekt/customizer.dat',
            'import_preview_image_url'   => $uri .'architekt/preview.png',
            'import_notice'              => __( 'You need to <a href="'. admin_url("plugin-install.php?tab=plugin-information&plugin=woocommerce") .'" target="_blank">Install Now WooCommerce</a> plugin for this demo', 'brizy-starter-theme' ),
            'preview_url'                => 'https://demo.themefuse.com/?theme=wordpress-business-theme',
        ),
        array(
            'import_file_name'           => 'Demo Import 2',
            'categories'                 => array( 'New category', 'Old category' ),
            'import_file_url'            => 'http://www.your_domain.com/ocdi/demo-content2.xml',
            'import_widget_file_url'     => 'http://www.your_domain.com/ocdi/widgets2.json',
            'import_customizer_file_url' => 'http://www.your_domain.com/ocdi/customizer2.dat',
            'import_preview_image_url'   => 'http://www.your_domain.com/ocdi/preview_import_image2.jpg',
            'import_notice'              => __( 'A special note for this import.', 'brizy-starter-theme' ),
            'preview_url'                => 'http://www.your_domain.com/my-demo-2',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'brizy_ocdi_import_files' );

function BrizyAuthorLicenseActivationData() {
    return array(
        'market'   => 'brizy',
        'author'   => 'brizy',
        'theme_id' => '000000'
    );
}
add_filter( 'brizy-pro-license-data', 'BrizyAuthorLicenseActivationData' );

function BrizyAuthorSupportURL() {
    return 'https://support.your-site.com';
}
add_filter( 'brizy_support_url', 'BrizyAuthorSupportURL' );

function BrizyAuthorUpgradeToProAff() {
    return 'https://brizy.io/pro?your-aff-id';
}
add_filter( 'brizy_upgrade_to_pro_url', 'BrizyAuthorUpgradeToProAff' );
*/
