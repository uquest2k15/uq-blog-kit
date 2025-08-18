<?php
/**
 * UQ Blog Sidebar Category Filter Widget Type01
 *
 * @package UQ_Blog_Kit
 * @subpackage Widgets
 * @since 1.1.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Category Filter Widget Type01 Class
 */
class uq_sidebar_cat_filter_widget_type01 extends WP_Widget {
    
    /**
     * Constructor
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'uq_sidebar_cat_filter_widget uq_sidebar_cat_filter_widget_type01',
            'description' => __('카테고리 필터 위젯 - Type01 (기본 스타일)', 'uq-blog-kit'),
            'customize_selective_refresh' => true,
        );
        
        parent::__construct(
            'uq_sidebar_cat_filter_widget_type01',
            __('UQ 카테고리 필터 (Type01)', 'uq-blog-kit'),
            $widget_ops
        );
    }
    
    /**
     * Output the widget content
     *
     * @param array $args Display arguments
     * @param array $instance The settings for the particular instance of the widget
     */
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('블로그 주제', 'uq-blog-kit');
        $show_all_link = !empty($instance['show_all_link']) ? $instance['show_all_link'] : true;
        $show_search_btn = !empty($instance['show_search_btn']) ? $instance['show_search_btn'] : true;
        $footer_link_text = !empty($instance['footer_link_text']) ? $instance['footer_link_text'] : '';
        $footer_link_url = !empty($instance['footer_link_url']) ? $instance['footer_link_url'] : '';
        
        // Get categories
        $categories = get_categories(array(
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => true,
        ));
        
        // Check current page context
        $current_category_id = 0;
        if (is_category()) {
            $current_category = get_queried_object();
            $current_category_id = $current_category->term_id;
        }
        
        echo $args['before_widget'];
        ?>
        
        <div class="widget__header">
            <?php if (!empty($title)) : ?>
                <h3 class="widget__title"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>
        </div>
        
        <nav class="widget__content" aria-label="<?php esc_attr_e('카테고리 필터', 'uq-blog-kit'); ?>">
            <ul class="category-list">
                <?php if ($show_all_link) : ?>
                    <li class="category-list__item<?php echo (is_home() || is_front_page()) ? ' category-list__item--active' : ''; ?>">
                        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" 
                           class="category-list__link"
                           <?php echo (is_home() || is_front_page()) ? 'aria-current="page"' : ''; ?>>
                            <?php _e('전체', 'uq-blog-kit'); ?>
                        </a>
                    </li>
                <?php endif; ?>
                
                <?php foreach ($categories as $category) : ?>
                    <li class="category-list__item<?php echo ($current_category_id === $category->term_id) ? ' category-list__item--active' : ''; ?>">
                        <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
                           class="category-list__link"
                           <?php echo ($current_category_id === $category->term_id) ? 'aria-current="page"' : ''; ?>>
                            <?php echo esc_html($category->name); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            
            <?php if (!empty($footer_link_text) && !empty($footer_link_url)) : ?>
                <div class="widget__divider"></div>
                <div class="widget__footer">
                    <a href="<?php echo esc_url($footer_link_url); ?>" 
                       class="widget__more-link" 
                       target="_blank" 
                       rel="noopener noreferrer">
                        <?php echo esc_html($footer_link_text); ?>
                        <span class="icon-external" aria-hidden="true">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 2.5H9.5V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9.5 2.5L2.5 9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </a>
                </div>
            <?php endif; ?>
        </nav>
        
        <?php if ($show_search_btn) : ?>
            <button class="widget__search-btn" 
                    type="button"
                    aria-label="<?php esc_attr_e('검색', 'uq-blog-kit'); ?>">
                <svg class="icon-search" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M19 19L14.65 14.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        <?php endif; ?>
        
