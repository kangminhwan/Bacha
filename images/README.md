# 바샤커피 메뉴 이미지 폴더 구조

이 폴더는 바샤커피 메뉴판의 카테고리별 이미지를 저장하는 곳입니다.

## 폴더 구조

### 1. housemade-pastries (홈메이드 페이스트리)
- 수제 페이스트리, 마들렌, 스콘 등의 이미지
- 파일명 예: `madeleine-01.jpg`, `scone-butter.jpg`

### 2. sandwich (샌드위치)
- 각종 샌드위치 메뉴 이미지
- 파일명 예: `club-sandwich.jpg`, `blt-sandwich.jpg`

### 3. ice-desserts (아이스 디저트)
- 아이스크림, 빙수, 냉음료 관련 디저트 이미지
- 파일명 예: `ice-cream-vanilla.jpg`, `shaved-ice.jpg`

### 4. farm-fresh-eggs (농장 신선 달걀)
- 달걀 요리, 오믈렛, 에그 베네딕트 등의 이미지
- 파일명 예: `eggs-benedict.jpg`, `omelet.jpg`

### 5. main (메인 요리)
- 주요 식사 메뉴, 파스타, 라이스 등의 이미지
- 파일명 예: `pasta-carbonara.jpg`, `risotto.jpg`

### 6. croissants-and-cakes (크루아상과 케이크)
- 크루아상, 케이크, 타르트 등의 이미지
- 파일명 예: `croissant-plain.jpg`, `chocolate-cake.jpg`

### 7. salad (샐러드)
- 각종 샐러드 메뉴 이미지
- 파일명 예: `caesar-salad.jpg`, `quinoa-salad.jpg`

### 8. signature-dessert (시그니처 디저트)
- 바샤커피만의 시그니처 디저트 이미지
- 파일명 예: `signature-chocolate.jpg`, `special-tiramisu.jpg`

## 이미지 파일 규격
- 형식: JPG, PNG
- 권장 크기: 1200x800px 이상
- 비율: 3:2 권장
- 파일명: 소문자, 하이픈(-) 사용, 한글 피하기

## 사용법
test.html 파일에서 Unsplash URL 대신 로컬 이미지 경로로 변경:
```javascript
image: "./images/housemade-pastries/madeleine-01.jpg"
```