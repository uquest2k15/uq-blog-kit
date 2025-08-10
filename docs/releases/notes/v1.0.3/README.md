# 릴리즈 노트 v1.0.3

**릴리즈 날짜**: 2025-07-24

## 개요

UQ Blog Kit v1.0.3은 Category Filter Widget의 에셋 로딩 문제를 해결하는 패치 릴리즈입니다. 위젯이 활성화되어 있을 때 CSS와 JavaScript 파일이 자동으로 로드되지 않던 문제를 수정했습니다.

## 수정사항

### 1. Widget 에셋 자동 로딩 구현
- **문제**: Category Filter Widget이 활성화되어도 관련 CSS/JS 파일이 로드되지 않음
- **해결**: `is_active_widget()` 함수를 사용하여 위젯 활성화 감지 및 자동 에셋 로딩

### 2. JavaScript 파일 로딩 추가
- 기존에는 CSS만 고려했으나, JavaScript 파일도 함께 로드되도록 구현
- jQuery 의존성 설정

## 기술적 변경사항

### 변경된 파일
- `/includes/sidebar-cat-filter-widget.php`

### 코드 변경 내용
```php
// 이전 (없었음)

// 이후
function uq_blog_kit_enqueue_cat_filter_widget_assets() {
    if (is_active_widget(false, false, 'uq_sidebar_cat_filter_widget_type01', true)) {
        // CSS 로딩
        wp_enqueue_style(
            'sidebar-cat-filter-widget',
            UQ_BLOG_KIT_URL . 'uq-custom-sitewide/assets/css/sidebar-cat-filter-widget.css',
            array(),
            UQ_BLOG_KIT_VERSION
        );
        
        // JavaScript 로딩
        wp_enqueue_script(
            'sidebar-cat-filter-widget',
            UQ_BLOG_KIT_URL . 'uq-custom-sitewide/assets/js/sidebar-cat-filter-widget.js',
            array('jquery'),
            UQ_BLOG_KIT_VERSION,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'uq_blog_kit_enqueue_cat_filter_widget_assets');
```

## 로드되는 에셋

위젯이 활성화되면 다음 파일들이 자동으로 로드됩니다:
- `/assets/css/sidebar-cat-filter-widget.css` - 위젯 스타일
- `/assets/js/sidebar-cat-filter-widget.js` - 위젯 인터랙션 스크립트

## 업그레이드 가이드

### 자동 업데이트
MU-Plugin으로 설치된 경우 파일만 교체하면 자동으로 적용됩니다.

### 수동 업데이트
1. `/includes/sidebar-cat-filter-widget.php` 파일 교체
2. 브라우저 캐시 초기화
3. 위젯이 활성화된 페이지에서 스타일 적용 확인

## 호환성

- 이전 버전과 완전 호환
- Breaking changes 없음
- WordPress 5.0+ 지원
- PHP 7.4+ 지원

## 검증 방법

1. WordPress 관리자 > 외모 > 위젯
2. Category Filter Widget을 사이드바에 추가
3. 프론트엔드에서 해당 사이드바가 표시되는 페이지 방문
4. 개발자 도구 > Network 탭에서 다음 파일 로드 확인:
   - `sidebar-cat-filter-widget.css`
   - `sidebar-cat-filter-widget.js`

## 알려진 이슈

없음

## 다음 버전 계획

- Widget 캐싱 최적화
- 추가 위젯 타입 개발 (Type02, Type03)