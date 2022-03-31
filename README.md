# Salon de Ahn

## 작품 소개

**salon**

1. (미용실·고급 의상실 같은) 상점

2. (대저택의) 응접실

3. 살롱(과거 상류 가정 응접실에서 흔히 열리던 작가, 예술가들을 포함한 사교 모임)

여기서 3번의 의미를 가져와서 제목을 지었습니다.

저의 개인적 관심사(IT 개발, 금융, 언어 학습) 및 일상에 대한 개인적인 기록을 남김과 동시에

웹사이트에 방문하신 일반 사용자 분들도 각자 원하는 분야에 기록을 남기며 서로 이야기를 나눌 수 있는 공간이 존재하는 개인 블로그+커뮤니티형 웹사이트입니다.

## 주요 기능 (이미지 클릭 시 시연 영상으로 이동)

[![Salon de Ahn - 작품 소개, HTTPS, AWS 사용, 회원 관련 기능](https://user-images.githubusercontent.com/73585246/161051549-38690971-bfcd-4a3f-a8f5-18a92d0c44dd.PNG)](https://youtu.be/sADWNA3sC8g)

### 0. 도메인 연결, HTTPS 적용, AWS EC2 & S3 사용 (-> Free Tier 만료로 인해 Heroku로 이동)

- 도메인 : salondeahn.me (-> salondeahn.herokuapp.com)
- HTTPS : AWS EC2를 이용한 가상머신(인스턴스) 내에 HTTPS 인증서 설치
- AWS S3를 이용한 게시판 첨부파일 및 갤러리 이미지 저장 및 관리

### 1. 회원가입, 로그인/로그아웃, 회원 정보 수정, 비밀번호 찾기

1-1. 회원가입(JQuery 사용)

- 입력칸(이메일, 비밀번호, 비밀번호 확인, 약관 동의 체크박스 2개) 입력 여부 확인
- 이메일 형식 검증
- 이메일 중복 확인
- 비밀번호 일치 여부 확인

1-2. 로그인/로그아웃

- 쿠키 사용 -> 이메일(아이디) 저장하기

1-3. 회원 정보 수정

- 닉네임 수정
- 비밀번호 수정

1-4. 비밀번호 찾기

- PHPMailer -> Gmail SMTP 사용하여 가입된 이메일로 임시 비밀번호 발송

1-5. 마이페이지 '내가 쓴 게시물', '내가 쓴 댓글' 보기

[![Salon de Ahn - 개인 기록(IT개발 포트폴리오, 금융 거래 기록, 언어 학습 기록)](https://user-images.githubusercontent.com/73585246/161051549-38690971-bfcd-4a3f-a8f5-18a92d0c44dd.PNG)](https://youtu.be/d8MTVkS1BHE)

[![Salon de Ahn - 게시판(게시물 작성, 수정, 삭제, 댓글 작성, 수정, 삭제](https://user-images.githubusercontent.com/73585246/161051549-38690971-bfcd-4a3f-a8f5-18a92d0c44dd.PNG)](https://youtu.be/yTkspLIcsIw)

### 2. 게시판

2-1. 게시물 및 답글 작성, 수정, 삭제 & 첨부파일 추가, 수정, 삭제

(1) 게시판 분류에 따른 게시물의 소분류 동적 변화

2-2. 댓글 및 대댓글 작성, 수정, 삭제

2-3. 비밀글 기능 (작성자 및 관리자 외 조회 불가)

2-4. 일반 사용자의 관리자 전용 게시판 접근 제한

(관리자 전용 게시물 작성, 수정, 삭제 기능 숨기기. URL 알고 직접 주소창 입력 시에도 막음)

2-5. 게시물 페이징 기능

2-6. 쿠키를 이용한 조회수 조작 방지(24시간 이내에는 동일 게시물 다시 조회해도 조회수 변동 없음)

[![Project Salon de Ahn](https://user-images.githubusercontent.com/73585246/161051610-d06d222a-0d5d-4f96-bce0-5d89d58794c7.jpg)](https://youtu.be/h9Nmjbjv-Go)


### 3. 채팅

- PHP Ratchet 활용한 웹소켓 채팅 구현

### 4. 갤러리

- 앨범 추가(1개 혹은 여러 개 한번에), 수정, 삭제 & 사진 추가(1장씩 혹은 여러 장 한번에), 수정, 삭제 기능

- 앨범 및 앨범 내 사진 페이징 기능(사진첩 더보기, 사진 더보기)

- masonry 레이아웃 Left-to-Right 정렬(좌측 상단 사진이 1번, 좌측 상단 2번째가 2번, ...) 및 브라우저 크기에 따른 이미지 크기 및 간격 재조절 기능(반응형)
