<?php
/**
 * 
 * 
 * 
 * 
 */

// add_filter( 'generate_copyright', 'tu_custom_copyright' );
function tu_custom_copyright() {
    // 여기에 원하는 저작권 문구를 넣거나, 빈 문자열을 반환하여 완전히 제거합니다.
    // 예시 1: 완전히 제거
    return '© 2025 온필드 블로그'; 

    // 예시 2: 사용자 정의 문구 추가
    // return '© ' . date('Y') . ' 내 웹사이트 이름. 모든 권리 보유.'; 
}



add_action( 'after_setup_theme', 'tu_remove_footer_area' );
function tu_remove_footer_area() {
    remove_action( 'generate_footer','generate_construct_footer' );
}



function gp_onfield_login_logo() {
    echo '<style type="text/css">
        #login h1 a { 
            background-image: url('.get_stylesheet_directory_uri().'/assets/images/logo/icon-onfield-removebg-preview.png) !important;
            background-size: 100% !important;
            width: 240px !important;
            height: 80px !important;
            padding-bottom: 100px !important;
        }
    </style>';
}
add_action('login_head', 'gp_onfield_login_logo');



function theme_enqueue_suit_font() {
    // 1. SUIT Variable 폰트 CSS 파일을 CDN에서 불러옵니다.
    // preload와 함께 사용되므로 wp_enqueue_style은 fallback 또는 noscript 용도로 남겨둘 수 있습니다.
    // 또는 preload 로직을 wp_head 액션에 직접 추가하고, 여기서는 스타일만 등록할 수도 있습니다.
    // 여기서는 간단하게 enqueue만 하고, preload/preconnect는 아래 wp_head에서 처리합니다.
    wp_enqueue_style(
        'suit-variable-font',
        'https://cdn.jsdelivr.net/gh/sun-typeface/SUIT@2/fonts/variable/woff2/SUIT-Variable.css',
        array(),
        '2'
    );

    // 2. 인라인 CSS로 기본 폰트 설정
    $custom_css = "
        body, button, input, select, textarea, h1, h2, h3, h4, h5, h6, p, a, li, th, td {
            font-family: 'SUIT Variable', -apple-system, BlinkMacSystemFont, system-ui, Roboto, 'Helvetica Neue', 'Segoe UI', 'Apple SD Gothic Neo', 'Noto Sans KR', 'Malgun Gothic', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', sans-serif !important;
        }
    ";
    wp_add_inline_style( 'suit-variable-font', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_suit_font' );

/**
 * Enqueue JavaScript libraries
 */
function gp_enqueue_javascript_libraries() {
    // GSAP Core and ScrollTrigger
    wp_enqueue_script(
        'gsap',
        get_stylesheet_directory_uri() . '/assets/js/vendors/GSAP@3.13/gsap.min.js',
        array(),
        '3.13.0',
        true
    );
    
    wp_enqueue_script(
        'gsap-scrolltrigger',
        get_stylesheet_directory_uri() . '/assets/js/vendors/GSAP@3.13/ScrollTrigger.min.js',
        array('gsap'),
        '3.13.0',
        true
    );
    
    // Swiper
    wp_enqueue_style(
        'swiper',
        get_stylesheet_directory_uri() . '/assets/js/vendors/Swiper/swiper-bundle.min.css',
        array(),
        '8.0.0'
    );
    
    wp_enqueue_script(
        'swiper',
        get_stylesheet_directory_uri() . '/assets/js/vendors/Swiper/swiper-bundle.min.js',
        array(),
        '8.0.0',
        true
    );
    
    // Waypoints
    wp_enqueue_script(
        'waypoints',
        'https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js',
        array('jquery'),
        '4.0.1',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'gp_enqueue_javascript_libraries' );

// Preconnect 및 Preload를 위한 <head> 태그 추가
function theme_add_font_optimization_tags() {
    // Variable 폰트 사용 시
    $font_css_url = 'https://cdn.jsdelivr.net/gh/sun-typeface/SUIT@2/fonts/variable/woff2/SUIT-Variable.css';
    // Static 폰트 사용 시 (만약 이걸 쓴다면)
    // $font_css_url = 'https://cdn.jsdelivr.net/gh/sun-typeface/SUIT@2/fonts/static/woff2/SUIT.css';

    echo '<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>';
    // CSS 파일을 preload 합니다. onload 트릭으로 non-blocking 로드를 시도합니다.
    echo '<link rel="preload" href="' . esc_url($font_css_url) . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
    // JavaScript 비활성화 시를 위한 fallback
    echo '<noscript><link rel="stylesheet" href="' . esc_url($font_css_url) . '"></noscript>';

    // 참고: SUIT-Variable.css 내부에서 실제 .woff2 폰트 파일을 로드합니다.
    // 만약 .woff2 파일 자체도 preload 하고 싶다면, 해당 파일의 정확한 URL을 알아내어 추가할 수 있습니다.
    // 예: <link rel="preload" href="https://cdn.jsdelivr.net/gh/sun-typeface/SUIT@2/fonts/variable/woff2/SUIT-Variable.woff2" as="font" type="font/woff2" crossorigin>
    // 하지만 CSS 파일을 preload하면 그 안의 font-face 정의에 따라 브라우저가 폰트를 가져오므로, CSS preload만으로도 충분할 수 있습니다.
}
// wp_enqueue_scripts보다 먼저 실행되어야 preload가 의미 있으므로 우선순위를 높이거나,
// wp_enqueue_style에서 preload link를 직접 출력하는 방법도 있습니다.
// 여기서는 wp_head에 추가합니다.
add_action( 'wp_head', 'theme_add_font_optimization_tags', 1 ); // 우선순위 1로 설정





add_filter( 'option_generate_settings', function( $settings ) {
    $settings['global_colors'] = [
        [
            'name' => __( 'Contrast', 'generatepress' ),
            'slug' => 'contrast',
            'color' => '#737373',
        ],
        [
            'name' => sprintf( __( 'Contrast %s', 'generatepress' ), '2' ),
            'slug' => 'contrast-2',
            'color' => '#525252',
        ],
        [
            'name' => sprintf( __( 'Contrast %s', 'generatepress' ), '3' ),
            'slug' => 'contrast-3',
            'color' => '#1e2838',
        ],
        [
            'name' => __( 'Base', 'generatepress' ),
            'slug' => 'base',
            'color' => '#141824',
        ],
        [
            'name' => sprintf( __( 'Base %s', 'generatepress' ), '2' ),
            'slug' => 'base-2',
            'color' => '#e1e2ed',
        ],
        [
            'name' => sprintf( __( 'Base %s', 'generatepress' ), '3' ),
            'slug' => 'base-3',
            'color' => '#f1f6ff',
        ],
        // Add more color variations here
        [
            'name' => __( 'Accent', 'generatepress' ),
            'slug' => 'accent',
            'color' => '#6268f3',
        ],
        [
            'name' => sprintf( __( 'Accent %s', 'generatepress' ), '2' ),
            'slug' => 'accent-2',
            'color' => '#feea58',
        ],
    ];

    return $settings;
} );


add_filter( 'generate_sidebar_layout', 'my_custom_archive_sidebar_layouts' );
function my_custom_archive_sidebar_layouts( $layout ) {

	// 가능한 값: 'right-sidebar', 'left-sidebar', 'no-sidebar', 'both-sidebars', 'both-right', 'both-left' 
    
    // 1. Blog Posts Index Page (블로그 글 목록 메인)
    // '설정 > 읽기'에서 '글 페이지'로 지정된 페이지를 확인합니다.
    // if ( is_home() ) {
    //     return 'no-sidebar';
    // }

	if ( is_home() || is_page( 'blog' ) ) {
        return 'left-sidebar';
    }

    // 2. Category Archive Page (카테고리 아카이브)
    if ( is_category() ) {
        return 'left-sidebar'; // 예: 왼쪽 사이드바
    }
    
    // 특정 카테고리(예: 'news')에만 다른 레이아웃을 주고 싶다면 아래처럼 할 수 있습니다.
    // if ( is_category('news') ) {
    //     return 'no-sidebar'; 
    // }

    // 3. Tag Archive Page (태그 아카이브)
    if ( is_tag() ) {
        return 'left-sidebar'; // 예: 양쪽 사이드바
    }

    // 4. Author Archive Page (작성자 아카이브)
    if ( is_author() ) {
        return 'no-sidebar'; // 예: 사이드바 없음
    }

	// 5. Single Post Page
	if ( is_single() ) {
        return 'no-sidebar'; // 예: 모든 글 페이지는 오른쪽 사이드바
    }

    // 위의 어떤 조건에도 해당하지 않으면,
    // Customizer에서 설정한 기존 레이아웃 값을 그대로 사용합니다.
    // 이 부분이 매우 중요합니다! (다른 페이지에 영향을 주지 않기 위함)
    return $layout;
}

add_filter( 'option_generate_settings', function( $settings ) {
    // if ( is_page_template( 'my-custom-full-width-template.php' ) ) {


        /**
         * Customizer → Layout → Container
         */
        $settings['container_width']        = '1200'; // 옵션명 확인완료, default 1200px
        $settings['content_layout_setting'] = 'one-container'; // 옵션명 확인완료, options(separate-containers, one-container) default(one-container)
        $settings['container_alignment']    = 'text'; // 옵션명 확인완료, options(boxes, text), default(boxes)

        /**
         * Customizer → Layout → Header
         */
        $settings['header_layout_setting']   = 'fluid-header'; // 옵션명 확인완료, options(fluid-header, contained-header), default(fluid-header)
        $settings['header_inner_width']       = 'contained'; // 옵션명 확인완료, options(contained, full-width), default(contained)
        $settings['header_alignment_setting'] = 'left'; // 옵션명 확인완료, options(left, center, right), default(left)
        // Checkbox - Use Navigation as Header default(unchecked)
        // Mobile Header - options(Off, On), default(off) 

        /**
         * Customizer → Layout → Primary Navigation
         */
        // Mobile Menu Label : default('')
        // Mobile Menu Breakpoint : default(768 px)
        $settings['nav_layout_setting']       = 'fluid-nav'; // 옵션명 확인완료, default(fluid-nav), options(fluid-nav, contained-nav)
        $settings['nav_inner_width']          = 'contained'; // 옵션명 확인완료, default(contained), options(contained, full-width)
        $settings['nav_alignment_setting']    = 'right'; // 옵션명 확인완료, default(right), optinos(right, center, left)
        // Navigation Location은 Customizer → Layout → Header 에서 Use Navigation as Header에서 unchecked이면 활성화된다.
        $settings['nav_position_setting']     = 'nav-float-right'; // 옵션명 확안완료 default(nav-float-right), options(nav-below-header, nav-above-header, nav-float-right, nav-float-left, nav-left-sidebar, nav-right-sidebar, no-navigation_
        $settings['nav_drop_point']           = ''; // default: ''(empty string), Navigation Drop Point, The width when the navigation ceases to float and drops below your logo.
        $settings['nav_dropdown_type']        = 'hover'; // options(hover, click (not click-menu), click-arrow), default(hover)
        $settings['nav_dropdown_direction']   = 'right'; // options(right, left), default(right)
        $settings['nav_search_modal']         = 'enable'; // 'enable', ''(empty string) - disable. default(unchecked)

        /**
         * Customizer → Layout → Sidebars
         */
        // Sidebar Layout
        $settings['layout_setting']         = 'left-sidebar'; // 옵션명 확인완료, default(right-sidebar), right-sidebar, left-sidebar, no-sidebar, both-sidebars, both-left, both-right
        // Blog Sidebar Layout
        $settings['blog_layout_setting']    = 'left-sidebar'; // 옵션명 확인완료, default(right-sidebar), right-sidebar, left-sidebar, no-sidebar, both-sidebars, both-left, both-right
        // Single Post  Sidebar Layout
        $settings['single_layout_setting']  = 'no-sidebar'; // 옵션명 확인완료, default(right-sidebar), right-sidebar, left-sidebar, no-sidebar, both-sidebars, both-left, both-right

        /**
         * Customizer → Layout → Footer
         */
        $settings['footer_layout_setting'] = 'fluid-footer'; // 옵션명 확인완료, default(fluid-footer), fluid-footer, contained-footer
        $settings['footer_inner_width']    = 'contained'; // 옵션명 확인완료, default(contained), contained, full-width
        $settings['footer_widget_setting'] = '3'; // 옵션명 확인완료, default(3), 0, 1, 2, 3, 4, 5
        $settings['back_to_top']           = ''; // 옵션명 확인완료, default(''), 'enable', ''(empty string) - disable
    // }
    return $settings;
});

add_filter( 'option_generate_spacing_settings', function( $settings ) {
    // if ( is_page_template( 'my-custom-full-width-template.php' ) ) {

        /**
         * Customizer → Layout → Container
         */
        $settings['separator'] = '20'; // 옵션명 확인완료 Separating Space, default 20px
        // Content Separator 옵션명 미확인, default 2em
        $settings['content_top']           = '40'; // default 40px
        $settings['content_right']         = '40'; // default 40px
        $settings['content_bottom']        = '40'; // default 40px
        $settings['content_left']          = '40'; // default 40px
        $settings['mobile_content_top']    = '30'; // default 30px
        $settings['mobile_content_right']  = '30'; // default 30px
        $settings['mobile_content_bottom'] = '30'; // default 30px
        $settings['mobile_content_left']   = '30'; // default 30px

        /**
         * Customizer → Layout → Header
         */
        $settings['header_top']           = '20'; // default 20px
        $settings['header_right']         = '40'; // default 40px
        $settings['header_bottom']        = '20'; // default 20px
        $settings['header_left']          = '40'; // default 40px
        $settings['mobile_header_top']    = '';   // default ''
        $settings['mobile_header_right']  = '30'; // default 30px
        $settings['mobile_header_bottom'] = '';   // default ''
        $settings['mobile_header_left']   = '30'; // default 30px

        /**
         * Customizer → Layout → Primary Navigation
         */
        $settings['menu_item']               = '20'; // 옵션명 확인완료 Menu Item Width, default(20px)
        $settings['menu_item_height']        = '60'; // 옵션명 확인완료 Menu Item Height, default(60px)
        $settings['mobile_menu_item']        = ''; //  옵션명 확인완료 Mobile Menu Item Width, default('' emptyh string)
        $settings['mobile_menu_item_height'] = ''; // 옵션명 확인완료 Mobile Menu Item Height, default('' emptyh string)
        $settings['sub_menu_item_height']    = '10'; // 옵션명 미확인 Sub-Menu Item Height, default(10px)
        $settings['sub_menu_width']          = '200'; // 옵션명 확인완료 Sub-Menu Width, default(200px)

        /**
         * Customizer → Layout → Sidebars
         */
        $settings['widget_top']           = '40'; // default(40px)
        $settings['widget_right']         = '40'; // default(40px)
        $settings['widget_bottom']        = '40'; // default(40px)
        $settings['widget_left']          = '40'; // default(40px)
        $settings['mobile_widget_top']    = '30'; // default(30px)
        $settings['mobile_widget_right']  = '30'; // default(30px)
        $settings['mobile_widget_bottom'] = '30'; // default(30px)
        $settings['mobile_widget_left']   = '30'; // default(30px)
        $settings['left_sidebar_width']  = '30'; // percentage(%) default: 30%
        $settings['right_sidebar_width'] = '30'; // percentage(%) default: 30%

        /**
         * Customizer → Layout → Footer
         */
        $settings['footer_widget_container_top']           = '40'; // default(40px)
        $settings['footer_widget_container_right']         = '40'; // default(40px)
        $settings['footer_widget_container_bottom']        = '40'; // default(40px)
        $settings['footer_widget_container_left']          = '40'; // default(40px)
        $settings['mobile_footer_widget_container_top']    = '30'; // default(30px)
        $settings['mobile_footer_widget_container_right']  = '30'; // default(30px)
        $settings['mobile_footer_widget_container_bottom'] = '30'; // default(30px)
        $settings['mobile_footer_widget_container_left']   = '30'; // default(30px)
        $settings['footer_top']    = '20'; // default(20px)
        $settings['footer_right']  = '40'; // default(40px)
        $settings['footer_bottom'] = '20'; // default(20px)
        $settings['footer_left']   = '40'; // default(40px)

    // }
    return $settings;
});

add_filter( 'option_generate_menu_plus_settings', function( $settings ) {
    if ( is_page_template( 'my-custom-full-width-template.php' ) ) {
        // Customizer → Layout → Primary Navigation
        $settings['mobile_menu_breakpoint'] = '768'; // 옵션명 미확인 Change mobile menu breakpoint
        $settings['mobile_header'] = 'on'; // 옵션명 미확인 Mobile Header Off/On
        $settings['mobile_menu_label'] = 'Menu'; // 옵션명 미확인 Mobile Menu Label
    }
    return $settings;
});