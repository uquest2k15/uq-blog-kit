# UQ Blog Kit 개발 가이드

## 목차

1. 개요
2. 설치 방법
3. 기본 사용법
4. Post Card
5. Post Card Group
6. 레이아웃 타입
7. 고급 사용 예제
8. CSS 커스터마이징
9. JavaScript API
10. 반응형 지원
11. 브라우저 호환성

## 개요

UQ Blog Kit은 WordPress 테마에 독립적으로 동작하는 블로그 레이아웃 라이브러리입니다. 다양한 포스트 카드 레이아웃과 그룹 레이아웃을 제공하며, 반응형 디자인과 동적 기능을 포함합니다.

### 주요 특징

- **테마 독립적**: 어떤 WordPress 테마에서도 동일하게 작동
- **다양한 레이아웃**: Gallery, Row, List 등 다양한 레이아웃 지원
- **반응형 디자인**: 모바일, 태블릿, 데스크톱 완벽 지원
- **동적 기능**: 무한 스크롤, 페이지네이션, 슬라이더 등
- **한국어 최적화**: 한국어 날짜 형식 및 이름 표시 지원

### 파일 구성

```
uq-blog-kit.php       # 메인 PHP 클래스 (이전: uq-blog-core-cld.php)
uq-blog-kit.css       # 스타일시트 (이전: uq-blog-core-cld.css)
uq-blog-kit.js        # JavaScript (이전: uq-blog-core-cld.js)
```

## 설치 방법

### MU-Plugin으로 설치 (권장)

```bash
# 1. 메인 파일을 mu-plugins 루트에 복사
cp src/mu-plugins/uq-custom-sitewide/uq-custom-sitewide.php /wp-content/mu-plugins/

# 2. 리소스 디렉토리 복사
cp -r src/mu-plugins/uq-custom-sitewide/includes/ /wp-content/mu-plugins/uq-custom-sitewide/
cp -r src/mu-plugins/uq-custom-sitewide/assets/ /wp-content/mu-plugins/uq-custom-sitewide/
```

**중요**: WordPress mu-plugins는 루트 디렉토리의 PHP 파일만 자동으로 로드합니다.

### 1. 파일 업로드

WordPress mu-plugins 디렉토리에 플러그인을 설치합니다:

```
/wp-content/mu-plugins/
├── uq-custom-sitewide.php
└── uq-custom-sitewide/
    ├── includes/
    │   └── uq-blog-kit.php
    └── assets/
        ├── css/
        │   └── uq-blog-kit.css
        └── js/
            └── uq-blog-kit.js
```

### 2. mu-plugin 자동 로드

mu-plugins 디렉토리에 설치하면 WordPress가 자동으로 플러그인을 로드합니다. 별도의 활성화 과정이 필요 없습니다.

### 3. 에셋 자동 로드

플러그인이 CSS/JS 파일을 자동으로 등록합니다. 추가 설정이 필요하지 않습니다.

## 기본 사용법

### 단일 포스트 카드 렌더링

```php
// 기본 사용
echo uq_blog_kit::render_post_card($post_id);

// 옵션 지정
echo uq_blog_kit::render_post_card($post_id, array(
    'layout' => 'portrait',
    'show_category' => true,
    'show_tags' => true
));
```

### 포스트 카드 그룹 렌더링

```php
// 포스트 ID 배열 준비
$post_ids = array(123, 124, 125, 126, 127);

// Gallery 레이아웃
echo uq_blog_kit::render_post_card_group($post_ids, array(
    'layout_type' => 'gallery',
    'columns' => 3
));
```

## Post Card

### 개념

Post Card는 개별 포스트를 표시하는 기본 단위입니다. 두 가지 레이아웃을 지원합니다.

### 구성 요소

1. **Category** (선택) - 카테고리 표시
2. **Featured Image** (필수) - 대표 이미지
3. **Post Title** (필수) - 포스트 제목
4. **Post Excerpt** (필수) - 포스트 요약
5. **Post Date · Post Author** (선택) - 날짜와 작성자
6. **Tag List** (선택) - 태그 목록

### 레이아웃 타입

