<div align="center">

# 🏫 SGEP - School Management System

**A modern, full-stack management system built with Laravel and React.**

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![React](https://img.shields.io/badge/React-20232A?style=for-the-badge&logo=react&logoColor=61DAFB)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

</div>

## 📖 About The Project

**SGEP** (Système de Gestion) is a comprehensive web application designed to streamline administrative and management tasks. Built with a robust **Laravel** backend and a dynamic **React** frontend, it provides a seamless and responsive user experience. 

This project demonstrates clean architecture, RESTful API design, and modern state management.

### ✨ Key Features

- **Dashboard Analytics:** Visual overviews of key metrics and statistics.
- **User Roles & Permissions:** Secure, role-based access control (RBAC).
- **CRUD Operations:** Full management capabilities for primary entities (students, staff, courses, etc.).
- **Responsive UI:** Fully mobile-friendly interface built with Tailwind CSS.
- **REST API:** A well-structured, secure API serving the frontend.

## 🛠️ Tech Stack

- **Backend:** Laravel 10+, PHP 8.1+
- **Frontend:** React.js, Tailwind CSS
- **Database:** MySQL
- **Authentication:** Laravel Sanctum / Passport

## 🚀 Getting Started

Follow these steps to set up the project locally.

### Prerequisites

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/zinnewassim/sgep.git
   cd sgep
   ```

2. **Backend Setup:**
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```
   *Configure your `.env` file with your database credentials.*

3. **Run Migrations & Seeders:**
   ```bash
   php artisan migrate --seed
   ```

4. **Frontend Setup:**
   ```bash
   npm install
   npm run build
   ```

5. **Start Development Server:**
   ```bash
   php artisan serve
   ```

## 👨‍💻 Author

**Wassim Azinne**
- GitHub: [@zinnewassim](https://github.com/zinnewassim)
- Email: [zinne123wassim@gmail.com](mailto:zinne123wassim@gmail.com)

---

⭐️ *If you find this project useful, please consider giving it a star!*
