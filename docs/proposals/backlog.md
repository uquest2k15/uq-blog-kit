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

## Active Issues

_현재 활성 이슈가 없습니다._

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