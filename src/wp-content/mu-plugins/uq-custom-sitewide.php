<?php
/**
 * Plugin Name: UQ Custom Sitewide
 * Description: 테마 독립적인 블로그 레이아웃 라이브러리
 * Version: 1.0.1
 * Author: UQ
 * License: GPL v2 or later
 * Text Domain: uq-blog-kit
 */

// 직접 접근 방지
if (!defined('ABSPATH')) {
    exit;
}

// 플러그인 상수 정의
define('UQ_BLOG_KIT_VERSION', '1.0.1');
define('UQ_BLOG_KIT_FILE', __FILE__);
define('UQ_BLOG_KIT_URL', plugin_dir_url(__FILE__));
define('UQ_BLOG_KIT_PATH', plugin_dir_path(__FILE__));

// 메인 클래스 파일 로드
require_once UQ_BLOG_KIT_PATH . 'uq-custom-sitewide/includes/uq-blog-kit.php';

// 플러그인 초기화
add_action('init', function() {
    // 클래스가 존재하는지 확인
    if (class_exists('uq_blog_kit')) {
        // 싱글톤 패턴 대신 정적 메서드로 초기화
        // 클래스가 정적 메서드만 사용하므로 인스턴스 생성 불필요
    }
});

// 활성화 훅
register_activation_hook(__FILE__, function() {
    // 필요한 경우 활성화 시 작업 추가
    flush_rewrite_rules();
});

// 비활성화 훅
register_deactivation_hook(__FILE__, function() {
    // 필요한 경우 비활성화 시 작업 추가
    flush_rewrite_rules();
});