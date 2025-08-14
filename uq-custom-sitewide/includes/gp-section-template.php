<?php
/**
 * Section Template System v2.0
 * 
 * Provides reusable section templates using the custom-section structure
 * Based on Custom Section Structure Specification v1.0
 * Integrates with Custom Section CSS (custom-section.css)
 * 
 * @package GeneratePress Child
 */

if (!defined('ABSPATH')) exit;

/**
 * Render a custom section
 * 
 * @param string $type     Section type (content, hero, hero-breakout)
 * @param array  $args     Arguments for the section
 * 
 * @example onfield_render_custom_section('hero', array('title' => 'Welcome'));
 */
function onfield_render_custom_section($type, $args = array()) {
    // Build the function name
    $function_name = "onfield_custom_section_{$type}";
    
    // Check if the function exists
    if (function_exists($function_name)) {
        call_user_func($function_name, $args);
    } else {
        // Log error if template not found (only in debug mode)
        if (WP_DEBUG) {
            error_log("Custom section function not found: {$function_name}");
        }
    }
}

/**
 * Hero Section
 * Renders outside #page for full viewport width
 * 
 * @param array $args Section arguments
 */
function onfield_custom_section_hero($args = array()) {
    // Set default values
    $defaults = array(
        'title'           => '',
        'description'     => '',
        'image'           => '',
        'image_alt'       => '',
        'button_primary'  => '',
        'button_primary_url' => '',
        'button_secondary' => '',
        'button_secondary_url' => '',
        'grid_variant'    => '',  // content-focused, media-focused, centered, reversed
        'section_bg'      => '',  // CSS color value
        'section_text'    => '',  // CSS color value
        'class'           => '',  // Additional CSS classes
    );
    
    // Merge provided args with defaults
    $args = wp_parse_args($args, $defaults);
    
    // Build grid modifier class
    $grid_class = 'custom-section__grid';
    if ($args['grid_variant']) {
        $grid_class .= ' custom-section__grid--' . esc_attr($args['grid_variant']);
    }
    
    // Build section styles
    $section_styles = array();
    if ($args['section_bg']) {
        $section_styles[] = '--section-bg: ' . esc_attr($args['section_bg']);
    }
    if ($args['section_text']) {
        $section_styles[] = '--section-text: ' . esc_attr($args['section_text']);
    }
    $style_attr = !empty($section_styles) ? ' style="' . implode('; ', $section_styles) . '"' : '';
    
    // Additional classes
    $additional_classes = $args['class'] ? ' ' . esc_attr($args['class']) : '';
    ?>
    
    <section class="custom-section custom-section--hero<?php echo $additional_classes; ?>"<?php echo $style_attr; ?>>
        <div class="custom-section__inner grid-container">
            <?php if ($args['grid_variant'] === 'centered' || (!$args['image'] && !$args['grid_variant'])) : ?>
                <!-- Centered layout or no image -->
                <div class="<?php echo esc_attr($grid_class); ?>">
                    <div class="custom-section__content">
                        <?php if ($args['title']) : ?>
                            <h1 class="custom-section__title"><?php echo esc_html($args['title']); ?></h1>
                        <?php endif; ?>
                        
                        <?php if ($args['description']) : ?>
                            <p class="custom-section__description"><?php echo wp_kses_post($args['description']); ?></p>
                        <?php endif; ?>
                        
                        <?php if ($args['button_primary'] || $args['button_secondary']) : ?>
                            <div class="custom-section__actions">
                                <?php if ($args['button_primary'] && $args['button_primary_url']) : ?>
                                    <a href="<?php echo esc_url($args['button_primary_url']); ?>" class="button custom-section__button">
                                        <?php echo esc_html($args['button_primary']); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($args['button_secondary'] && $args['button_secondary_url']) : ?>
                                    <a href="<?php echo esc_url($args['button_secondary_url']); ?>" class="button custom-section__button custom-section__button--secondary">
                                        <?php echo esc_html($args['button_secondary']); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($args['image'] && $args['grid_variant'] === 'centered') : ?>
                            <div class="custom-section__media">
                                <img src="<?php echo esc_url($args['image']); ?>" 
                                     alt="<?php echo esc_attr($args['image_alt'] ?: $args['title']); ?>">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else : ?>
                <!-- Two column layout with image -->
                <div class="<?php echo esc_attr($grid_class); ?>">
                    <div class="custom-section__content">
                        <?php if ($args['title']) : ?>
                            <h1 class="custom-section__title"><?php echo esc_html($args['title']); ?></h1>
                        <?php endif; ?>
                        
                        <?php if ($args['description']) : ?>
                            <p class="custom-section__description"><?php echo wp_kses_post($args['description']); ?></p>
                        <?php endif; ?>
                        
                        <?php if ($args['button_primary'] || $args['button_secondary']) : ?>
                            <div class="custom-section__actions">
                                <?php if ($args['button_primary'] && $args['button_primary_url']) : ?>
                                    <a href="<?php echo esc_url($args['button_primary_url']); ?>" class="button custom-section__button">
                                        <?php echo esc_html($args['button_primary']); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($args['button_secondary'] && $args['button_secondary_url']) : ?>
                                    <a href="<?php echo esc_url($args['button_secondary_url']); ?>" class="button custom-section__button custom-section__button--secondary">
                                        <?php echo esc_html($args['button_secondary']); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="custom-section__media">
                        <img src="<?php echo esc_url($args['image']); ?>" 
                             alt="<?php echo esc_attr($args['image_alt'] ?: $args['title']); ?>">
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
}

