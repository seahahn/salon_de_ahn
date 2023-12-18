# :sparkle: Salon de Ahn

## 1️⃣ Project Introduction

### **salon**

1. (Shop such as a beauty salon or a high-end dressing room) Shop

2. (Reception room in a mansion) Parlor

3. Salon (social gathering, including artists and writers, held in the drawing room of a home in the past upper class)

The title is derived from the third meaning above.

This is a personal blog + community website where I record my personal interests (IT development, finance, language learning) and daily life.
Visitors to the website, including general users, can leave records in their respective fields and share stories with each other.

:house: ~~https://www.salondeahn.me~~ -> Because of the server cost, it is temporarily closed

<br/>

## 2️⃣ Project Duration & Participants

- 11 Nov 2020 - 4 Jan 2021
- Individual project

<br/>

## 3️⃣ Technologies Used

| Frontend                                                 | Backend                          | Database         | DevOps                    |
| -------------------------------------------------------- | -------------------------------- | ---------------- | ------------------------- |
| ● HTML/CSS/JS<br/> ● jQuery 3.5.1<br/> ● Bootstrap 4.3.1 | ● PHP 7.4.0<br/> ● Apache 2.4.41 | ● MariaDB 10.5.7 | ● AWS (EC2, S3, Route 53) |

<br/>

## 4️⃣ Key Features

### 1. HTTPS Implementation, AWS Usage, Membership-related Features

- Demo Video: [https://youtu.be/LdlCZwUjQzM](https://youtu.be/LdlCZwUjQzM)

#### 1) Domain Connection, HTTPS Implementation, AWS EC2 & S3 Usage

<blockquote>

● Domain: ~~salondeahn.me~~ (cause)
● HTTPS: Installation of an HTTPS certificate within a virtual machine (instance) using AWS EC2
● Using AWS S3 to store and manage board attachments and gallery images

</blockquote>

#### 2) Sign Up, Log In/Log Out, Modify Member Information, Password Recovery

<blockquote>
<details>
  <summary>Sign Up (using jQuery)</summary><br/>

![image](https://user-images.githubusercontent.com/73585246/162207664-f446c4ea-d890-48cd-80f4-9ad46aa8c7da.png)

- Check for input in fields (email, password, password confirmation, agreement checkboxes)
- Validate email format
- Check for duplicate emails
- Confirm password match
</details>
<details>
  <summary>Log In/Log Out</summary><br/>

![image](https://user-images.githubusercontent.com/73585246/162207834-98fff7c8-30b2-4397-8466-67fbe73dd592.png)

- Use of cookies -> Remember email (ID)
</details>
<details>
  <summary>Modify Member Information</summary><br/>

![image](https://user-images.githubusercontent.com/73585246/162208050-20c3e79f-421d-440e-ad40-b261e02ab572.png)

- Modify nickname
- Modify password
</details>
<details>
  <summary>Password Recovery</summary><br/>

![image](https://user-images.githubusercontent.com/73585246/162208198-6da6515e-7581-4871-80fd-28cbbf297d5e.png)
![image](https://user-images.githubusercontent.com/73585246/162208544-619556bb-edc8-471a-8624-4c1ec0188d97.png)

- Use PHPMailer -> Send temporary password to the registered email using Gmail SMTP
</details>
<details>
  <summary>My Page - View 'My Posts' and 'My Comments'</summary><br/>

![image](https://user-images.githubusercontent.com/73585246/162208643-cf546563-3c45-4758-89cf-3ca7df5276cb.png)
![image](https://user-images.githubusercontent.com/73585246/162208707-a37376c0-3a06-44d5-a98e-4bce44a02942.png)

</details>
</blockquote>
---

### 2. Board

- Demo Video (IT Development Portfolio, Financial Transaction Records, Language Learning Records): [https://youtu.be/ILUoVP0a5aw](https://youtu.be/ILUoVP0a5aw)
- Demo Video (Write, Modify, Delete Posts, Write, Modify, Delete Comments): [https://youtu.be/Bp66xztm_1g](https://youtu.be/Bp66xztm_1g)

#### 1) Write, Modify, Delete Posts & Attach, Modify, Delete Files

<blockquote>
<details>
  <summary>Write Posts & Attach Files</summary><br/>

![image](https://user-images.githubusercontent.com/73585246/162209648-17778638-60d6-46d1-b9ec-c08d701873d1.png)

</details>
</blockquote>

#### 2) Write, Modify, Delete Comments

<blockquote>
<details>
  <summary>Write, Modify Comments</summary><br/>

![image](https://user-images.githubusercontent.com/73585246/162210981-09578384-7401-410c-b74e-8bd9343e2769.png)
![image](https://user-images.githubusercontent.com/73585246/162211852-b4273f48-c527-4dfb-90ce-60bd151f03c9.png)

</details>
</blockquote>

#### 3) Private Post Feature (Inaccessible to anyone other than the author and administrators)

md
Copy code

#### 3) Private Post Feature (Inaccessible to anyone other than the author and administrators)

#### 4) Restriction on General Users' Access to the Administrator-Only Board

- Hide functions for writing, modifying, and deleting administrator-only posts (preventing access even when entering the URL directly into the address bar)

#### 5) Post Pagination Feature

#### 6) Prevention of View Count Manipulation Using Cookies (No change in view count if the same post is viewed again within 24 hours)

---

### 3. Chatting & Gallery

- Demo Video: [Chatting & Gallery Demo](https://youtu.be/_MvM6lF1tec)

#### 1) Implementation of Websocket Chat using PHP Ratchet

<blockquote>
<details>
  <summary>Chat Screen</summary><br/>

![image](https://user-images.githubusercontent.com/73585246/162217818-15d4d753-4a39-4f9b-a478-7c86c6d49ca3.png)

</details>
</blockquote>

#### 2) Gallery

<blockquote>
<details>
  <summary>Album Addition (1 or multiple at once), Modification, Deletion Features</summary><br/>

![image](https://user-images.githubusercontent.com/73585246/162220234-c807b63a-23e8-4813-8057-f4875a42c6a7.png)

</details>
<details>
  <summary>Photo Addition (1 at a time or multiple at once), Modification, Deletion Features</summary><br/>

![image](https://user-images.githubusercontent.com/73585246/162220126-c8b507f5-da3d-4263-8b0d-8196fda5e60f.png)

</details>
<details>
  <summary>Album and Photo Pagination Features (Show more photos in the album, Show more photos)</summary><br/>

![image](https://user-images.githubusercontent.com/73585246/162220629-c2cbcece-93ab-4f59-9c63-64e47f51a7ac.png)

</details>

● Masonry layout for Left-to-Right alignment (the top-left photo is 1, the second from the top-left is 2, ...)

● Responsive adjustment of image size and spacing according to browser size

</blockquote>
