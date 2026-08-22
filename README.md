# BodyFix Pro Web Application

## Overview
BodyFix Pro is a PHP and MySQL based web application designed for tracking muscle pain and physical injuries. Developed as a term final project for the Web Design and Programming course, the platform features an interactive body map allowing users to log pain symptoms, view medical rehabilitation guidance, and manage user profiles.

## Features
- Interactive image map interface for selecting body parts and muscle groups.
- User registration and authentication system using PHP sessions.
- Relational database integration using MySQL with Prepared Statements to prevent SQL injection.
- User profile dashboard displaying saved injury records and search history.
- Dynamic detail pages embedding video instructions for physical rehabilitation exercises.
- Object-Oriented Programming (OOP) database wrapper for clean data handling.

## Technologies
- PHP 7.4+ / 8.x
- MySQL / MariaDB
- HTML5 & CSS3
- JavaScript (DOM manipulation)
- Bootstrap Framework

## Project Structure
`
BodyFix-Pro-Web/
├── src/
│   ├── giris.php
│   ├── kayit.php
│   ├── vucud.php
│   ├── detay.php
│   ├── profil.php
│   ├── arama.php
│   ├── hakkimizda.php
│   ├── menu.php
│   ├── sidebar.php
│   ├── cikis.php
│   └── Dosyalar/
│       ├── baglanti.php
│       └── test.php
├── assets/
│   └── images/
│       └── kaslar.jpg
├── database/
│   ├── TabloOlustur.sql
│   ├── Ekleme.sql
│   └── Ekleme1.sql
├── docs/
│   └── report/
│       ├── BodyFix_PRO_Web_Report.pdf
│       └── REPORT.md
├── .gitignore
└── README.md
`

## Installation
1. Move the src/ files to your web server root directory (e.g., htdocs in XAMPP or /var/www/html in Apache).
2. Import the SQL scripts from database/ into your MySQL database server:
`sql
SOURCE database/TabloOlustur.sql;
SOURCE database/Ekleme.sql;
`
3. Update database credentials in src/Dosyalar/baglanti.php.

## Usage
Navigate to http://localhost/giris.php in a web browser, register a user account, log in, and use the interactive body map to record and track physical injury entries.

## Screenshots
UI screenshots and relational database diagrams are documented in docs/report/REPORT.md.

## Documentation
The official term project report detailing database schemas and security measures is provided in docs/report/REPORT.md.

## Future Improvements
- Transitioning authentication token storage to JSON Web Tokens (JWT).
- Adding RESTful API endpoints for mobile platform integration.

## License
Academic term project repository.
