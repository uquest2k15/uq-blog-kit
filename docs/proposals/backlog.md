# Backlog

> 이 문서는 프로젝트의 작업 항목을 관리합니다. 향후 Git Issues로 마이그레이션될 예정입니다.

## Issue Template

각 작업 항목은 다음 형식을 따릅니다:

```markdown
### [Type] Title (#number)
- **Status**: [ ] Not Started | [ ] In Progress | [x] Completed
- **Priority**: High | Medium | Low
- **Assignee**: @username
- **Labels**: enhancement, bug, documentation, refactor
- **Milestone**: v1.1.0
- **Created**: YYYY-MM-DD
- **Updated**: YYYY-MM-DD
```

---

## Completed Issues

### [Refactor] 라이브러리 이름 변경: uq-blog-core → uq-blog-kit (#001)
- **Status**: [x] Completed
- **Priority**: High
- **Assignee**: -
- **Labels**: refactor, breaking-change
- **Milestone**: v1.0.1
- **Created**: 2025-01-22
- **Updated**: 2025-01-22
- **Completed**: 2025-01-22

#### Description
이 라이브러리는 개인 프로젝트용 라이브러리인데, 'core'라는 명칭이 WordPress Core처럼 '핵심적인', '공통적인'이라는 뉘앙스를 가져 혼동을 줄 수 있음. 더 적절한 'kit'으로 변경하여 도구 모음임을 명확히 하고자 함.

#### Acceptance Criteria
- [x] 모든 파일명이 새로운 명명 규칙을 따름
- [x] 클래스명과 함수명이 일관되게 변경됨
- [x] 기존 기능이 정상 작동함
- [x] 문서가 업데이트됨

#### Tasks
- [x] **파일명 변경**
  - [x] `uq-blog-core-cld.php` → `uq-blog-kit.php`
  - [x] `uq-blog-core-cld.css` → `uq-blog-kit.css`
  - [x] `uq-blog-core-cld.js` → `uq-blog-kit.js`

- [x] **코드 리팩토링**
  - [x] PHP 클래스명: `UQ_Blog_Core_Cld` → `uq_blog_kit`
  - [x] CSS 클래스 접두사: `.uq-blog-core-` → `.uq-blog-kit-` (주석만 변경)
  - [x] JS 네임스페이스: `uqBlogCore` → `uqBlogKit`
  - [x] 함수 접두사: `uq_blog_core_` → `uq_blog_kit_`

- [x] **파일 경로 업데이트**
  - [x] PHP include/require 문
  - [x] CSS/JS 파일 enqueue 경로
  - [x] AJAX 핸들러 참조

- [x] **문서 업데이트**
  - [x] README.md
  - [x] CLAUDE.md
  - [x] development.md
  - [x] functional.md

#### Technical Notes
```
이전 구조 (테마 내장):
/wp-content/themes/child-theme/
├── assets/
│   ├── css/uq-blog-core-cld.css
│   └── js/uq-blog-core-cld.js
└── includes/uq-blog-core-cld.php

소스 구조:
/src/mu-plugins/
├── uq-custom-sitewide.php         # 플러그인 진입점
└── uq-custom-sitewide/
    ├── assets/
    │   ├── css/uq-blog-kit.css
    │   └── js/uq-blog-kit.js
    └── includes/uq-blog-kit.php

설치 후 구조:
/wp-content/mu-plugins/
├── uq-custom-sitewide.php         # 메인 파일 (루트에 위치)
└── uq-custom-sitewide/            # 리소스 디렉토리
    ├── assets/
    │   ├── css/uq-blog-kit.css
    │   └── js/uq-blog-kit.js
    └── includes/uq-blog-kit.php
```

---

### [Feature] mu-plugin 메인 파일 생성 (#002)
- **Status**: [x] Completed
- **Priority**: High
- **Assignee**: -
- **Labels**: enhancement, setup
- **Milestone**: v1.0.1
- **Created**: 2025-01-22
- **Updated**: 2025-01-22
- **Completed**: 2025-01-22

