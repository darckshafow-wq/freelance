# Plan de Fonctionnement - Base de Données

Ce document détaille la structure actuelle de la base de données, les améliorations prévues et le plan d'évolution technique.

## 1. Structure Actuelle (Physique)

La base de données `freelance_db` est actuellement composée de trois tables principales :

### Table `users`
Stocke les informations des utilisateurs (Clients, Freelancers, Admins).
- `id`: Identifiant unique (PK)
- `name`: Nom complet
- `email`: Adresse email (Unique)
- `password`: Mot de passe haché
- `role`: Rôle de l'utilisateur (client, freelancer, admin)
- `created_at`: Date d'inscription

### Table `tasks`
Stocke les missions/projets publiés par les clients.
- `id`: Identifiant unique (PK)
- `user_id`: ID du client (FK -> users)
- `title`: Titre de la mission
- `description`: Détails de la mission
- `price`: Budget proposé
- `localisation`: Lieu de la mission
- `deadline`: Date limite
- `is_permanent`: Indique si c'est un poste permanent
- `status`: État de la mission (pending, published, validated, completed, cancelled)
- `created_at`: Date de création

### Table `applications`
Gère les candidatures des freelancers pour les missions.
- `id`: Identifiant unique (PK)
- `task_id`: ID de la mission (FK -> tasks)
- `freelance_id`: ID du freelancer (FK -> users)
- `message`: Message de motivation
- `bid_price`: Prix proposé par le freelancer
- `status`: État de la candidature (pending, accepted, rejected)
- `created_at`: Date de postulation

---

## 2. Nouvelles Tables (Améliorations à Venir)

Pour rendre la plateforme pleinement opérationnelle, les tables suivantes seront ajoutées prochainement :

### Table `payments`
Gérera les transactions entre clients et freelancers.
```sql
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'completed', 'refunded') DEFAULT 'pending',
    transaction_ref VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (task_id) REFERENCES tasks(id),
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);
```

### Table `reviews`
Permettra l'évaluation après la fin d'une mission.
```sql
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    reviewer_id INT NOT NULL,
    reviewed_id INT NOT NULL,
    rating TINYINT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (task_id) REFERENCES tasks(id),
    FOREIGN KEY (reviewer_id) REFERENCES users(id),
    FOREIGN KEY (reviewed_id) REFERENCES users(id)
);
```

### Table `messages`
Gérera la communication directe.
- `id`, `sender_id`, `receiver_id`, `content`, `is_read`, `created_at`.

### Table `notifications`
Pour alerter les utilisateurs des nouveaux événements (nouvelle candidature, mission validée, etc.).
- `id`, `user_id`, `type`, `message`, `is_read`, `created_at`.

---

## 3. Plan d'Amélioration & Roadmap

### Phase 1 : Consolidation (Terminé)
- [x] Documentation complète du schéma existant.
- [x] Création des fichiers SQL de base.
- [x] Implémentation des nouvelles tables (`payments`, `reviews`, `messages`, `notifications`).
- [x] Création des modèles PHP pour les nouvelles entités.

### Phase 2 : Interactions (Terminé)
- [x] Mise en place du module de messagerie (Modèles, Contrôleurs, Routes).
- [x] Système de notifications (Modèles, Contrôleurs, Routes, Vue).
- [x] Gestion des avis (Modèles, Contrôleurs, Routes).

### Phase 3 : Sécurisation & Paiement (Moyen Terme)
- [] Intégration d'un système de paiement (Escrow).
- [] Système d'évaluation mutuelle.

### Phase 4 : Optimisation (Long Terme)
- [] Indexation pour la recherche rapide.
- [] Archivage des anciennes missions.