#### Portrait Layout (세로형)

```
┌─────────────────────┐
│  Category (선택)    │
├─────────────────────┤
│                     │
│   Featured Image    │
│                     │
├─────────────────────┤
│  Post Title         │
│  Post Excerpt       │
│  Date · Author      │
│  #tag1 #tag2        │
└─────────────────────┘
```

#### Horizontal Layout (가로형)

```
┌───────────┬────────────────┐
│           │ Category       │
│  Featured │ Post Title     │
│   Image   │ Post Excerpt   │
│           │ Date · Author  │
│           │ #tag1 #tag2    │
└───────────┴────────────────┘
```

### Post Card 옵션

| 옵션               | 타입    | 기본값         | 설명                                        |
| ------------------ | ------- | -------------- | ------------------------------------------- |
| `layout`           | string  | 'portrait'     | 'portrait' 또는 'horizontal'                |
| `image_position`   | string  | 'left'         | 'left' 또는 'right' (horizontal 레이아웃만) |
| `show_category`    | boolean | true           | 카테고리 표시 여부                          |
| `show_date_author` | boolean | true           | 날짜와 작성자 표시 여부                     |
| `show_tags`        | boolean | true           | 태그 목록 표시 여부                         |
| `max_height`       | string  | ''             | 최대 높이 (예: '400px')                     |
| `title_lines`      | integer | 2              | 제목 최대 줄 수                             |
| `excerpt_lines`    | integer | 3              | 요약 최대 줄 수                             |
| `excerpt_length`   | integer | 150            | 요약 단어 수                                |
| `date_format`      | string  | 'Y년 m월 d일'  | 날짜 형식                                   |
| `author_format`    | string  | 'display_name' | 'display_name' 또는 'full_name'             |
| `card_class`       | string  | ''             | 추가 CSS 클래스                             |
| `image_size`       | string  | 'medium_large' | WordPress 이미지 크기                       |

### 사용 예제

```php
// Portrait 레이아웃 (기본)
echo uq_blog_kit::render_post_card($post_id, array(
    'layout' => 'portrait',
    'show_tags' => false,
    'excerpt_lines' => 2
));

// Horizontal 레이아웃
echo uq_blog_kit::render_post_card($post_id, array(
    'layout' => 'horizontal',
    'image_position' => 'right',
    'show_category' => true,
    'date_format' => 'Y.m.d'
));

// 작성자 전체 이름 표시
echo uq_blog_kit::render_post_card($post_id, array(
    'author_format' => 'full_name' // 성 + 이름
));
```

## Post Card Group

### 개념

Post Card Group은 여러 개의 Post Card를 묶어서 표시하는 컨테이너입니다. 3가지 레이아웃 타입을 제공합니다.

### Post Card Group 옵션

#### 공통 옵션

| 옵션           | 타입   | 기본값    | 설명                     |
| -------------- | ------ | --------- | ------------------------ |
| `layout_type`  | string | 'gallery' | 'gallery', 'row', 'list' |
| `card_options` | array  | array()   | 개별 카드 옵션           |
| `group_class`  | string | ''        | 추가 CSS 클래스          |
| `gap`          | string | '20px'    | 카드 간격                |
| `wrapper_id`   | string | ''        | 래퍼 ID                  |

#### Gallery Layout 옵션

| 옵션              | 타입    | 기본값 | 설명                  |
| ----------------- | ------- | ------ | --------------------- |
| `columns`         | integer | 3      | 컬럼 수 (1, 2, 3)     |
| `masonry`         | boolean | false  | Masonry 레이아웃 사용 |
| `pagination`      | boolean | true   | 페이지네이션 표시     |
| `infinite_scroll` | boolean | false  | 무한 스크롤 사용      |

#### Row Layout 옵션

| 옵션              | 타입    | 기본값 | 설명               |
| ----------------- | ------- | ------ | ------------------ |
| `cards_per_row`   | integer | 3      | 한 줄당 카드 수    |
| `enable_slide`    | boolean | false  | 슬라이드 기능 사용 |
| `enable_carousel` | boolean | false  | 캐러셀 기능 사용   |