#### Description
현재 `uq-custom-sitewide.php` 파일이 비어있음. mu-plugin으로 정상 작동하도록 메인 파일을 구현해야 함.

#### Acceptance Criteria
- [x] WordPress가 플러그인을 자동으로 로드함
- [x] 모든 기능이 정상 작동함
- [x] 에러 없이 활성화됨

#### Tasks
- [x] **플러그인 헤더 추가**
  - [x] Plugin Name, Description, Version 등
  - [x] Author 정보
  - [x] License 정보

- [x] **초기화 로직 구현**
  - [x] 라이브러리 파일 include
  - [x] 클래스 인스턴스 생성 (정적 메서드로 인해 불필요)
  - [x] 훅 등록

- [x] **에셋 로딩 설정**
  - [x] CSS/JS enqueue 함수 (라이브러리 파일에 이미 구현)
  - [x] 버전 관리
  - [x] 의존성 설정

#### Code Template
```php
<?php
/**
 * Plugin Name: UQ Custom Sitewide
 * Description: 테마 독립적인 블로그 레이아웃 라이브러리
 * Version: 1.0.1
 * Author: Your Name
 * License: GPL v2 or later
 */

// 직접 접근 방지
if (!defined('ABSPATH')) {
    exit;
}

// 상수 정의
define('UQ_BLOG_KIT_VERSION', '1.0.1');
define('UQ_BLOG_KIT_URL', plugin_dir_url(__FILE__));
define('UQ_BLOG_KIT_PATH', plugin_dir_path(__FILE__));

// 메인 클래스 로드
require_once UQ_BLOG_KIT_PATH . 'includes/uq-blog-kit.php';

// 초기화
add_action('init', function() {
    new uq_blog_kit();
});
```

---

### [Feature] 사이드바 카테고리 필터 위젯 Type01 개발 (#003)
- **Status**: [x] Completed
- **Priority**: High
- **Assignee**: -
- **Labels**: enhancement, widget
- **Milestone**: v1.1.0
- **Created**: 2025-07-24
- **Updated**: 2025-07-24
- **Completed**: 2025-07-24

#### Description
블로그 사이드바에 카테고리 필터 위젯을 추가하여 사용자가 쉽게 카테고리별로 포스트를 탐색할 수 있도록 함. Type01은 기본 스타일로 카테고리 목록, 활성 상태 표시, 검색 버튼을 포함.

#### Acceptance Criteria
- [x] WordPress 위젯으로 등록되어 위젯 영역에 추가 가능
- [x] 카테고리 목록이 동적으로 생성됨
- [x] 현재 페이지 컨텍스트에 따라 활성 카테고리 표시
- [x] 검색 버튼 클릭 시 GNB 검색 팝업 트리거
- [x] 반응형 디자인 적용
- [x] 키보드 및 스크린 리더 접근성 지원

#### Tasks
- [x] **PHP 위젯 클래스 개발**
  - [x] `WP_Widget` 클래스 상속
  - [x] 위젯 등록 및 초기화
  - [x] 카테고리 목록 가져오기 로직
  - [x] 현재 페이지 컨텍스트 감지 (is_home(), is_category())
  - [x] 위젯 출력 템플릿

- [x] **CSS 스타일링**
  - [x] 기본 위젯 구조 스타일 (`.uq_sidebar_cat_filter_widget`)
  - [x] Type01 전용 스타일 (`.uq_sidebar_cat_filter_widget_type01`)
  - [x] CSS 커스텀 속성 설정 (색상 시스템)
  - [x] 활성 상태 및 호버 효과
  - [x] 반응형 브레이크포인트

- [x] **JavaScript 기능**
  - [x] 검색 버튼 이벤트 리스너
  - [x] `openGlobalSearch()` 함수 연동
  - [x] 키보드 접근성 (Enter/Space)
  - [x] ARIA 속성 동적 업데이트

