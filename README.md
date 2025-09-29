# 🍰 바샤커피 메뉴 관리 시스템

GitHub Pages + 자동화로 txt 파일 수정만으로 웹사이트가 업데이트됩니다!

## 🚀 사용법

### 1️⃣ 메뉴 추가/수정
```
menu.txt 파일을 수정하세요
형식: 카테고리|이름|설명|가격|이미지파일명|태그(옵션)
```

### 2️⃣ 자동 업데이트
- menu.txt 파일을 GitHub에 push하면
- 자동으로 index.html이 생성되고
- GitHub Pages에 반영됩니다

### 3️⃣ GitHub Pages 설정
1. GitHub 저장소 설정 → Pages
2. Source: "GitHub Actions" 선택
3. Custom domain 설정 (선택사항)

## 📁 폴더 구조
```
C:\Bacha\Bacha\
├── menu.txt                    # 메뉴 관리 파일
├── index.html                  # 자동 생성되는 웹페이지
├── .github/workflows/          # 자동화 설정
│   └── update-menu.yml
├── housemade-pastries/         # 이미지 폴더들
├── sandwich/
├── ice-desserts/
├── farm-fresh-eggs/
├── main/
├── croissants-and-cakes/
├── salad/
└── signature-dessert/
```

## ✨ 기능
- 📱 반응형 디자인
- 🌓 다크/라이트 테마 자동 전환
- 🔍 실시간 검색
- 🏷️ 카테고리 필터링
- 📊 메뉴 통계
- 🖼️ 이미지 지연 로딩
- ⚡ 빠른 로딩 속도

## 🛠️ 메뉴 수정 예시

### 새 메뉴 추가
```
Croissants and Cakes|딸기 케이크|신선한 딸기와 크림|15000|croissants-and-cakes/strawberry-cake.jpg|케이크,딸기
```

### 가격 수정
```
Ice Desserts|바닐라 젤라토|진짜 바닐라 빈으로 만든 프리미엄 젤라토|9500|ice-desserts/gelato-vanilla.jpg|젤라토,바닐라
```

## 🔄 자동화 프로세스
1. menu.txt 변경 감지
2. Node.js로 HTML 생성
3. 자동 커밋 및 푸시
4. GitHub Pages 배포

**📧 문의사항이나 오류 발생시 이슈를 등록해주세요!**