/**
 * Hero Breakout Section
 * Renders inside #main with full viewport width breakout
 * 
 * @param array $args Section arguments
 */
function onfield_custom_section_hero_breakout($args = array()) {
    // Set default values - same as hero
    $defaults = array(
        'title'           => '',
        'description'     => '',
        'image'           => '',
        'image_alt'       => '',
        'button_primary'  => '',
        'button_primary_url' => '',
        'button_secondary' => '',
        'button_secondary_url' => '',
        'grid_variant'    => '',  // content-focused, media-focused, centered, reversed
        'section_bg'      => '',  // CSS color value
        'section_text'    => '',  // CSS color value
        'class'           => '',  // Additional CSS classes
    );
    
    // Merge provided args with defaults
    $args = wp_parse_args($args, $defaults);
    
    // Build grid modifier class
    $grid_class = 'custom-section__grid';
    if ($args['grid_variant']) {
        $grid_class .= ' custom-section__grid--' . esc_attr($args['grid_variant']);
    }
    
    // Build section styles
    $section_styles = array();
    if ($args['section_bg']) {
        $section_styles[] = '--section-bg: ' . esc_attr($args['section_bg']);
    }
    if ($args['section_text']) {
        $section_styles[] = '--section-text: ' . esc_attr($args['section_text']);
    }
    $style_attr = !empty($section_styles) ? ' style="' . implode('; ', $section_styles) . '"' : '';
    
    // Additional classes
    $additional_classes = $args['class'] ? ' ' . esc_attr($args['class']) : '';
    ?>
    
    <section class="custom-section custom-section--hero-breakout<?php echo $additional_classes; ?>"<?php echo $style_attr; ?>>
        <div class="custom-section__inner grid-container">
            <?php if ($args['grid_variant'] === 'centered' || (!$args['image'] && !$args['grid_variant'])) : ?>
                <!-- Centered layout or no image -->
                <div class="<?php echo esc_attr($grid_class); ?>">
                    <div class="custom-section__content">
                        <?php if ($args['title']) : ?>
                            <h2 class="custom-section__title"><?php echo esc_html($args['title']); ?></h2>
                        <?php endif; ?>
                        
                        <?php if ($args['description']) : ?>
                            <p class="custom-section__description"><?php echo wp_kses_post($args['description']); ?></p>
                        <?php endif; ?>
                        
                        <?php if ($args['button_primary'] || $args['button_secondary']) : ?>
                            <div class="custom-section__actions">
                                <?php if ($args['button_primary'] && $args['button_primary_url']) : ?>
                                    <a href="<?php echo esc_url($args['button_primary_url']); ?>" class="button custom-section__button">
                                        <?php echo esc_html($args['button_primary']); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($args['button_secondary'] && $args['button_secondary_url']) : ?>
                                    <a href="<?php echo esc_url($args['button_secondary_url']); ?>" class="button custom-section__button custom-section__button--secondary">
                                        <?php echo esc_html($args['button_secondary']); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($args['image'] && $args['grid_variant'] === 'centered') : ?>
                            <div class="custom-section__media">
                                <img src="<?php echo esc_url($args['image']); ?>" 
                                     alt="<?php echo esc_attr($args['image_alt'] ?: $args['title']); ?>"
                                     loading="lazy">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else : ?>
                <!-- Two column layout with image -->
                <div class="<?php echo esc_attr($grid_class); ?>">
                    <div class="custom-section__content">
                        <?php if ($args['title']) : ?>
                            <h2 class="custom-section__title"><?php echo esc_html($args['title']); ?></h2>
                        <?php endif; ?>
                        
                        <?php if ($args['description']) : ?>
                            <p class="custom-section__description"><?php echo wp_kses_post($args['description']); ?></p>
                        <?php endif; ?>
                        
                        <?php if ($args['button_primary'] || $args['button_secondary']) : ?>
                            <div class="custom-section__actions">
                                <?php if ($args['button_primary'] && $args['button_primary_url']) : ?>
                                    <a href="<?php echo esc_url($args['button_primary_url']); ?>" class="button custom-section__button">
                                        <?php echo esc_html($args['button_primary']); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($args['button_secondary'] && $args['button_secondary_url']) : ?>
                                    <a href="<?php echo esc_url($args['button_secondary_url']); ?>" class="button custom-section__button custom-section__button--secondary">
                                        <?php echo esc_html($args['button_secondary']); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="custom-section__media">
                        <img src="<?php echo esc_url($args['image']); ?>" 
                             alt="<?php echo esc_attr($args['image_alt'] ?: $args['title']); ?>"
                             loading="lazy">
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
}

