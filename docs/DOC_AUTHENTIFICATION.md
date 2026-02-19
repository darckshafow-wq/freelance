# Documentation : Système d'Authentification

## Flux d'Inscription
- **Utilisateurs** : Peuvent s'inscrire en tant que "Client" ou "Freelance".
- **Données** : Nom, Email, Mot de passe (haché avec BCRYPT), Rôle.
- **Redirection** : Après inscription, redirection automatique vers la page de connexion.

## Flux de Connexion
- **Validation** : Vérification des identifiants dans la table `users`.
- **Session** : Stockage des informations utilisateur (`id`, `name`, `role`, `email`) dans `$_SESSION['user']`.
- **Redirection Intelligente** :
  - Admin ➔ Tableau de Bord Admin
  - Client ➔ Exploration des Missions / Dashboard Client
  - Freelance ➔ Exploration des Missions / Dashboard Freelance

## Sécurité
- Sessions PHP activées sur toutes les pages via `session_start()`.
- Accès restreint aux pages privées via un contrôle de session dans les contrôleurs.