- [x] **접근성 및 테스트**
  - [x] ARIA 레이블 추가
  - [x] 포커스 상태 스타일
  - [ ] 스크린 리더 테스트
  - [ ] 크로스 브라우저 테스트

#### Technical Notes
```php
// 파일 구조
mu-plugins/uq-blog-kit/
├── includes/
│   └── widgets/
│       └── sidebar-cat-filter-widget.php
├── assets/
│   ├── css/
│   │   └── widgets/
│   │       └── sidebar-cat-filter-widget.css
│   └── js/
│       └── widgets/
│           └── sidebar-cat-filter-widget.js

// 위젯 등록
add_action('widgets_init', function() {
    register_widget('uq_sidebar_cat_filter_widget_type01');
});
```

---

### [Enhancement] Category Filter Widget UI 개선 (#004)
- **Status**: [x] Completed
- **Priority**: High
- **Assignee**: -
- **Labels**: enhancement, widget, ui
- **Milestone**: v1.0.4
- **Created**: 2025-07-24
- **Updated**: 2025-07-24
- **Completed**: 2025-07-24

#### Description
QA 테스트 결과를 바탕으로 Category Filter Widget Type01의 UI를 개선. 디자인 목업(250724_design-mockup-cat-filter-widget.png)에 맞춰 스타일과 레이아웃을 수정.

#### Background
- QA 테스트 문서: `/docs/qa/results/2025-07-24/cat-filter-widget-css개선.md`
- 1차 테스트 결과: 250724_test-results-01
- 디자인 목업과 현재 구현의 차이점 개선 필요

#### Acceptance Criteria
- [x] 위젯 타이틀 텍스트 변경: "블로그 카테고리" → "블로그 주제"
- [x] 텍스트 색상을 GeneratePress 색상 시스템 활용 (--contrast 또는 --contrast-2)
- [x] 위젯 전체 테두리 제거
- [x] 카테고리 목록과 footer 링크 사이에 수평선 추가 (--base-2 색상)
- [x] 검색 버튼 위치를 최하단으로 이동하고 간격 조정
- [x] footer 링크를 카테고리 목록 바로 다음에 배치

#### Tasks
- [x] **HTML 구조 수정**
  - [x] 위젯 타이틀 기본값 변경
  - [x] footer 링크 위치 조정
  - [x] 구분선(divider) 추가
  
- [x] **CSS 스타일 업데이트**
  - [x] 위젯 컨테이너 테두리 제거
  - [x] 텍스트 색상을 CSS 변수로 변경
  - [x] 수평선 스타일 추가
  - [x] 검색 버튼 마진 조정
  
- [x] **테스트 및 검증**
  - [x] 디자인 목업과 비교
  - [x] 다양한 테마에서 색상 변수 동작 확인
  - [x] 반응형 레이아웃 확인

#### Implementation Summary
- PHP 파일에서 타이틀 기본값과 HTML 구조 변경
- CSS에서 GeneratePress 색상 시스템 통합
- 검색 버튼을 절대 위치에서 상대 위치로 변경
- 전체적인 패딩과 마진 조정으로 깔끔한 디자인 구현

---

### [Feature] Related Posts 기능 구현 (#007)
- **Status**: [x] Completed
- **Priority**: High
- **Assignee**: -
- **Labels**: enhancement, feature
- **Milestone**: v1.1.0
- **Created**: 2025-07-24
- **Updated**: 2025-07-24
- **Completed**: 2025-07-24

#### Description
단일 포스트 페이지 하단에 관련 포스트를 표시하는 기능 구현. 카테고리 기반으로 관련성을 판단하며, 반응형 그리드 레이아웃 제공.

#### Background
- 제안서: `/docs/proposals/250724_related_posts_md`
- 사용자가 현재 읽은 포스트와 관련된 다른 콘텐츠를 쉽게 발견할 수 있도록 지원
- 사이트 내 체류 시간 증가 및 페이지뷰 향상 기대