/**
 * Content Section
 * Renders inside #main following container width
 * 
 * @param array $args Section arguments
 */
function onfield_custom_section_content($args = array()) {
    // Set default values
    $defaults = array(
        'title'       => '',
        'content'     => '',
        'class'       => '',  // Additional CSS classes
    );
    
    // Merge provided args with defaults
    $args = wp_parse_args($args, $defaults);
    
    // Additional classes
    $additional_classes = $args['class'] ? ' ' . esc_attr($args['class']) : '';
    ?>
    
    <section class="custom-section custom-section--content<?php echo $additional_classes; ?>">
        <div class="custom-section__inner grid-container">
            <div class="custom-section__body">
                <?php if ($args['title']) : ?>
                    <h2 class="custom-section__title"><?php echo esc_html($args['title']); ?></h2>
                <?php endif; ?>
                
                <?php if ($args['content']) : ?>
                    <div class="custom-section__content">
                        <?php echo wp_kses_post($args['content']); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}

/**
 * Legacy support - map old function calls to new structure
 */
function onfield_render_section($type, $variant = 'default', $args = array()) {
    // Map old section types to new custom section types
    switch ($type) {
        case 'hero':
            if ($variant === 'page_header') {
                // Page header variant uses hero-breakout
                onfield_custom_section_hero_breakout(array(
                    'title' => $args['title'] ?? '',
                    'description' => $args['subtitle'] ?? '',
                    'image' => $args['image'] ?? '',
                    'image_alt' => $args['image_alt'] ?? '',
                    'grid_variant' => 'media-focused',
                    'section_bg' => '#f5f5f5'
                ));
            } else {
                // Default hero
                onfield_custom_section_hero(array(
                    'title' => $args['title'] ?? '',
                    'description' => $args['subtitle'] ?? '',
                    'image' => $args['background'] ?? '',
                    'button_primary' => $args['cta_text'] ?? '',
                    'button_primary_url' => $args['cta_url'] ?? '',
                    'grid_variant' => $args['text_align'] === 'center' ? 'centered' : ''
                ));
            }
            break;
            
        case 'content':
            if ($variant === 'two_column') {
                onfield_custom_section_hero_breakout(array(
                    'title' => $args['title'] ?? '',
                    'description' => $args['content'] ?? '',
                    'image' => $args['image'] ?? '',
                    'image_alt' => $args['image_alt'] ?? '',
                    'button_primary' => $args['cta_text'] ?? '',
                    'button_primary_url' => $args['cta_url'] ?? '',
                    'grid_variant' => $args['reverse'] ? 'reversed' : '',
                    'section_bg' => $args['background'] ? 'var(--base-2)' : ''
                ));
            } else {
                onfield_custom_section_content(array(
                    'title' => $args['title'] ?? '',
                    'content' => $args['content'] ?? ''
                ));
            }
            break;
            
        case 'cta':
            if ($variant === 'with_image') {
                onfield_custom_section_hero_breakout(array(
                    'title' => $args['title'] ?? '',
                    'description' => $args['description'] ?? '',
                    'image' => $args['image'] ?? '',
                    'button_primary' => $args['primary_text'] ?? '',
                    'button_primary_url' => $args['primary_url'] ?? '',
                    'grid_variant' => 'reversed',
                    'section_bg' => '#0066cc',
                    'section_text' => 'white'
                ));
            } else {
                onfield_custom_section_hero_breakout(array(
                    'title' => $args['title'] ?? '',
                    'description' => $args['description'] ?? '',
                    'button_primary' => $args['primary_text'] ?? '',
                    'button_primary_url' => $args['primary_url'] ?? '',
                    'button_secondary' => $args['secondary_text'] ?? '',
                    'button_secondary_url' => $args['secondary_url'] ?? '',
                    'grid_variant' => 'centered',
                    'section_bg' => $args['background'] === 'accent' ? 'var(--accent)' : '#0066cc',
                    'section_text' => 'white'
                ));
            }
            break;
            
        default:
            if (WP_DEBUG) {
                error_log("Unknown section type: {$type}");
            }
    }
}

