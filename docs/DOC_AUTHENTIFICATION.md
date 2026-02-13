# Documentation Technique - Module Authentification & Rôles

Ce document détaille le système d'authentification et l'interface premium mise en place pour les accès.

## 🎨 Interface & Design Premium

### Page de Connexion (`public/auth_page/login.php`)
- **Thème Indigo-Slate** : Utilisation d'une palette moderne (#0f172a, #4f46e5).
- **Split-Screen** : Panneau visuel à gauche avec illustrations 3D et panneau formulaire à droite sur fond clair (`#f8fafc`).
- **Typographie** : HK Grotesk (Titres) et Inter (Corps) pour un rendu SaaS haut de gamme.
- **Micro-interactions** : États survolés dynamiques sur les boutons et champs de saisie.

### Page d'Inscription (`public/auth_page/register.php`)
- **Structure cohérente** : Utilise `landig.css` pour maintenir le design split-screen.
- **Sélecteur de Rôle** : Détermine l'accès futur (Freelance, Client, Admin).

## ⚙️ Logique des Rôles (`UserController.php`)

### Redirection après Connexion
Le système détecte le rôle en session et redirige vers l'espace approprié :
- **Freelance** : `index.php?page=freelance_dashboard`
- **Client** : `index.php?page=client_dashboard`
- **Admin** : `index.php?page=admin`

## 🛡️ Sécurité
- **Vérification de Session** : Chaque tableau de bord vérifie l'existence de `$_SESSION['user']`.
- **CSRF & Alertes** : Système d'alertes centralisé (`includes/alerts.php`) pour les erreurs et succès.