        <?php
        echo $args['after_widget'];
    }
    
    /**
     * Output the widget form in the admin
     *
     * @param array $instance Current settings
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('블로그 주제', 'uq-blog-kit');
        $show_all_link = isset($instance['show_all_link']) ? (bool) $instance['show_all_link'] : true;
        $show_search_btn = isset($instance['show_search_btn']) ? (bool) $instance['show_search_btn'] : true;
        $footer_link_text = !empty($instance['footer_link_text']) ? $instance['footer_link_text'] : '';
        $footer_link_url = !empty($instance['footer_link_url']) ? $instance['footer_link_url'] : '';
        ?>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('제목:', 'uq-blog-kit'); ?>
            </label>
            <input class="widefat" 
                   id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        
        <p>
            <input class="checkbox" 
                   type="checkbox"<?php checked($show_all_link); ?> 
                   id="<?php echo esc_attr($this->get_field_id('show_all_link')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('show_all_link')); ?>">
            <label for="<?php echo esc_attr($this->get_field_id('show_all_link')); ?>">
                <?php esc_html_e('전체 링크 표시', 'uq-blog-kit'); ?>
            </label>
        </p>
        
        <p>
            <input class="checkbox" 
                   type="checkbox"<?php checked($show_search_btn); ?> 
                   id="<?php echo esc_attr($this->get_field_id('show_search_btn')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('show_search_btn')); ?>">
            <label for="<?php echo esc_attr($this->get_field_id('show_search_btn')); ?>">
                <?php esc_html_e('검색 버튼 표시', 'uq-blog-kit'); ?>
            </label>
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('footer_link_text')); ?>">
                <?php esc_html_e('푸터 링크 텍스트:', 'uq-blog-kit'); ?>
            </label>
            <input class="widefat" 
                   id="<?php echo esc_attr($this->get_field_id('footer_link_text')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('footer_link_text')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($footer_link_text); ?>">
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('footer_link_url')); ?>">
                <?php esc_html_e('푸터 링크 URL:', 'uq-blog-kit'); ?>
            </label>
            <input class="widefat" 
                   id="<?php echo esc_attr($this->get_field_id('footer_link_url')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('footer_link_url')); ?>" 
                   type="url" 
                   value="<?php echo esc_attr($footer_link_url); ?>">
        </p>
        
        <?php
    }
    
    /**
     * Update widget instance
     *
     * @param array $new_instance New settings for this instance
     * @param array $old_instance Old settings for this instance
     * @return array Settings to save
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['show_all_link'] = isset($new_instance['show_all_link']) ? (bool) $new_instance['show_all_link'] : false;
        $instance['show_search_btn'] = isset($new_instance['show_search_btn']) ? (bool) $new_instance['show_search_btn'] : false;
        $instance['footer_link_text'] = (!empty($new_instance['footer_link_text'])) ? sanitize_text_field($new_instance['footer_link_text']) : '';
        $instance['footer_link_url'] = (!empty($new_instance['footer_link_url'])) ? esc_url_raw($new_instance['footer_link_url']) : '';
        
        return $instance;
    }
}

/**
 * Register the widget
 */
function uq_blog_kit_register_cat_filter_widget() {
    register_widget('uq_sidebar_cat_filter_widget_type01');
}
add_action('widgets_init', 'uq_blog_kit_register_cat_filter_widget');

/**
 * Enqueue widget styles and scripts
 */
function uq_blog_kit_enqueue_cat_filter_widget_assets() {
    // Only load if widget is active
    if (is_active_widget(false, false, 'uq_sidebar_cat_filter_widget_type01', true)) {
        // Enqueue CSS
        wp_enqueue_style(
            'sidebar-cat-filter-widget',
            UQ_BLOG_KIT_URL . 'uq-custom-sitewide/assets/css/sidebar-cat-filter-widget.css',
            array(),
            filemtime( UQ_BLOG_KIT_PATH . 'uq-custom-sitewide/assets/css/sidebar-cat-filter-widget.css' )
        );
        
        // Enqueue JavaScript
        wp_enqueue_script(
            'sidebar-cat-filter-widget',
            UQ_BLOG_KIT_URL . 'uq-custom-sitewide/assets/js/sidebar-cat-filter-widget.js',
            array('jquery'),
            filemtime( UQ_BLOG_KIT_PATH . 'uq-custom-sitewide/assets/js/sidebar-cat-filter-widget.js' ),
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'uq_blog_kit_enqueue_cat_filter_widget_assets');