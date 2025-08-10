<?php
/**
 * UQ Blog Kit - Related Posts Feature
 * Uses uq_blog_kit for consistent rendering
 * 
 * @package UQ_Blog_Kit
 * @subpackage Related_Posts
 * @since 1.1.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class for handling related posts functionality using uq_blog_kit
 */
class UQ_Related_Posts {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Hook to display related posts after single post content
        add_action('generate_after_content', array($this, 'display_related_posts'), 15);
        
        // No need to enqueue assets - uq_blog_kit handles this
    }
    
    /**
     * Get related posts based on category
     * 
     * @param int $post_id Current post ID
     * @param int $limit Number of related posts to retrieve
     * @return array Array of post IDs
     */
    public function get_related_posts($post_id = null, $limit = 3) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        
        // Get current post categories
        $categories = wp_get_post_categories($post_id, array('fields' => 'ids'));
        
        if (empty($categories)) {
            return array();
        }
        
        // Query for related posts
        $args = array(
            'category__in' => $categories,
            'post__not_in' => array($post_id),
            'posts_per_page' => $limit,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
            'meta_key' => '_thumbnail_id', // Only posts with featured images
        );
        
        $related_query = new WP_Query($args);
        
        $related_posts = array();
        if ($related_query->have_posts()) {
            while ($related_query->have_posts()) {
                $related_query->the_post();
                $related_posts[] = get_the_ID();
            }
        }
        
        wp_reset_postdata();
        
        return $related_posts;
    }
    
    /**
     * Display related posts section using uq_blog_kit
     */
    public function display_related_posts() {
        // Only show on single posts
        if (!is_single() || !is_singular('post')) {
            return;
        }
        
        // Check if uq_blog_kit is available
        if (!class_exists('uq_blog_kit')) {
            return;
        }
        
        $related_posts = $this->get_related_posts();
        
        if (empty($related_posts)) {
            return;
        }
        
        // Render using uq_blog_kit
        ?>
        <section class="related-posts-section uq-blog-kit-related" aria-labelledby="related-posts-title">
            <div class="related-posts-section__container">
                <div class="section__header">
                    <h2 id="related-posts-title" class="section__title"><?php _e('추천 포스트', 'uq-blog-kit'); ?></h2>
                </div>
                
                <?php
                // Render the post card group using uq_blog_kit
                echo uq_blog_kit::render_post_card_group($related_posts, array(
                    'layout_type' => 'gallery',
                    'columns' => 3,
                    'pagination' => false,
                    'infinite_scroll' => false,
                    'gap' => '30px',
                    'group_class' => 'related-posts-grid',
                    'card_options' => array(
                        'layout' => 'portrait',
                        'show_category' => true,
                        'show_date_author' => false,
                        'show_tags' => false,
                        'show_excerpt' => true,
                        'excerpt_length' => 100,
                        'excerpt_lines' => 3,
                        'title_lines' => 2,
                        'image_aspect_ratio' => '16:9',
                        'date_format' => 'Y년 m월 d일',
                    )
                ));
                ?>
            </div>
        </section>
        <?php
    }
    
    /**
     * Static method for rendering related posts with custom options
     * 
     * @param array $args Configuration arguments
     */
    public static function render_related_posts($args = array()) {
        $defaults = array(
            'post_id' => get_the_ID(),
            'limit' => 3,
            'title' => __('추천 포스트', 'uq-blog-kit'),
            'layout_type' => 'gallery',
            'columns' => 3,
            'card_layout' => 'portrait',
            'show_category' => true,
            'show_date_author' => false,
            'show_tags' => false,
            'show_excerpt' => true,
            'excerpt_length' => 100,
            'excerpt_lines' => 3,
            'title_lines' => 2,
            'gap' => '30px',
            'container_class' => '',
        );
        
        $args = wp_parse_args($args, $defaults);
        
        // Check if uq_blog_kit is available
        if (!class_exists('uq_blog_kit')) {
            return;
        }
        
        $instance = new self();
        $related_posts = $instance->get_related_posts($args['post_id'], $args['limit']);
        
        if (empty($related_posts)) {
            return;
        }
        
        // Render the section
        ?>
        <section class="related-posts-section uq-blog-kit-related <?php echo esc_attr($args['container_class']); ?>" aria-labelledby="related-posts-title">
            <div class="related-posts-section__container">
                <div class="section__header">
                    <h2 id="related-posts-title" class="section__title"><?php echo esc_html($args['title']); ?></h2>
                </div>
                
                <?php
                // Use uq_blog_kit to render the post card group
                echo uq_blog_kit::render_post_card_group($related_posts, array(
                    'layout_type' => $args['layout_type'],
                    'columns' => $args['columns'],
                    'pagination' => false,
                    'infinite_scroll' => false,
                    'gap' => $args['gap'],
                    'group_class' => 'related-posts-grid',
                    'card_options' => array(
                        'layout' => $args['card_layout'],
                        'show_category' => $args['show_category'],
                        'show_date_author' => $args['show_date_author'],
                        'show_tags' => $args['show_tags'],
                        'show_excerpt' => $args['show_excerpt'],
                        'excerpt_length' => $args['excerpt_length'],
                        'excerpt_lines' => $args['excerpt_lines'],
                        'title_lines' => $args['title_lines'],
                        'image_aspect_ratio' => '16:9',
                        'date_format' => 'Y년 m월 d일',
                    )
                ));
                ?>
            </div>
        </section>
        <?php
    }
}

// Initialize the class
new UQ_Related_Posts();

// Global function for easy template usage
if (!function_exists('uq_display_related_posts')) {
    /**
     * Display related posts using uq_blog_kit
     * 
     * @param array $args Arguments for related posts display
     */
    function uq_display_related_posts($args = array()) {
        UQ_Related_Posts::render_related_posts($args);
    }
}