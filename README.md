# SpeedType – Typing Speed Test Web Application

SpeedType is a web-based typing speed test platform that allows users to measure and improve their typing performance.  
The system combines Firebase Authentication for secure Google login with a PHP–MySQL backend that manages user accounts, gameplay data, and user feedback.

---

## Overview

SpeedType provides an interactive typing test experience where users can practice, track their progress, and compete through a leaderboard.  
All results and reviews are stored in a relational database, while Google Authentication is handled via Firebase.

---

## Features

- Real-time typing speed and accuracy calculation  
- Google Sign-In integration through Firebase Authentication  
- Traditional registration and login system with password reset  
- Secure user data storage in MySQL  
- Persistent game results, including WPM and accuracy  
- Leaderboard displaying top player performances  
- Profile management with personal statistics  
- User feedback and comments section with reactions  
- Modular PHP components for header, footer, and database connectivity  

---

## Technologies Used

| Category | Technology |
|-----------|-------------|
| Frontend | HTML5, CSS3, JavaScript (ES6) |
| Styling | Custom CSS (Alkhamis.css, Khaled.css) |
| Backend | PHP 8 |
| Database | MySQL |
| Authentication | Firebase Authentication (Google Sign-In) |
| Hosting / Local Development | XAMPP |
| Version Control | Git & GitHub |

---

## System Architecture

**Frontend (Client-Side)**  
- Dynamic gameplay handled by `script.js`  
- Review and feedback interactivity managed by `Review.js`  
- Responsive interface styled with modular CSS files  

**Backend (Server-Side)**  
- PHP scripts handle requests for:  
  - Game result saving (`save_game.php`)  
  - Review and comment submission (`submit_review.php`)  
  - Reaction management (`handle_reaction.php`)  
  - User authentication and session management (`login.php`, `register.php`, `logout.php`, `reset-password.php`)  
- Centralized database connection in `database.php`  
- Shared page components: `header.php` and `footer.php`  

**Database**  
- `users.sql` defines user credentials and profile information  
- `games.sql` stores gameplay metrics (WPM, accuracy, duration)  
- `review_reactions.sql` stores comments, feedback, and reactions  

**Authentication**  
- Firebase used for Google Sign-In via the Firebase JavaScript SDK  
- PHP sessions maintain logged-in state after authentication  
- Hybrid login support (Firebase + local MySQL accounts)

---

## Folder Structure

```bash
SpeedType/
│
├── index.php
├── login.php
├── register.php
├── logout.php
├── Profile.php
├── Leaderboard.php
├── about.php
├── reset-password.php
├── security-questions.php
│
├── save_game.php
├── submit_review.php
├── handle_reaction.php
│
├── header.php
├── footer.php
├── database.php
│
├── CSS/
│   ├── Alkhamis.css
│   └── Khaled.css
│
├── JS/
│   ├── script.js
│   └── Review.js
│
├── games.sql
├── users.sql
├── review_reactions.sql
└── README.md
```

---

## Database Schema (Summary)

### `users`
| Column | Type | Description |
|---------|------|-------------|
| id | INT | Primary key |
| name | VARCHAR | User display name |
| email | VARCHAR | User email |
| password | VARCHAR | Hashed password (for non-Google users) |
| google_uid | VARCHAR | Firebase UID for Google accounts |

### `games`
| Column | Type | Description |
|---------|------|-------------|
| id | INT | Primary key |
| user_id | INT | Foreign key to users table |
| wpm | INT | Words per minute |
| accuracy | FLOAT | Accuracy percentage |
| time_played | DATETIME | Game timestamp |

### `review_reactions`
| Column | Type | Description |
|---------|------|-------------|
| id | INT | Primary key |
| user_id | INT | Foreign key to users table |
| comment | TEXT | User feedback text |
| reaction_type | ENUM | e.g. 'like', 'dislike' |
| created_at | DATETIME | Timestamp of submission |

---

## Installation and Setup

### 1. Local Environment
Install and start **XAMPP** (Apache + MySQL).

Place the `SpeedType` folder in:
```
C:\xampp\htdocs\SpeedType\
```

Start Apache and MySQL from the XAMPP Control Panel.

### 2. Database Setup
1. Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Create a new database (for example, `speedtype`).
3. Import the following SQL files in order:
   - `users.sql`
   - `games.sql`
   - `review_reactions.sql`

### 3. Firebase Configuration
1. Create a new project in [Firebase Console](https://console.firebase.google.com/).
2. Enable **Google Authentication** under “Authentication → Sign-in method”.
3. Copy your Firebase configuration and add it to your JavaScript file:
   ```js
   const firebaseConfig = {
     apiKey: "YOUR_API_KEY",
     authDomain: "YOUR_PROJECT_ID.firebaseapp.com",
     projectId: "YOUR_PROJECT_ID",
     storageBucket: "YOUR_PROJECT_ID.appspot.com",
     messagingSenderId: "YOUR_SENDER_ID",
     appId: "YOUR_APP_ID"
   };
   firebase.initializeApp(firebaseConfig);
   ```
4. Ensure the `google_login_handler.php` script processes the Firebase token or UID correctly.

### 4. Access the Application
After setup, open your browser and navigate to:
```
http://localhost/SpeedType/
```

---

## Key Pages

| Page | Description |
|------|-------------|
| **index.php** | Main typing test interface |
| **Leaderboard.php** | Displays top scores and performance rankings |
| **Profile.php** | Shows user statistics and history |
| **login.php / register.php** | Authentication system for local accounts |
| **about.php** | Project information page |
| **Feedback (via Review.js)** | Allows users to leave feedback and comments |

---

## Security and Data Handling

- Passwords are hashed before storage.  
- Firebase tokens are verified on the client side for Google sign-in.  
- Database queries use prepared statements to prevent SQL injection.  
- Sessions and cookies are securely managed to maintain user login state.  

---

## ScreenShots

<img width="1919" height="954" alt="image" src="https://github.com/user-attachments/assets/c8d99b45-c66c-43c6-9d34-7474a947314e" />
<img width="1919" height="938" alt="image" src="https://github.com/user-attachments/assets/0e466229-7893-4b83-bd41-f5f99371f8ae" />
<img width="1908" height="957" alt="image" src="https://github.com/user-attachments/assets/e57a4e7a-39a3-4df6-86df-7cd10cde24be" />
<img width="1919" height="952" alt="image" src="https://github.com/user-attachments/assets/67da5d8d-0241-49e7-876d-7c5ca60bfcc0" />
<img width="1911" height="940" alt="image" src="https://github.com/user-attachments/assets/21ee204c-0f0d-48f7-b014-13b94dc52234" />
<img width="1919" height="938" alt="image" src="https://github.com/user-attachments/assets/1349adfc-4462-43f0-acd7-671504099439" />
<img width="1916" height="942" alt="image" src="https://github.com/user-attachments/assets/91c34e48-db14-452d-873c-0b63b460a75a" />
<img width="1898" height="937" alt="image" src="https://github.com/user-attachments/assets/afab82f5-f99b-4a40-9d12-ead22fc46e70" />
<img width="1904" height="885" alt="image" src="https://github.com/user-attachments/assets/eb1fbfaa-42a7-426b-b95d-0e63bd67550e" />



