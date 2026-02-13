# Structure et Architecture du Projet FreelanceFlow

Ce document détaille l'organisation exhaustive des fichiers et le modèle architectural MVC utilisé dans le projet.

## 🏗️ Architecture MVC (Modèle-Vue-Contrôleur)

### Modèles (`app/models/`)
Gèrent la persistance des données et les interactions SQL.
- **`Database.php`** : Connexion PDO (Singleton).
- **`User.php`** : Modèle de données utilisateur de base.
- **`UsersModel.php`** : Logique avancée de gestion des comptes.
- **`tasks.php`** : Gestion du cycle de vie des missions (CRUD).
- **`applications.php`** : Gestion des candidatures.
- **`payments.php`** : Suivi des transactions.
- **`reviews.php`** : Système de notation.

### Contrôleurs (`app/controllers/`)
Orchestrent la logique métier et font le lien entre modèles et vues.
- **`UserController.php`** : Authentification et gestion des sessions.
- **`TaskController.php`** : Affichage et gestion des missions.
- **`ApplicationController.php`** : Processus de candidature complet.
- **`AdminController.php`** : Outils de modération et gestion globale.
- **`WelcomeController.php`** : Gestion des pages publiques (Landing).

### Vues & Assets (`public/`)
Interface utilisateur et ressources statiques.
- **`dashboard_page/`** : Espaces personnels cloisonnés par rôle.
- **`tasks_page/`** : `tasks_list.php` (Explorer) et `tasks_detail.php`.
- **`auth_page/`** : `login.php` et `register.php`.
- **`assets/css/`** : `dashboard.css` (Premium UI), `login.css` (Glassmorphism), `global.css`.
- **`assets/js/`** : `script.js` (Logique de la sidebar et interactions).

## 🧭 Systèmes de Navigation (`includes/`)
Composants réutilisables inclus dynamiquement.
- **Headers** : `header_freelance.php`, `header_client.php`, `header_admin.php`.
- **Sidebars** : `sidebar_freelance.php`, `sidebar_client.php`, `sidebar_admin.php`.
- **Mécanisme** : La sidebar est **100% rétractable (0px)** via `script.js`.

## 💾 Base de Données (`sql/`)
- **`schemas.sql`** : Script de création des tables (users, tasks, applications, etc.).

## 🚀 Point d'Entrée Unique (`public/index.php`)
Le routeur central qui traite toutes les requêtes via `?page=...`.
- Sécurisation des accès par rôle.
- Gestion des alertes et sessions.
- Routage dynamique vers les contrôleurs.