/**
 * CTA Hero Section
 * Renders a call-to-action hero section with image and content
 * Layout: 50% image | 50% content
 * 
 * @param array $args Section arguments
 */
function onfield_custom_section_cta_hero($args = array()) {
    // Set default values
    $defaults = array(
        'title'           => '복잡한 세금, 전문가의 지식으로 명쾌하게',
        'description'     => '산더미 같은 서류와 어려운 규정들,<br>이제 전문가에게 맡기고 마음 편히 비즈니스에 집중하세요.',
        'button_text'     => '지금 바로 상담 신청하기',
        'button_url'      => '/request-consulting/',
        'image'           => get_stylesheet_directory_uri() . '/assets/images/sections/consult-request-form-cta.webp',
        'image_alt'       => '상담 신청',
        'section_bg'      => '#F8F8F8',
        'section_class'   => 'test-blog-cta'
    );
    
    // Parse arguments
    $args = wp_parse_args($args, $defaults);
    ?>
    
    <section class="custom-section custom-section--hero <?php echo esc_attr($args['section_class']); ?>" style="--section-bg: <?php echo esc_attr($args['section_bg']); ?>;">
        <div class="custom-section__inner grid-container">
            <div class="custom-section__grid <?php echo esc_attr($args['section_class']); ?>__grid">
                <div class="custom-section__media <?php echo esc_attr($args['section_class']); ?>__image">
                    <img src="<?php echo esc_url($args['image']); ?>" alt="<?php echo esc_attr($args['image_alt']); ?>">
                </div>
                <div class="custom-section__content <?php echo esc_attr($args['section_class']); ?>__content">
                    <h2 class="<?php echo esc_attr($args['section_class']); ?>__title"><?php echo wp_kses_post($args['title']); ?></h2>
                    <p class="<?php echo esc_attr($args['section_class']); ?>__description"><?php echo wp_kses_post($args['description']); ?></p>
                    <div class="custom-section__actions">
                        <a href="<?php echo esc_url($args['button_url']); ?>" class="<?php echo esc_attr($args['section_class']); ?>__button"><?php echo esc_html($args['button_text']); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}

