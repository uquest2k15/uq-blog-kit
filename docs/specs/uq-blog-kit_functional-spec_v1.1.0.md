# uq-blog-kit 라이브러리

## Objective

- WordPress의 Theme와 상관없이(의존하지 않고) 블로그 페이지 및 레이아웃을 퍼블리싱 하기 위해서 필요한 핵심적인 PHP(HTML), CSS, JS를 만든다.
- 우선은 한국어 버전만 고려해서 개발한다.
- 차후에 영어, 일본어 버전을 고려해서 날짜 형식, 이름 형식 등을 처리

## 라이브러리 구성

- uq-blog-kit.php
- uq-blog-kit.js
- uq-blog-kit.css

## 요청사항

- Post Card의 HTML를 덤프하는 PHP함수를 제작
- Post Card Group를 덤프하는 PHP함수를 제작
- Post Card와 Post Card Group의 모든 옵션을 고려하여 제작

## 블로그 컴포넌트 구성 및 레이아웃

### 0. 개념 및 계층 구조(Hierarchy)

```script
Post Card : 개별 카드
    └── Post Card Group (Post Card의 묶음으로 레이아웃과 무관. 하위 계층에서 레이아웃에 따라 분류)
            ├── Gallery Layout (Option: Masonry, Pagination, 무한로드)
            ├── Row Layout (Option: NumCards, Slide, Carousel)
            └── List Layout (Option: Pagination, 무한로드)
```

### 1. Post Card

#### 1-1. 구성

- Category (선택)
- Featured Image (필수)
- Post Title (필수)
- Post Excerpt (필수)
- Post Date · Post Author (선택)
- Tag List (선택)

#### 1-2. 고려할 사항

- 옵션으로 Category, Post Date · Post Author, Tag List의 포함 여부 지정
- Post Card의 Max Height 지정 여부, 지정한다면 크기를 얼마로 하는가?
- Post Title의 텍스트 줄바꿈(Text Wrap)허용 여부, 허용한다면 몇 줄 까지 가능한지? 2줄이 적당한 것 같음.

##### Post Excerpt

- Post Excerpt가 Empty라면? Post Content의 앞부분을 발췌해 올 것인가? 혹은 요약해서 가져올 것인가?
- Post Excerpt의 텍스트 줄바꿈(Text Wrap)허용 여부, 허용한다면 몇 줄 까지 가능한지? 2~3줄이 적당한 것 같음.
- Post Date의 표시 형식은 어떻게 할 것인가? YYYY-MM-HH? YYYY-MM? 1일전? 2일전?
- Post Author는 wp_users 테이블의 display_name를 보여줄 것인가? 혹은 wp_usermeta에서 lastname, firstname을 가져와서 보여줄 것인가?

#### 1-3 Post Card Layout

##### 1-3-1. Horizontal Layout

- (Option) Category 표시 여부에 따라 Category 표시 여부가 true이면, 아래의 2단 구성의 위에 표시된다.
- 2단 구성(한쪽은 Featured Image, 다른 한쪽은 Title, Excerpt, Date·Author, Tag List 등의 정보)
- (Option) image-position : left or right

###### image-position : left

|                            |                       |
| :------------------------- | :-------------------- |
| Category Term Name(Option) |                       |
| Featured Image             | Post Title            |
|                            | Post Excerpt          |
|                            | Post Date·Post Author |
|                            | Tag List              |



###### image-position : right

|                                |                |
| :----------------------------- | :------------- |
| Category Term Name(Option)     |                |
| Post Title                     | Featured Image |
| Post Excerpt                   |                |
| Post Date·Post Author (Option) |                |
| Tag List (Option)              |                |
|                                |                |

##### 1-3-2. Portlait Layout

- 1단 구성성, 위에서부터 아래로 Stacked 혹은 Vertical

|                                |
| :----------------------------- |
| Category Term Name(Option)     |
| Featured Image                 |
| Post Title                     |
| Post Excerpt                   |
| Post Date·Post Author (Option) |
| Tag List (Option)              |
|                                |


### 2. Post Card Group Layout

#### 2-1. Type 1 : Gallery Layout

##### Option(선택사항)

- Masonry 여부
- Pagination vs 무한로딩
- Column 갯수(3 Columns, 2 Colmns, 1 Column)

#### 2-2. Type 2 : Row Layout

##### Option(선택사항)

- NumCards : 1줄에 들어가는 포스트 카드 갯수
- Slide/Carousel 여부

#### 2-3. Type 3 : List Layout

##### Option(선택사항)

- Pagination vs 무한로딩


### 3. Post Card Group Section Layout


### 4. Page Layout

#### 4-1. Blog Posts Index Page

##### 4-1-1. Recent Posts (최신 글 보기)

##### 4-1-2. Magazine Layout

- Category 별로 그룹핑해서 보여준다.

##### 4-1-3. Community Portal Layout

- 게시판별로 게시글 목록을 3개/5개/7개씩 바둑판 of 바둑판으로 보여준다.

#### 4-2. Category Archive Page

#### 4-3. Author Archive Page

#### 4-4. Single Post Page



