# Documentation : Messagerie en Temps Réel

Ce document explique le fonctionnement du système de messagerie implémenté pour FreelanceFlow.

## Architecture

Le système repose sur trois piliers :
1. **Modèle PHP (`message.php`)** : Gère les interactions avec la table `messages` de la base de données.
2. **Contrôleur (`ConversationController.php`)** : Orchestre les échanges de données et renvoie soit du HTML (pour la vue), soit du JSON (pour l'AJAX).
3. **Frontend JavaScript (`conversation.js`)** : Gère l'envoi des messages sans rechargement et la récupération automatique des nouveaux messages (polling).

## Fonctionnement du Temps Réel (Polling AJAX)

Pour assurer une compatibilité maximale sur les environnements XAMPP standards, nous utilisons le **Long Polling AJAX**.

- Toutes les **3 secondes**, le navigateur envoie une requête : `index.php?page=get_new_messages`.
- Il envoie le `last_id` du dernier message affiché.
- Le serveur ne renvoie que les messages dont l'ID est supérieur à ce `last_id`.
- Si de nouveaux messages sont reçus, ils sont injectés dynamiquement dans le DOM sans rafraîchir la page.

## Routes Utilisées

- `?page=messages` : Liste toutes les conversations actives de l'utilisateur.
- `?page=conversation&task_id=X&receiver_id=Y` : Affiche le chat pour une mission spécifique avec un utilisateur précis.
- `?page=send_message` (POST) : Envoie un message.
- `?page=get_new_messages` (GET) : Récupère les nouveaux messages.

## Structure de la Base de Données

Table `messages` :
- `id` : Identifiant unique.
- `task_id` : ID de la mission concernée (permet de grouper par projet).
- `sender_id` : ID de l'expéditeur.
- `receiver_id` : ID du destinataire.
- `content` : Texte du message.
- `created_at` : Date et heure de l'envoi.

## Intégrations dans l'Interface

Des boutons "Contacter" ou "Chat" ont été ajoutés dans :
- La gestion des candidatures côté Client.
- La liste des candidatures côté Freelance.