/**
 * Register Page Hero Section
 * Registers a page hero section to be displayed after header using GeneratePress hook
 * This prevents empty containers between header and hero
 * 
 * @param array $args Section arguments
 */
function onfield_register_page_hero($args = array()) {
    // Register the hero section to display after header
    add_action( 'generate_after_header', function() use ($args) {
        onfield_custom_section_page_hero($args);
    }, 15 );
}

/**
 * Register CTA Hero Section
 * Registers a CTA hero section to be displayed before footer using GeneratePress hook
 * This prevents empty containers issues
 * 
 * @param array $args Section arguments
 */
function onfield_register_cta_hero($args = array()) {
    // Register the CTA hero section to display after primary content area
    add_action( 'generate_after_primary_content_area', function() use ($args) {
        onfield_custom_section_cta_hero($args);
    }, 50 );
}

/**
 * Custom Footer Section
 * Renders a custom footer with proper structure
 * Based on WordPress Block Editor footer structure
 * 
 * @param array $args Footer arguments
 */
function onfield_custom_section_footer($args = array()) {
    // Set default values
    $defaults = array(
        'logo_url' => get_site_url(),
        'logo_src' => get_stylesheet_directory_uri() . '/assets/images/logo-onfield.png',
        'logo_alt' => '온필드(onfield)',
        'company_name' => '온필드',
        'company_info' => 'GMG 지엠지 세무회계 역삼1지점ㅣ대표 김성미<br>(06223) 서울특별시 강남구 테헤란로34길 32, 1층<br>T.&nbsp;02-2068-3849<br>F.&nbsp;0303-3448-0998<br>E.&nbsp;smkim@gmg-tax.com',
        'copyright' => '© OnField. All rights reserved.',
        'footer_bg' => '#ffffff',
        'footer_class' => 'site-footer'
    );
    
    // Parse arguments
    $args = wp_parse_args($args, $defaults);
    ?>
    
    <footer class="<?php echo esc_attr($args['footer_class']); ?>" style="--footer-bg: <?php echo esc_attr($args['footer_bg']); ?>;">
        <div class="inside-footer grid-container">
            <div class="wp-block-columns">
                <!-- Column 1: Company Info -->
                <div class="wp-block-column">
                    <div class="wp-block-site-logo">
                        <a href="<?php echo esc_url($args['logo_url']); ?>" class="custom-logo-link" rel="home">
                            <img loading="lazy" width="207" height="48" 
                                 src="<?php echo esc_url($args['logo_src']); ?>" 
                                 class="custom-logo" 
                                 alt="<?php echo esc_attr($args['logo_alt']); ?>" 
                                 decoding="async">
                        </a>
                    </div>
                    <p><?php echo esc_html($args['company_name']); ?></p>
                    <p><?php echo wp_kses_post($args['company_info']); ?></p>
                </div>

                <!-- Column 2: Footer Navigation -->
                <div class="wp-block-column">
                    <nav class="wp-block-navigation is-vertical">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'container' => false,
                            'menu_class' => 'wp-block-navigation__container',
                            'fallback_cb' => function() {
                                ?>
                                <ul class="wp-block-navigation__container">
                                    <li class="wp-block-navigation-item"><a href="/category/tax-news/">세무 뉴스</a></li>
                                    <li class="wp-block-navigation-item"><a href="/category/tax-column/">세무 칼럼</a></li>
                                    <li class="wp-block-navigation-item"><a href="/category/tax-guide/">세무 가이드</a></li>
                                    <li class="wp-block-navigation-item"><a href="/category/government-support/">정부지원사업 정보</a></li>
                                    <li class="wp-block-navigation-item"><a href="/category/faq/">자주 묻는 질문(FAQ)</a></li>
                                    <li class="wp-block-navigation-item"><a href="/category/notice/">공지사항</a></li>
                                </ul>
                                <?php
                            }
                        ));
                        ?>
                    </nav>
                </div>

                <!-- Column 3: Social Icons -->
                <div class="wp-block-column">
                    <ul class="wp-block-social-links">
                        <li class="wp-social-link wp-social-link-naver">
                            <a href="https://blog.naver.com/onfield" class="wp-block-social-link-anchor">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/social-icons/social-naver-blog.svg" alt="Naver Blog" width="24" height="24">
                                <span class="wp-block-social-link-label screen-reader-text">Naver Blog</span>
                            </a>
                        </li>
                        <li class="wp-social-link wp-social-link-facebook">
                            <a href="https://facebook.com/onfield" class="wp-block-social-link-anchor">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/social-icons/social-facebook.svg" alt="Facebook" width="24" height="24">
                                <span class="wp-block-social-link-label screen-reader-text">Facebook</span>
                            </a>
                        </li>
                        <li class="wp-social-link wp-social-link-threads">
                            <a href="https://threads.net/onfield" class="wp-block-social-link-anchor">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/social-icons/social-threads.svg" alt="Threads" width="24" height="24">
                                <span class="wp-block-social-link-label screen-reader-text">Threads</span>
                            </a>
                        </li>
                        <li class="wp-social-link wp-social-link-x">
                            <a href="https://twitter.com/onfield" class="wp-block-social-link-anchor">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/social-icons/social-twitter-x.svg" alt="X" width="24" height="24">
                                <span class="wp-block-social-link-label screen-reader-text">X</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="wp-block-spacer" style="height:30px;" aria-hidden="true"></div>
            
            <p class="copyright"><?php echo esc_html($args['copyright']); ?></p>
        </div>
    </footer>
    <?php
}

