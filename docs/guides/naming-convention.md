# Naming Convention Guide

## 문서 관리
- 생성일: 2025-07-24
- 최종 수정일: 2025-07-24

## 개요

이 문서는 UQ Blog Kit 프로젝트의 명명 규칙을 정의합니다. WordPress 코딩 표준을 기반으로 하되, 일부 항목은 프로젝트 특성에 맞게 조정했습니다.

## PHP 명명 규칙

### 클래스명
- **규칙**: 소문자와 언더스코어 사용 (snake_case)
- **접두사**: `uq_` 사용
- **예시**:
  ```php
  class uq_blog_kit { }
  class uq_sidebar_cat_filter_widget_type01 { }
  class uq_post_grid_widget { }
  ```

### 함수명
- **규칙**: 소문자와 언더스코어 사용 (snake_case)
- **접두사**: `uq_blog_kit_` 사용 (전역 함수의 경우)
- **예시**:
  ```php
  function uq_blog_kit_register_widgets() { }
  function uq_blog_kit_enqueue_assets() { }
  function uq_blog_kit_get_categories() { }
  ```

### 메서드명
- **규칙**: 소문자와 언더스코어 사용 (snake_case)
- **접두사**: 불필요 (클래스 내부이므로)
- **예시**:
  ```php
  public function render_widget() { }
  private function get_active_category() { }
  protected function validate_input() { }
  ```

### 상수
- **규칙**: 대문자와 언더스코어 사용 (SCREAMING_SNAKE_CASE)
- **접두사**: `UQ_BLOG_KIT_` 사용
- **예시**:
  ```php
  define('UQ_BLOG_KIT_VERSION', '1.1.0');
  define('UQ_BLOG_KIT_PATH', plugin_dir_path(__FILE__));
  define('UQ_BLOG_KIT_URL', plugin_dir_url(__FILE__));
  ```

### 변수명
- **규칙**: 소문자와 언더스코어 사용 (snake_case)
- **예시**:
  ```php
  $widget_title = 'Blog Categories';
  $category_list = array();
  $is_active = false;
  ```

### WordPress 훅 (액션/필터)
- **규칙**: 소문자와 언더스코어 사용 (snake_case)
- **접두사**: `uq_blog_kit_` 사용
- **예시**:
  ```php
  do_action('uq_blog_kit_before_widget');
  apply_filters('uq_blog_kit_category_args', $args);
  add_action('uq_blog_kit_init', 'callback_function');
  ```

## 파일 및 디렉토리 명명 규칙

### PHP 파일
- **규칙**: 소문자와 하이픈 사용 (kebab-case)
- **접두사**: `uq-` 사용 (메인 파일 제외)
- **예시**:
  - `uq-blog-kit.php`
  - `sidebar-cat-filter-widget.php`
  - `uq-post-grid-widget.php`

### CSS/JS 파일
- **규칙**: PHP 파일과 동일한 이름 사용
- **예시**:
  - `uq-blog-kit.css`
  - `sidebar-cat-filter-widget.js`

### 디렉토리
- **규칙**: 소문자 사용, 복수형 권장
- **예시**:
  - `includes/`
  - `assets/`
  - `templates/`
  - `languages/`

## CSS 명명 규칙

### 클래스명
- **규칙**: BEM 방법론 + 언더스코어 사용
- **접두사**: `uq_` 사용
- **예시**:
  ```css
  .uq_sidebar_cat_filter_widget { }
  .uq_sidebar_cat_filter_widget__header { }
  .uq_sidebar_cat_filter_widget__title { }
  .category-list__item--active { }
  ```

### ID
- **규칙**: 가급적 사용하지 않음
- **필요시**: 소문자와 하이픈 사용
- **예시**: `#uq-blog-container`

### CSS 커스텀 속성 (CSS Variables)
- **규칙**: 소문자와 하이픈 사용
- **접두사**: `--uq-` 사용
- **예시**:
  ```css
  --uq-widget-primary-color: #5E5CE6;
  --uq-widget-hover-color: #4A4AE0;
  --uq-widget-text-color: #333333;
  ```