#### List Layout 옵션

| 옵션                   | 타입    | 기본값 | 설명              |
| ---------------------- | ------- | ------ | ----------------- |
| `list_pagination`      | boolean | true   | 페이지네이션 표시 |
| `list_infinite_scroll` | boolean | false  | 무한 스크롤 사용  |

## 레이아웃 타입

### 1. Gallery Layout

격자 형태로 카드를 배치하는 레이아웃입니다.

```php
// 기본 Gallery (3컬럼)
echo uq_blog_kit::render_post_card_group($post_ids, array(
    'layout_type' => 'gallery',
    'columns' => 3,
    'card_options' => array(
        'layout' => 'portrait'
    )
));

// Masonry Gallery
echo uq_blog_kit::render_post_card_group($post_ids, array(
    'layout_type' => 'gallery',
    'columns' => 3,
    'masonry' => true,
    'infinite_scroll' => true
));
```

### 2. Row Layout

가로 한 줄로 카드를 배치하는 레이아웃입니다.

```php
// 기본 Row
echo uq_blog_kit::render_post_card_group($post_ids, array(
    'layout_type' => 'row',
    'cards_per_row' => 4
));

// 캐러셀 Row
echo uq_blog_kit::render_post_card_group($post_ids, array(
    'layout_type' => 'row',
    'cards_per_row' => 3,
    'enable_carousel' => true
));
```

### 3. List Layout

세로 목록 형태로 카드를 배치하는 레이아웃입니다.

```php
// 페이지네이션 List
echo uq_blog_kit::render_post_card_group($post_ids, array(
    'layout_type' => 'list',
    'list_pagination' => true,
    'card_options' => array(
        'layout' => 'horizontal',
        'show_tags' => true
    )
));

// 무한 스크롤 List
echo uq_blog_kit::render_post_card_group($post_ids, array(
    'layout_type' => 'list',
    'list_infinite_scroll' => true
));
```

## 고급 사용 예제

### 1. 최신 포스트 갤러리

```php
// 최신 포스트 12개를 Gallery로 표시
$recent_posts = get_posts(array(
    'numberposts' => 12,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
));

$post_ids = wp_list_pluck($recent_posts, 'ID');

echo uq_blog_kit::render_post_card_group($post_ids, array(
    'layout_type' => 'gallery',
    'columns' => 3,
    'pagination' => true,
    'card_options' => array(
        'layout' => 'portrait',
        'show_category' => true,
        'show_tags' => false,
        'excerpt_lines' => 2
    )
));
```

### 2. 카테고리별 포스트 슬라이더

```php
// 특정 카테고리의 포스트를 슬라이더로 표시
$category_posts = get_posts(array(
    'category' => 5, // 카테고리 ID
    'numberposts' => 8,
    'post_status' => 'publish'
));

$post_ids = wp_list_pluck($category_posts, 'ID');

echo uq_blog_kit::render_post_card_group($post_ids, array(
    'layout_type' => 'row',
    'cards_per_row' => 4,
    'enable_carousel' => true,
    'card_options' => array(
        'layout' => 'portrait',
        'show_category' => false, // 카테고리 숨김
        'show_date_author' => false,
        'title_lines' => 2
    )
));
```

### 3. 작성자 아카이브 페이지

```php
// 특정 작성자의 포스트 목록
$author_posts = get_posts(array(
    'author' => $author_id,
    'numberposts' => 20,
    'post_status' => 'publish'
));

$post_ids = wp_list_pluck($author_posts, 'ID');

echo uq_blog_kit::render_post_card_group($post_ids, array(
    'layout_type' => 'list',
    'list_pagination' => true,
    'card_options' => array(
        'layout' => 'horizontal',
        'image_position' => 'left',
        'show_date_author' => true,
        'author_format' => 'full_name'
    )
));
```

### 4. Magazine 스타일 레이아웃