/**
 * Register Custom Footer
 * Registers a custom footer to replace the default footer
 * 
 * @param array $args Footer arguments
 */
function onfield_register_custom_footer($args = array()) {
    // Replace the default footer content while keeping the structure
    add_action('generate_footer', function() use ($args) {
        // Clear default footer output
        ob_start();
    }, 1);
    
    add_action('generate_footer', function() use ($args) {
        // Clear buffer and output custom footer
        ob_end_clean();
        onfield_custom_section_footer($args);
    }, 100);
}

/**
 * Page Hero Section
 * Renders a hero section for custom static pages with pixel-perfect Figma styles
 * Based on professional-center Figma export
 * 
 * @param array $args Section arguments
 */
function onfield_custom_section_page_hero($args = array()) {
    // Set default values
    $defaults = array(
        'title'           => '', // Can include HTML with spans for styling
        'description'     => '',
        'button_text'     => '무료 상담 신청하기',
        'button_url'      => '/request-consulting/',
        'background_image' => '', // Background image for the hero section
        'section_class'   => 'page-hero',
        'content_class'   => '', // Additional class for page-specific content styling
        'overlay_opacity' => '0.3', // Overlay opacity (0-1) - lighter default
    );
    
    // Parse arguments
    $args = wp_parse_args($args, $defaults);
    
    // Build section styles
    $section_styles = array();
    if ($args['background_image']) {
        $section_styles[] = 'background-image: url(' . esc_url($args['background_image']) . ')';
    }
    $style_attr = !empty($section_styles) ? ' style="' . implode('; ', $section_styles) . '"' : '';
    
    // Output hero section without closing containers
    ?>
    <section class="custom-section custom-section--hero <?php echo esc_attr($args['section_class']); ?>"<?php echo $style_attr; ?>>
        <?php if ($args['background_image']) : ?>
            <div class="page-hero__overlay" style="opacity: <?php echo esc_attr($args['overlay_opacity']); ?>"></div>
        <?php endif; ?>
        
        <div class="custom-section__inner grid-container">
            <div class="page-hero__content-wrapper">
                <div class="page-hero__content <?php echo esc_attr($args['content_class']); ?>">
                    <?php if ($args['title']) : ?>
                        <h1 class="page-hero__title"><?php echo wp_kses_post($args['title']); ?></h1>
                    <?php endif; ?>
                    
                    <?php if ($args['description']) : ?>
                        <p class="page-hero__description"><?php echo wp_kses_post($args['description']); ?></p>
                    <?php endif; ?>
                    
                    <?php if ($args['button_text'] && $args['button_url']) : ?>
                        <div class="page-hero__button-wrapper">
                            <a href="<?php echo esc_url($args['button_url']); ?>" class="page-hero__button">
                                <?php echo esc_html($args['button_text']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}

/**
 * Tax Hero Section (for category archives, tag archives, etc.)
 * Renders a hero section for taxonomy archive pages
 * 
 * @param array $args Section arguments
 */
function onfield_custom_section_tax_hero($args = array()) {
    // Set default values
    $defaults = array(
        'title'           => '',
        'description'     => '',
        'image'           => get_stylesheet_directory_uri() . '/assets/images/page-hero-default.jpg',
        'image_alt'       => 'Hero Image',
        'section_bg'      => '#f8f8f8',
        'section_class'   => 'tax-hero'
    );
    
    // Parse arguments
    $args = wp_parse_args($args, $defaults);
    
    // Auto-populate title and description for taxonomy pages
    if (is_category() || is_tag() || is_tax()) {
        $term = get_queried_object();
        
        if (empty($args['title'])) {
            $args['title'] = single_term_title('', false);
        }
        
        if (empty($args['description']) && !empty($term->description)) {
            $args['description'] = $term->description;
        }
    }
    
    // Close #content and #page for full-width section
    ?>
    </div><!-- #content -->
    </div><!-- #page -->
    
    <section class="custom-section custom-section--hero <?php echo esc_attr($args['section_class']); ?>" style="--section-bg: <?php echo esc_attr($args['section_bg']); ?>;">
        <div class="custom-section__inner grid-container">
            <div class="custom-section__grid custom-section__grid--content-focused">
                <div class="custom-section__content">
                    <?php if ($args['title']) : ?>
                        <h1 class="custom-section__title"><?php echo esc_html($args['title']); ?></h1>
                    <?php endif; ?>
                    
                    <?php if ($args['description']) : ?>
                        <p class="custom-section__description"><?php echo wp_kses_post($args['description']); ?></p>
                    <?php endif; ?>
                </div>
                
                <?php if ($args['image']) : ?>
                    <div class="custom-section__media">
                        <img src="<?php echo esc_url($args['image']); ?>" alt="<?php echo esc_attr($args['image_alt']); ?>">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <div id="page" class="site grid-container container hfeed">
    <div id="content" class="site-content">
    <?php
}

/**
 * Enqueue global layout system CSS
 */
add_action('wp_enqueue_scripts', 'onfield_enqueue_layout_system', 5);
function onfield_enqueue_layout_system() {
    // Main extended layout system - custom-section.css
    wp_enqueue_style(
        'custom-section',
        plugin_dir_url(dirname(__FILE__)) . 'assets/css/custom-section.css',
        array('generate-style'),
        filemtime(plugin_dir_path(dirname(__FILE__)) . 'assets/css/custom-section.css')
    );
}

/**
 * Enqueue section template styles
 */
add_action('wp_enqueue_scripts', 'onfield_enqueue_section_styles', 15);
function onfield_enqueue_section_styles() {
    // Enqueue section template styles (v1.1.0)
    wp_enqueue_style(
        'gp-section-template',
        plugin_dir_url(dirname(__FILE__)) . 'assets/css/gp-section-template.css',
        array('generate-style', 'custom-section'),
        filemtime(plugin_dir_path(dirname(__FILE__)) . 'assets/css/gp-section-template.css')
    );
    
    // Legacy sections-base.css has been removed as part of CSS refactoring
}