## JavaScript 명명 규칙

### 변수 및 함수
- **규칙**: camelCase 사용 (JavaScript 표준)
- **예시**:
  ```javascript
  let widgetTitle = 'Blog';
  function handleSearchClick() { }
  const categoryItems = document.querySelectorAll('.category-list__item');
  ```

### 전역 객체
- **규칙**: PascalCase 사용
- **접두사**: `UQ` 사용
- **예시**:
  ```javascript
  window.UQCategoryFilterWidget = { };
  window.UQBlogKit = { };
  ```

### jQuery 변수
- **규칙**: `$` 접두사 사용
- **예시**:
  ```javascript
  const $widget = $('.uq_sidebar_cat_filter_widget');
  const $searchBtn = $widget.find('.widget__search-btn');
  ```

## 데이터베이스 명명 규칙

### 테이블명
- **규칙**: 소문자와 언더스코어 사용
- **접두사**: `{$wpdb->prefix}uq_blog_kit_` 사용
- **예시**: `wp_uq_blog_kit_views`

### 컬럼명
- **규칙**: 소문자와 언더스코어 사용
- **예시**: `post_id`, `view_count`, `created_at`

## 위젯 타입 명명 규칙

### 위젯 클래스
- **패턴**: `uq_{location}_{function}_widget_type{number}`
- **예시**:
  - `uq_sidebar_cat_filter_widget_type01`
  - `uq_sidebar_cat_filter_widget_type02`
  - `uq_footer_recent_posts_widget_type01`

### 위젯 ID (등록시)
- **패턴**: 클래스명과 동일
- **예시**: `uq_sidebar_cat_filter_widget_type01`

## WordPress 관례와의 차이점

### 표준 WordPress 관례
```php
// WordPress Core 스타일
class WP_Widget { }
class Custom_Walker_Nav_Menu { }
function wp_enqueue_script() { }
```

### UQ Blog Kit 스타일
```php
// 우리 프로젝트 스타일
class uq_widget { }
class uq_custom_walker_nav_menu { }
function uq_blog_kit_enqueue_script() { }
```

**차이점 설명**:
- WordPress Core는 클래스명에 PascalCase를 사용하지만, 우리는 일관성을 위해 snake_case 사용
- 이는 함수명과 클래스명의 일관성을 유지하기 위함
- 상수는 WordPress 관례대로 SCREAMING_SNAKE_CASE 유지

## 예제: 새 위젯 추가시

```php
// 파일명: uq-popular-posts-widget.php

// 클래스 정의
class uq_popular_posts_widget_type01 extends WP_Widget {
    
    // 메서드
    public function render_post_list() {
        $popular_posts = $this->get_popular_posts();
        // ...
    }
    
    private function get_popular_posts($limit = 5) {
        // ...
    }
}

// 등록 함수
function uq_blog_kit_register_popular_posts_widget() {
    register_widget('uq_popular_posts_widget_type01');
}
add_action('widgets_init', 'uq_blog_kit_register_popular_posts_widget');

// CSS 클래스
.uq_popular_posts_widget { }
.uq_popular_posts_widget__item { }
.uq_popular_posts_widget__title { }

// JavaScript
const UQPopularPostsWidget = {
    init() {
        this.bindEvents();
    },
    
    bindEvents() {
        // ...
    }
};
```

## 정리

이 명명 규칙은 다음을 목표로 합니다:
1. **일관성**: 함수와 클래스 모두 snake_case 사용
2. **가독성**: 명확하고 이해하기 쉬운 이름 사용
3. **충돌 방지**: `uq_` 접두사로 다른 플러그인/테마와의 충돌 방지
4. **유지보수성**: 예측 가능한 패턴으로 쉬운 유지보수

모든 새로운 코드는 이 규칙을 따라야 하며, 기존 코드도 점진적으로 이 규칙에 맞춰 리팩토링합니다.