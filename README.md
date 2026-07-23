# 📓 Slice Of Life

A personal notes app built with PHP, MySQL, vanilla CSS, and Bootstrap. Built as part of a 15-day web development training program.

## Features

- 🔐 User registration and login with session-based authentication
- 📝 Create, edit, and delete notes
- 🏷️ Custom tags — comes with **Personal** and **Work** pre-loaded, create your own
- 🔍 Filter notes by tag
- 💾 Notes saved in MySQL database + synced to browser localStorage
- 🚪 Stays logged in until you click Logout

## Tech Stack

| Layer | Technology |
|---|---|
| Frontend | HTML, CSS, JavaScript |
| Backend | PHP |
| Database | MySQL |
| Server | Apache (XAMPP) |
| Styling | Custom CSS + Google Fonts (Poppins) |

## Project Structure

```
Slice Of Life/
├── index.html          # Redirects to login
├── login.php           # Login page
├── register.php        # Registration page
├── notes.php           # Main app (protected)
├── logout.php          # Session destroy + redirect
├── checkLogin.php      # Login logic
├── checkRegister.php   # Registration logic
├── checkNotes.php      # Add / edit / delete notes + tag logic
├── db_connect.php      # Database connection (not in repo)
├── header.php          # Shared HTML head
├── footer.php          # Shared closing tags
├── style.css           # All styles
├── script.js           # Modal controls + localStorage sync
└── images/             # Icons used in the UI
```

## Local Setup

### 1. Requirements
- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL)

### 2. Clone the repo
```bash
git clone https://github.com/choudharyms/slice-of-life.git
```
Place the folder inside `xampp/htdocs/`

### 3. Create the database

Open `http://localhost/phpmyadmin` → create a database named `slice_of_life` → run this SQL:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    tag_id INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    UNIQUE KEY unique_user_tag (user_id, name),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

ALTER TABLE notes ADD CONSTRAINT fk_note_tag
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE SET NULL;
```

### 4. Create `db_connect.php`

Create this file in the project root (it is excluded from git):

```php
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "slice_of_life";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
```

### 5. Open the app

```
http://localhost/Slice Of Life/
```

## Screenshots

> Register → Login → Write notes → Tag them → Filter by tag → Edit or delete anytime

## License

Built for learning purposes during a 15-day web development training.
