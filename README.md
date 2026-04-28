<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-003B57?style=flat-square&logo=sqlite&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=flat-square&logo=bootstrap&logoColor=white)

# SGEP — Système de Gestion des Employés et du Personnel

**A complete HR management system with RBAC, automated matricule generation, and absence tracking.**

</div>

---

## Overview

SGEP is a production-grade **HR Management System** built with Laravel 12. It handles 23 database tables and includes a custom Eloquent Observer that auto-generates sequential employee matricules.

## Features

- 👥 **Employee Management** — Full CRUD with department and position assignment
- 🔐 **RBAC** — Admin, Manager, HR roles via Laratrust middleware
- 📅 **Absence Tracking** — Record, approve, and report absences
- 🪪 **Auto-Matricule Generation** — Eloquent Observer auto-increments formatted IDs
- 📆 **FullCalendar Integration** — Visual absence planning
- 🌙 **Dark Mode** — Bootstrap 5 dark/light toggle

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 12 |
| Database | SQLite (23 tables) |
| Frontend | Bootstrap 5 + Blade |
| RBAC | Laratrust |

## Installation

```bash
git clone https://github.com/zinnewassim/sgep.git && cd sgep
composer install && npm install && npm run build
cp .env.example .env && php artisan key:generate
php artisan migrate --seed && php artisan serve
```

---
**Author:** [Wassim Azinne](https://github.com/zinnewassim)
