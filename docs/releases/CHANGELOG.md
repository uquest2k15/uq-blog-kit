# 변경 기록 (CHANGELOG)

모든 주요 UQ Blog Kit의 변경 사항이 여기에 기록됩니다.

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