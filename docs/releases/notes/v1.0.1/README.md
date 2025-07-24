# 릴리즈 노트 v1.0.1

**릴리즈 날짜**: 2025-07-23

## 개요

UQ Blog Kit v1.0.1은 라이브러리 명칭을 `uq-blog-core`에서 `uq-blog-kit`으로 변경하는 주요 리팩토링 릴리즈입니다. 이는 WordPress Core와의 혼동을 피하고 라이브러리의 목적을 더 명확히 하기 위한 변경입니다.

## 주요 변경사항

### 1. 라이브러리 이름 변경
- **이전**: uq-blog-core
- **이후**: uq-blog-kit
- **이유**: 'core'라는 명칭이 WordPress Core와 혼동될 수 있어 'kit'으로 변경

### 2. 파일명 변경
```
uq-blog-core-cld.php → uq-blog-kit.php
uq-blog-core-cld.css → uq-blog-kit.css
uq-blog-core-cld.js → uq-blog-kit.js
```

### 3. 코드 리팩토링
- **PHP**:
  - 클래스명: `UQ_Blog_Core_Cld` → `uq_blog_kit`
  - 함수 접두사: `uq_blog_core_` → `uq_blog_kit_`
- **CSS**:
  - 클래스 접두사: `.uq-blog-core-` → `.uq-blog-kit-`
- **JavaScript**:
  - 네임스페이스: `uqBlogCore` → `uqBlogKit`

## 설치 가이드

### MU-Plugin 설치 (권장)

1. 메인 파일을 mu-plugins 루트에 복사:
```bash
cp src/mu-plugins/uq-custom-sitewide.php /wp-content/mu-plugins/
```

2. 리소스 디렉토리 복사:
```bash
cp -r src/mu-plugins/uq-custom-sitewide/includes/ /wp-content/mu-plugins/uq-custom-sitewide/
cp -r src/mu-plugins/uq-custom-sitewide/assets/ /wp-content/mu-plugins/uq-custom-sitewide/
```

### 디렉토리 구조
```
/wp-content/mu-plugins/
├── uq-custom-sitewide.php       # 메인 파일 (루트에 위치)
└── uq-custom-sitewide/          # 리소스 디렉토리
    ├── includes/
    │   └── uq-blog-kit.php
    └── assets/
        ├── css/
        │   └── uq-blog-kit.css
        └── js/
            └── uq-blog-kit.js
```

## 마이그레이션 가이드

### 테마에서 사용 중인 경우

1. **PHP 파일 수정**:
   ```php
   // 이전
   include('includes/uq-blog-core-cld.php');
   if (class_exists('UQ_Blog_Core')) {
       UQ_Blog_Core::render_post_card();
   }
   
   // 이후
   // mu-plugin으로 자동 로드되므로 include 불필요
   if (class_exists('uq_blog_kit')) {
       uq_blog_kit::render_post_card();
   }
   ```

2. **JavaScript 수정**:
   ```javascript
   // 이전
   window.UQBlogCore.init();
   
   // 이후
   window.UQBlogKit.init();
   ```

3. **의존성 수정**:
   ```php
   // 이전
   array('jquery', 'uq-blog-core-cld-script')
   array('uq-blog-core-cld-style')
   
   // 이후
   array('jquery', 'uq-blog-kit-script')
   array('uq-blog-kit-style')
   ```

## 호환성 정보

- **Breaking Change**: 이전 버전과 호환되지 않음
- **WordPress 버전**: 5.0 이상
- **PHP 버전**: 7.4 이상
- **의존성**: jQuery (WordPress 기본 제공)

## 알려진 이슈

없음

## 다음 버전 계획

- TypeScript 마이그레이션 검토
- 블록 에디터 지원 추가
- 성능 최적화