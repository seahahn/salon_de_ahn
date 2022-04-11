# :sparkle: Salon de Ahn

## 1️⃣ 작품 소개

### **salon**

1. (미용실·고급 의상실 같은) 상점

2. (대저택의) 응접실

3. 살롱(과거 상류 가정 응접실에서 흔히 열리던 작가, 예술가들을 포함한 사교 모임)

여기서 3번의 의미를 가져와서 제목을 지었습니다.

저의 개인적 관심사(IT 개발, 금융, 언어 학습) 및 일상에 대한 개인적인 기록을 남김과 동시에

웹사이트에 방문하신 일반 사용자 분들도 각자 원하는 분야에 기록을 남기며 서로 이야기를 나눌 수 있는 공간이 존재하는 개인 블로그+커뮤니티형 웹사이트입니다.

:house: https://www.salondeahn.me

<br/>

## 2️⃣ 제작 기간 & 참여 인원
- 2020.11.11 - 2021.01.04
- 개인 프로젝트

<br/>

## 3️⃣ 사용 기술

| Frontend | Backend | Database | DevOps |
| --- | --- | --- | --- |
| ● HTML/CSS/JS<br/> ● jQuery 3.5.1<br/> ● Bootstrap 4.3.1 | ● PHP 7.4.0<br/> ● Apache 2.4.41 | ● MariaDB 10.5.7 | ● AWS (EC2, S3, Route 53) |

<br/>

## 4️⃣ 주요 기능

### 1. HTTPS 적용, AWS 사용, 회원 관련 기능

- 시연 영상 : https://youtu.be/LdlCZwUjQzM

#### 1) 도메인 연결, HTTPS 적용, AWS EC2 & S3 사용

<blockquote>
  
● 도메인 : salondeahn.me  
● HTTPS : AWS EC2를 이용한 가상머신(인스턴스) 내에 HTTPS 인증서 설치  
● AWS S3를 이용한 게시판 첨부파일 및 갤러리 이미지 저장 및 관리
  
</blockquote>

#### 2) 회원가입, 로그인/로그아웃, 회원 정보 수정, 비밀번호 찾기

<blockquote>
<details>
  <summary>회원가입(jQuery 사용)</summary><br/>
  
  ![image](https://user-images.githubusercontent.com/73585246/162207664-f446c4ea-d890-48cd-80f4-9ad46aa8c7da.png)

  - 입력칸(이메일, 비밀번호, 비밀번호 확인, 약관 동의 체크박스 2개) 입력 여부 확인
  - 이메일 형식 검증
  - 이메일 중복 확인
  - 비밀번호 일치 여부 확인
</details>
<details>
  <summary>로그인/로그아웃</summary><br/>
  
  ![image](https://user-images.githubusercontent.com/73585246/162207834-98fff7c8-30b2-4397-8466-67fbe73dd592.png)

  - 쿠키 사용 -> 이메일(아이디) 저장하기
</details>
<details>
  <summary>회원 정보 수정</summary><br/>
  
  ![image](https://user-images.githubusercontent.com/73585246/162208050-20c3e79f-421d-440e-ad40-b261e02ab572.png)

  - 닉네임 수정
  - 비밀번호 수정
</details>
<details>
  <summary>비밀번호 찾기</summary><br/>
  
  ![image](https://user-images.githubusercontent.com/73585246/162208198-6da6515e-7581-4871-80fd-28cbbf297d5e.png)
  ![image](https://user-images.githubusercontent.com/73585246/162208544-619556bb-edc8-471a-8624-4c1ec0188d97.png)

  - PHPMailer -> Gmail SMTP 사용하여 가입된 이메일로 임시 비밀번호 발송
</details>
<details>
  <summary>마이페이지 '내가 쓴 게시물', '내가 쓴 댓글' 보기</summary><br/>
  
  ![image](https://user-images.githubusercontent.com/73585246/162208643-cf546563-3c45-4758-89cf-3ca7df5276cb.png)
  ![image](https://user-images.githubusercontent.com/73585246/162208707-a37376c0-3a06-44d5-a98e-4bce44a02942.png)

</details>
</blockquote>
---

### 2. 게시판

- 시연 영상(IT개발 포트폴리오, 금융 거래 기록, 언어 학습 기록) : https://youtu.be/ILUoVP0a5aw
- 시연 영상(게시판 게시물 작성, 수정, 삭제, 댓글 작성, 수정, 삭제) : https://youtu.be/Bp66xztm_1g

#### 1) 게시물 및 답글 작성, 수정, 삭제 & 첨부파일 추가, 수정, 삭제

<blockquote>
<details>
  <summary>게시물 작성 & 첨부파일 추가</summary><br/>
  
  ![image](https://user-images.githubusercontent.com/73585246/162209648-17778638-60d6-46d1-b9ec-c08d701873d1.png)
</details>
</blockquote>

#### 2) 댓글 및 대댓글 작성, 수정, 삭제

<blockquote>
<details>
  <summary>댓글 및 대댓글 작성, 수정</summary><br/>
  
  ![image](https://user-images.githubusercontent.com/73585246/162210981-09578384-7401-410c-b74e-8bd9343e2769.png)
  ![image](https://user-images.githubusercontent.com/73585246/162211852-b4273f48-c527-4dfb-90ce-60bd151f03c9.png)
</details>
</blockquote>

#### 3) 비밀글 기능 (작성자 및 관리자 외 조회 불가)

#### 4) 일반 사용자의 관리자 전용 게시판 접근 제한

  - 관리자 전용 게시물 작성, 수정, 삭제 기능 숨기기(URL 알고 직접 주소창 입력 시에도 막음)

#### 5) 게시물 페이징 기능

#### 6) 쿠키를 이용한 조회수 조작 방지(24시간 이내에는 동일 게시물 다시 조회해도 조회수 변동 없음)
  
  
  
---

### 3. 채팅 & 갤러리

- 시연 영상 : https://youtu.be/_MvM6lF1tec

#### 1) PHP Ratchet 활용한 웹소켓 채팅 구현

<blockquote>
<details>
  <summary>채팅 화면</summary><br/>
  
  ![image](https://user-images.githubusercontent.com/73585246/162217818-15d4d753-4a39-4f9b-a478-7c86c6d49ca3.png)
</details>
</blockquote>


#### 2) 갤러리

<blockquote>
<details>
  <summary>앨범 추가(1개 혹은 여러 개 한번에), 수정, 삭제 기능</summary><br/>
  
  ![image](https://user-images.githubusercontent.com/73585246/162220234-c807b63a-23e8-4813-8057-f4875a42c6a7.png)
</details>
<details>
  <summary>사진 추가(1장씩 혹은 여러 장 한번에), 수정, 삭제 기능</summary><br/>
  
  ![image](https://user-images.githubusercontent.com/73585246/162220126-c8b507f5-da3d-4263-8b0d-8196fda5e60f.png)
</details>
<details>
  <summary>앨범 및 앨범 내 사진 페이징 기능(사진첩 더보기, 사진 더보기)</summary><br/>
  
  ![image](https://user-images.githubusercontent.com/73585246/162220629-c2cbcece-93ab-4f59-9c63-64e47f51a7ac.png)
</details>

● masonry 레이아웃 Left-to-Right 정렬(좌측 상단 사진이 1번, 좌측 상단 2번째가 2번, ...)  

● 브라우저 크기에 따른 이미지 크기 및 간격 재조절 기능(반응형)
</blockquote>
