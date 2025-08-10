# 변경 기록 (CHANGELOG)

모든 주요 UQ Blog Kit의 변경 사항이 여기에 기록됩니다.

## [1.1.1] - 2025-07-25

### 개선사항 (Improved)
- **Related Posts 섹션 리팩토링**
  - `uq_blog_kit::render_post_card_group()` 메서드를 직접 사용하도록 변경
  - 별도의 CSS/JS 에셋 로딩 제거 (uq_blog_kit이 자동 처리)
  - 중복된 HTML 구조 제거 및 코드 간소화
  - 컨테이너 구조 개선으로 전체 너비 활용도 향상

### 변경사항 (Changed)
- `includes/related-posts-section.php`:
  - `enqueue_assets()` 메서드 제거
  - `display_related_posts()` 메서드를 uq_blog_kit 활용하도록 재작성
  - `render_related_posts()` 메서드 구조 개선
- `assets/css/related-posts-section.css`:
  - 중복 스타일 제거 (236줄 → 83줄)
  - max-width 제한 제거로 반응형 레이아웃 개선
  - uq_blog_kit 기본 스타일과의 충돌 방지

### 수정사항 (Fixed)
- 관련 포스트 카드가 그리드의 첫 번째 컬럼에만 표시되던 문제 해결
- 그리드 레이아웃이 컨테이너 전체 너비를 활용하지 못하던 문제 해결

## [1.1.0] - 2025-07-24

### 추가사항 (Added)
- **Related Posts 기능 구현**
  - 카테고리 기반 관련 포스트 추천
  - 단일 포스트 하단에 자동 표시
  - 반응형 그리드 레이아웃 (1x3, 2x2, 1x1)
  - 기존 `uq_blog_kit` 포스트 카드 시스템 통합 지원
  - Lazy loading 및 viewport 관찰 기능
  - 글로벌 함수 `uq_display_related_posts()` 제공

### 기술적 세부사항
- 파일 구조:
  - `includes/related-posts-section.php` - 핵심 기능
  - `assets/css/related-posts-section.css` - 스타일링
  - `assets/js/related-posts-section.js` - 인터랙션
- 다양한 그리드 옵션: 1x3, 1x4, 2x2, 2x3
- 모바일 최적화: 768px 이하에서 단일 컬럼

## [1.0.4] - 2025-07-24

### 개선사항 (Improved)
- **Category Filter Widget UI 개선**
  - 위젯 타이틀 변경: "블로그 카테고리" → "블로그 주제"
  - GeneratePress 색상 시스템 통합 (--contrast, --contrast-2, --base-2, --accent 등)
  - 위젯 컨테이너 테두리 제거로 깔끔한 디자인
  - 카테고리 목록과 footer 링크 사이 수평선 추가
  - 검색 버튼을 하단으로 이동하고 전체 너비로 변경
  - 전반적인 간격 및 여백 조정

### 변경사항 (Changed)
- `widget__divider` 클래스 추가로 구분선 표시
- 검색 버튼 스타일: 원형 → 직사각형 (border-radius: 6px)
- CSS 변수를 테마 색상 시스템과 연동

## [1.0.3] - 2025-07-24

### 수정사항 (Fixed)
- **Category Filter Widget 에셋 로딩 문제 해결**
  - `sidebar-cat-filter-widget.css` 파일이 자동으로 로드되지 않던 문제 수정
  - `sidebar-cat-filter-widget.js` 파일도 함께 로드되도록 추가
  - `is_active_widget()` 함수를 사용하여 위젯이 활성화된 경우에만 에셋 로드

### 개선사항 (Improved)
- 위젯 에셋 로딩 함수명 변경: `uq_blog_kit_enqueue_cat_filter_widget_styles` → `uq_blog_kit_enqueue_cat_filter_widget_assets`
- CSS와 JavaScript를 하나의 함수에서 관리하도록 통합

## [1.0.2] - 2025-07-24

### 수정사항 (Fixed)
- **Post Card 배경색 문제 해결**
  - 기본 배경색을 GeneratePress Global Color 변수 사용하도록 변경
  - `.uq-post-card` 배경색: `#fff` → `var(--base-3, #ffffff)`
  - `.uq-post-card-group__nav:hover` 배경색: `#fff` → `var(--base-3, #ffffff)`
  - `.uq-post-card-group__pagination button` 배경색: `#fff` → `var(--base-3, #ffffff)`
  - 다크모드 기본 배경색 조정: `#1a1a1a` → `#222222`
  - GeneratePress 테마와의 호환성 개선

### 변경사항 (Changed)
- **Dark Mode 지원 비활성화**
  - `uq-blog-kit.css`의 Dark Mode CSS (`@media (prefers-color-scheme: dark)`) 주석 처리
  - 773-799줄의 Dark Mode 관련 스타일 비활성화
  - 향후 필요시 주석 해제하여 재활성화 가능

### 개선사항 (Improved)
- CSS 변수 활용으로 테마 색상 체계와의 일관성 향상
- 다크모드 지원 개선

## [1.0.1] - 2025-07-23

### 변경사항 (Changed)
- **라이브러리 이름 변경**: `uq-blog-core` → `uq-blog-kit`
  - 모든 파일명, 클래스명, 함수명 등 전체 범위 변경
  - WordPress Core와의 혼동을 피하기 위한 명칭 변경

### 파일 변경 (File Changes)
- `uq-blog-core-cld.php` → `uq-blog-kit.php`
- `uq-blog-core-cld.css` → `uq-blog-kit.css`
- `uq-blog-core-cld.js` → `uq-blog-kit.js`

### 코드 변경 (Code Changes)
- PHP 클래스명: `UQ_Blog_Core_Cld` → `uq_blog_kit`
- CSS 클래스 프리픽스: `.uq-blog-core-` → `.uq-blog-kit-`
- JS 전역 객체: `uqBlogCore` → `uqBlogKit`
- 함수 프리픽스: `uq_blog_core_` → `uq_blog_kit_`

### 설치 방법 변경 (Installation)
- mu-plugin으로 설치 시 주요 파일은 `/wp-content/mu-plugins/` 루트에 배치
- 디렉토리 구조:
  ```
  /wp-content/mu-plugins/
  ├── uq-custom-sitewide.php
  └── uq-custom-sitewide/
      ├── includes/
      └── assets/
  ```

### 호환성 (Compatibility)
- **Breaking Change**: 이전 버전과 호환되지 않음
- child-theme 업데이트 필요 (동시 배포 예정)

---

## [1.0.0] - 2025-01-20

### 최초 릴리즈 (Initial Release)
- 테마 독립적인 WordPress 블로그 라이브러리
- 포스트 카드 레이아웃 (Portrait, Horizontal 타입)
- 포스트 카드 그룹 (Gallery, Row, List 타입)
- AJAX 기반 무한 스크롤 및 페이지네이션
- 카테고리별 색상 코딩
- 반응형 디자인 지원
- 한국어 날짜 형식 지원