# Documentation - Gestion des Candidatures

Ce document explique le flux complet de gestion des candidatures sur la plateforme FreelanceFlow, de la soumission par le freelance à la validation par le client.

## 1. Soumission d'une Candidature (Freelance)

### Vue : `public/tasks_page/tasks_detail.php`
-   Le formulaire de candidature s'affiche uniquement pour les utilisateurs connectés avec le rôle **Freelance**.
-   Champs :
    -   **Message** : Lettre de motivation ou détails sur l'approche.
    -   **Tarif (€)** : Proposition tarifaire pour la mission.

### Contrôleur : `ApplicationController::apply()`
-   Vérifie que l'utilisateur est bien un freelance.
-   Vérifie que le freelance n'a pas déjà postulé à cette mission (`Applications::hasApplied`).
-   Enregistre la candidature avec le statut `pending` (en attente).

## 2. Suivi des Candidatures (Freelance)

### Vue : `public/dashboard_page/freelance/my_applications.php`
-   Accessibles via le menu "Mes Candidatures".
-   Affiche la liste de toutes les candidatures soumises.
-   Colonnes : Mission, Client, Date de candidature, Statut (En attente, Accepté, Rejeté).

## 3. Gestion des Candidatures (Client)

### Vue : `public/dashboard_page/client/client_applications.php`
-   Accessibles via le menu "Candidatures Reçues".
-   Affiche toutes les candidatures pour les missions publiées par le client.
-   Informations affichées :
    -   Nom et Email du Freelance.
    -   Titre de la mission concernée.
    -   Tarif proposé.
    -   Message (via une pop-up).

### Actions du Client
-   **Accepter (✔)** : Change le statut de la candidature en `accepted`.
-   **Rejeter (✖)** : Change le statut de la candidature en `rejected`.
-   Ces actions sont gérées par `ApplicationController::updateApplicationStatus()`.

## 4. Modèle de Données

Table SQL : `applications`

| Colonne | Type | Description |
| :--- | :--- | :--- |
| `id` | INT | Identifiant unique |
| `task_id` | INT | Référence à la mission |
| `freelance_id` | INT | Référence au freelance |
| `message` | TEXT | Message de motivation |
| `bid_price` | DECIMAL | Tarif proposé |
| `status` | ENUM | 'pending', 'accepted', 'rejected' |
| `created_at` | TIMESTAMP | Date de candidature |