#### Acceptance Criteria
- [x] 단일 포스트 하단에 관련 포스트 섹션 자동 표시
- [x] 동일 카테고리의 최신 포스트 3개 표시
- [x] 현재 포스트는 목록에서 제외
- [x] 반응형 그리드 레이아웃 (Desktop: 1x3, Tablet: 2x2, Mobile: 1x1)
- [x] `uq_blog_kit` 포스트 카드 시스템과 통합 가능
- [x] 글로벌 함수로 템플릿에서 쉽게 사용 가능

#### Tasks
- [x] **PHP 구현**
  - [x] `UQ_Related_Posts` 클래스 생성
  - [x] 카테고리 기반 관련 포스트 조회 로직
  - [x] `generate_after_content` hook에 자동 표시
  - [x] `uq_display_related_posts()` 글로벌 함수
  
- [x] **스타일링**
  - [x] 그리드 레이아웃 옵션 (1x3, 1x4, 2x2, 2x3)
  - [x] 포스트 카드 호버 효과
  - [x] 반응형 브레이크포인트
  
- [x] **JavaScript**
  - [x] Lazy loading 구현
  - [x] Viewport observer 패턴
  - [x] 클릭 추적 이벤트
  - [x] localStorage 활용 조회 기록

#### Implementation Summary
- 카테고리 기반 추천 알고리즘 사용
- 썸네일이 있는 포스트만 표시
- 최대 3개까지 표시 (설정 가능)
- 모바일 최적화된 단일 컬럼 레이아웃

---

## Active Issues

### [Feature] 카테고리 필터 위젯 Type02 확장 (#005)
- **Status**: [ ] Not Started
- **Priority**: Medium
- **Assignee**: -
- **Labels**: enhancement, widget
- **Milestone**: v1.2.0
- **Created**: 2025-07-24
- **Updated**: 2025-07-24

#### Description
Type01을 확장하여 포스트 개수 표시, 중첩 카테고리 지원, 아이콘 지원 기능 추가.

#### Acceptance Criteria
- [ ] Type01의 모든 기능 포함
- [ ] 카테고리별 포스트 개수 표시
- [ ] 중첩 카테고리 depth 처리
- [ ] 카테고리별 아이콘 설정 가능

---

### [Feature] 카테고리 필터 위젯 Type03 확장 (#005)
- **Status**: [ ] Not Started
- **Priority**: Low
- **Assignee**: -
- **Labels**: enhancement, widget
- **Milestone**: v1.2.0
- **Created**: 2025-07-24
- **Updated**: 2025-07-24

#### Description
아코디언 스타일의 하위 카테고리, 필터 태그, 정렬 옵션을 추가한 고급 버전.

#### Acceptance Criteria
- [ ] 하위 카테고리 아코디언 애니메이션
- [ ] 태그 기반 필터링 추가
- [ ] 정렬 옵션 (최신순/인기순)
- [ ] GSAP 애니메이션 효과

---

## Backlog Management

### Priority Levels
- **High**: 즉시 처리 필요, 다른 작업을 차단함
- **Medium**: 중요하지만 긴급하지 않음
- **Low**: 개선사항, 시간이 있을 때 처리

### Labels
- `bug`: 버그 수정
- `enhancement`: 새로운 기능
- `documentation`: 문서 작업
- `refactor`: 코드 개선
- `breaking-change`: 하위 호환성을 깨는 변경
- `setup`: 프로젝트 설정
- `test`: 테스트 관련

### Workflow
1. **Not Started**: 작업 대기 중
2. **In Progress**: 현재 작업 중
3. **Completed**: 작업 완료

### Migration to Git Issues
이 백로그는 다음과 같이 Git Issues로 전환될 예정:
- 각 섹션 → Individual Issue
- Status → Issue State (Open/Closed)
- Labels → GitHub Labels
- Assignee → GitHub Assignee
- Tasks → Issue Checklist