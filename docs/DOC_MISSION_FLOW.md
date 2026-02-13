# Documentation Fonctionnelle - Cycle de Vie des Missions

Ce document explique le flux de travail (workflow) principal de la plateforme FreelanceFlow, de la création d'une mission à sa validation finale.

## 📋 1. Création & Publication (Client)

- **Saisie** : Un utilisateur avec le rôle `Client` peut créer une mission via `ad_tasks.php` (ou espace dédié).
- **Statut Initial** : La mission est créée avec le statut `pending` (En attente).
- **Modération Admin** : Un administrateur doit valider la mission via `ad_aprobation.php` pour qu'elle passe au statut `published` (Publiée).

## 🔍 2. Exploration (Freelance)

- **Recherche** : Les freelances accèdent à l'Explorer (`tasks_list.php`) pour visualiser toutes les missions au statut `published`.
- **Détails** : En cliquant sur une mission, le freelance accède à `tasks_detail.php` pour lire le descriptif complet, le budget et la durée.

## ✉️ 3. Candidature (Application)

- **Action** : Le freelance clique sur "Postuler" dans la page de détail.
- **Logique (`ApplicationController.php`)** :
    - Vérification que l'utilisateur est connecté et possède le rôle `freelance`.
    - Enregistrement de la candidature dans la table `applications` liée à la tâche.
    - Notification visuelle de succès.

## 🤝 4. Gestion des Candidats (Client)

- **Interface** : Le client peut voir les candidatures reçues pour ses missions dans son tableau de bord (`client_applications`).
- **Décision** : Le client peut accepter ou refuser une candidature.
- **Clôture** : Une fois un freelance sélectionné, la mission peut passer au statut `active` ou `validated` selon le flux de paiement/livraison.

## 💾 Schéma de Données (Résumé)

- **Table `tasks`** : Contient `title`, `description`, `budget`, `status` (pending, published, validated, deleted).
- **Table `applications`** : Contient `task_id`, `user_id` (freelance), `status` (pending, accepted, rejected) et `created_at`.