```php
// 카테고리별로 그룹핑된 매거진 레이아웃
$categories = get_categories(array(
    'orderby' => 'name',
    'order' => 'ASC',
    'number' => 5
));

foreach ($categories as $category) {
    echo '<section class="magazine-section">';
    echo '<h2>' . esc_html($category->name) . '</h2>';
    
    $cat_posts = get_posts(array(
        'category' => $category->term_id,
        'numberposts' => 6,
        'post_status' => 'publish'
    ));
    
    $post_ids = wp_list_pluck($cat_posts, 'ID');
    
    echo uq_blog_kit::render_post_card_group($post_ids, array(
        'layout_type' => 'gallery',
        'columns' => 3,
        'card_options' => array(
            'layout' => 'portrait',
            'show_category' => false
        )
    ));
    
    echo '</section>';
}
```

### 5. 관련 포스트 표시

```php
// 현재 포스트와 같은 카테고리의 관련 포스트
global $post;
$categories = wp_get_post_categories($post->ID);

$related_posts = get_posts(array(
    'category__in' => $categories,
    'post__not_in' => array($post->ID),
    'numberposts' => 4,
    'orderby' => 'rand'
));

if ($related_posts) {
    $post_ids = wp_list_pluck($related_posts, 'ID');
    
    echo '<div class="related-posts">';
    echo '<h3>관련 포스트</h3>';
    echo uq_blog_kit::render_post_card_group($post_ids, array(
        'layout_type' => 'row',
        'cards_per_row' => 4,
        'card_options' => array(
            'layout' => 'portrait',
            'show_date_author' => false,
            'show_tags' => false,
            'excerpt_lines' => 2
        )
    ));
    echo '</div>';
}
```

## CSS 커스터마이징

### CSS 변수

라이브러리는 CSS 변수를 사용하여 쉽게 커스터마이징할 수 있습니다.

```css
/* 테마의 style.css 또는 커스텀 CSS에 추가 */
:root {
    /* 색상 */
    --uq-primary-color: #333;
    --uq-secondary-color: #666;
    --uq-accent-color: #0073aa;
    --uq-border-color: #e0e0e0;
    --uq-bg-color: #f5f5f5;
    --uq-text-color: #333;
    --uq-meta-color: #999;
    
    /* 간격 및 크기 */
    --uq-gap: 20px;
    --uq-border-radius: 8px;
    
    /* 트랜지션 */
    --uq-transition: all 0.3s ease;
}
```

### 커스텀 스타일 예제

#### 다크 테마

```css
.dark-theme {
    --uq-primary-color: #fff;
    --uq-secondary-color: #ccc;
    --uq-accent-color: #4a9eff;
    --uq-border-color: #444;
    --uq-bg-color: #222;
    --uq-text-color: #fff;
    --uq-meta-color: #999;
}

.dark-theme .uq-post-card {
    background: #1a1a1a;
}
```

#### 카드 스타일 변경

```css
/* 그림자 제거 및 테두리 추가 */
.uq-post-card {
    box-shadow: none;
    border: 2px solid var(--uq-border-color);
}

/* 호버 효과 변경 */
.uq-post-card:hover {
    transform: translateY(-5px);
    border-color: var(--uq-accent-color);
}

/* 카테고리 스타일 변경 */
.uq-post-card__category-link {
    background: transparent;
    color: var(--uq-accent-color);
    border: 1px solid var(--uq-accent-color);
}
```

#### 간격 조정

```css
/* 모바일에서 간격 줄이기 */
@media (max-width: 768px) {
    :root {
        --uq-gap: 12px;
    }
    
    .uq-post-card__content {
        padding: 12px;
    }
}
```

## JavaScript API

### 전역 객체

```javascript
// UQBlogKit 객체에 접근
window.UQBlogKit
```

### 메소드

#### init()

모든 그룹을 초기화합니다.

```javascript
UQBlogKit.init();
```

#### initGalleryLayout($group)

특정 Gallery 레이아웃을 초기화합니다.

```javascript
var $group = $('#my-gallery');
UQBlogKit.initGalleryLayout($group);
```

#### initRowLayout($group)

특정 Row 레이아웃을 초기화합니다.

```javascript
var $group = $('#my-slider');
UQBlogKit.initRowLayout($group);
```

#### initListLayout($group)

특정 List 레이아웃을 초기화합니다.

