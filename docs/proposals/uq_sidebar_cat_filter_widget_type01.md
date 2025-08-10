# 문서 관리
- 생성일 : 2025-07-24

# 소스 위치
- mu-plugins/uq-blog-kit/includes/sidebar-cat-filter-widget.php
- mu-plugins/uq-blog-kit/assets/css/sidebar-cat-filter-widget.css
- mu-plugins/uq-blog-kit/assets/js/sidebar-cat-filter-widget.js

# Category Filter Widget Requirements
## Component Naming Convention
- Base name: uq_sidebar_cat_filter_widget_type01
- Extensible pattern: uq_sidebar_cat_filter_widget_type{number}

## Component Structure
### HTML Structure
```html
<aside class="uq_sidebar_cat_filter_widget uq_sidebar_cat_filter_widget_type01">
  <div class="widget__header">
    <h3 class="widget__title">블로그</h3>
  </div>
  
  <nav class="widget__content">
    <ul class="category-list">
      <li class="category-list__item category-list__item--active">
        <a href="#" class="category-list__link">전체</a>
      </li>
      <li class="category-list__item">
        <a href="#" class="category-list__link">이벤트</a>
      </li>
      <li class="category-list__item">
        <a href="#" class="category-list__link">성공사례</a>
      </li>
      <!-- More items... -->
    </ul>
    
    <div class="widget__footer">
      <a href="#" class="widget__more-link">채널팀 이야기 <span class="icon-external"></span></a>
    </div>
  </nav>
  
  <button class="widget__search-btn" aria-label="검색">
    <svg class="icon-search"><!-- Search icon --></svg>
  </button>
</aside>
```
### CSS Structure (SCSS)
```scss
// Base widget styles (공통)
.uq_sidebar_cat_filter_widget {
  // Common widget styles
  
  .widget__header { }
  .widget__title { }
  .widget__content { }
  .widget__footer { }
  .widget__search-btn { }
}

// Type-specific styles
.uq_sidebar_cat_filter_widget_type01 {
  // Type 01 specific styles
  
  .category-list {
    &__item {
      &--active {
        .category-list__link {
          color: var(--active-color);
          background-color: var(--active-bg-color);
        }
      }
    }
    
    &__link {
      &:hover {
        color: var(--hover-color);
        background-color: var(--hover-bg-color);
      }
    }
  }
  
  .widget__search-btn {
    color: var(--search-color);
    
    &:hover {
      color: var(--search-hover-color);
    }
  }
}
```

## Color System
### CSS Custom Properties
```css
:root {
  /* Primary active color */
  --primary-color: #5E5CE6; /* Example */
  
  /* Category item colors */
  --active-color: var(--primary-color);
  --active-bg-color: hsla(var(--primary-color-hsl), 0.1);
  
  /* Hover states - 채도를 낮춘 버전 */
  --hover-color: hsla(var(--primary-color-hsl), 0.7);
  --hover-bg-color: hsla(var(--primary-color-hsl), 0.05);
  
  /* Search button - 유사하지만 다른 색상 */
  --search-color: hsla(var(--primary-color-hsl), 0.8);
  --search-hover-color: hsla(var(--primary-color-hsl), 0.6);
}
```

# Functional Requirements

## 1. Category Navigation

- 카테고리 클릭 시 해당 카테고리 아카이브 페이지로 이동
- 현재 활성 카테고리는 --active modifier class로 표시
- Blog Posts Index Page: '전체' 또는 '홈' 항목 활성화
- Category Archive Page: 현재 카테고리 항목 활성화

## 2. Search Button Behavior

- 클릭 시 GNB 검색과 동일한 검색 팝업 트리거
- JavaScript event: openGlobalSearch()
- Keyboard accessibility: Enter/Space key support

## 3. External Link

- Widget footer의 링크는 새 탭에서 열림 (target="_blank")
- 외부 링크 아이콘 표시

# Accessibility Requirements
- Semantic HTML 사용 (<nav>, <aside>)
- ARIA labels for interactive elements
- Keyboard navigation support
- Focus states 정의
- Screen reader friendly structure

# Responsive Behavior
- Mobile: Sidebar가 상단 또는 하단으로 이동 또는 햄버거 메뉴 내부로 이동
- Tablet/Desktop: Fixed sidebar position

# Future Extensibility
## Type 02 Possibilities
- Post count 표시
- Nested categories (depth support)
- Icon support per category

## Type 03 Possibilities
- Accordion style for sub-categories
- Filter tags addition
- Sort options integration