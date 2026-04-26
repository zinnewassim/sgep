# SGEP - Système de Gestion des Employés et de la Présence

Ce projet est une application Laravel pour la gestion du personnel et le suivi des présences.

## Prérequis

- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Serveur Web (XAMPP, Apache, Nginx)

## Installation

1. **Configuration de l'environnement** :
   Assurez-vous que votre fichier `.env` est correctement configuré avec vos accès à la base de données.

2. **Installation des dépendances** :
   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Génération de la clé d'application** :
   ```bash
   php artisan key:generate
   ```

4. **Migration et Seeding** (Important pour les nouveaux modèles et données) :
   ```bash
   php artisan migrate:fresh --seed
   ```

## Comptes de test

- **Administrateur** :
  - Login : `admin@sgep.ma`
  - Mot de passe : `password`
- **Employé** :
  - Login : `employe@sgep.ma`
  - Mot de passe : `password`

## Fonctionnalités incluses

- Gestion des départements et des postes
- Gestion complète des employés (CRUD)
- Suivi des présences et des retards
- Gestion des absences et congés
- Tableau de bord avec statistiques en temps réel
- Interface entièrement en français avec Bootstrap 5