```javascript
var $group = $('#my-list');
UQBlogKit.initListLayout($group);
```

### 이벤트 훅

#### 카드 클릭 이벤트

```javascript
$(document).on('click', '.uq-post-card', function(e) {
    var $card = $(this);
    var postId = $card.data('post-id');
    // 커스텀 동작
});
```

#### 무한 스크롤 완료 이벤트

```javascript
$(document).ajaxComplete(function(event, xhr, settings) {
    if (settings.url.includes('uq_load_more_posts')) {
        // 새 포스트 로드 완료 후 동작
    }
});
```

### 커스텀 초기화

```javascript
jQuery(document).ready(function($) {
    // 특정 조건에서만 초기화
    if ($('.custom-condition').length) {
        $('.uq-post-card-group').each(function() {
            var $group = $(this);
            // 커스텀 옵션으로 재초기화
            $group.attr('data-columns', '2');
            UQBlogKit.initGalleryLayout($group);
        });
    }
});
```

## 반응형 지원

### 브레이크포인트

- **데스크톱**: 1025px 이상
- **태블릿**: 768px - 1024px
- **모바일**: 767px 이하

### 반응형 동작

#### Gallery Layout

| 화면 크기 | 컬럼 수      |
| --------- | ------------ |
| 데스크톱  | 설정값 (1-3) |
| 태블릿    | 최대 2       |
| 모바일    | 1            |

#### Row Layout

| 화면 크기 | 카드 수 |
| --------- | ------- |
| 데스크톱  | 설정값  |
| 태블릿    | 최대 2  |
| 모바일    | 1       |

#### Horizontal Card

모바일에서는 자동으로 Portrait 레이아웃으로 변환됩니다.

### 반응형 커스터마이징

```css
/* 태블릿에서 3컬럼 유지 */
@media (max-width: 1024px) and (min-width: 768px) {
    .uq-post-card-group--gallery.uq-post-card-group--columns-3 .uq-post-card-group__inner {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* 모바일에서 카드 스타일 조정 */
@media (max-width: 767px) {
    .uq-post-card__title {
        font-size: 16px;
    }
    
    .uq-post-card__excerpt {
        -webkit-line-clamp: 2;
    }
}
```

## 브라우저 호환성

### 지원 브라우저

- Chrome 60+
- Firefox 60+
- Safari 12+
- Edge 79+
- iOS Safari 12+
- Chrome for Android 60+

### Polyfill 필요 기능

- CSS Grid (IE11)
- CSS Custom Properties (IE11)
- IntersectionObserver (구형 브라우저)

### jQuery 버전

- jQuery 1.12.4+ (WordPress 기본)
- jQuery 3.0+ 권장

## 문제 해결

### 일반적인 문제

#### 1. 스타일이 적용되지 않음

- CSS 파일이 올바르게 로드되었는지 확인
- 테마의 CSS가 라이브러리 스타일을 덮어쓰지 않는지 확인
- 브라우저 캐시 삭제

#### 2. JavaScript 기능이 작동하지 않음

- jQuery가 로드되었는지 확인
- 콘솔에서 JavaScript 에러 확인
- AJAX URL과 nonce가 올바르게 설정되었는지 확인

#### 3. 무한 스크롤이 작동하지 않음

- AJAX 액션이 등록되었는지 확인
- 네트워크 탭에서 AJAX 요청 확인
- PHP 에러 로그 확인

### 디버깅 팁

```javascript
// 디버그 모드 활성화
window.UQBlogKitDebug = true;

// 콘솔에서 상태 확인
console.log($('.uq-post-card-group').data());
```

## 업데이트 내역

### v1.0.1 (2025-01-22)

- 라이브러리 이름 변경: UQ Blog Core → UQ Blog Kit
- mu-plugin으로 전환
- 클래스명 변경: UQ_Blog_Core_Cld → uq_blog_kit

### v1.0.0 (2025-01-09)

- 초기 릴리즈
- Portrait/Horizontal 카드 레이아웃
- Gallery/Row/List 그룹 레이아웃
- 무한 스크롤, 페이지네이션, 슬라이더 기능
- 한국어 최적화