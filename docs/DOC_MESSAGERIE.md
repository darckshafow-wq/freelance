# Documentation : Messagerie & Notifications

## Messagerie Temps Réel
Basée sur un système de **Polling AJAX**, la messagerie permet des échanges fluides entre les acteurs de la plateforme.

### Fonctionnement
- **Envoi** : Formulaire AJAX envoyant des données à `index.php?page=send_message`.
- **Réception** : Un script JS (`pollMessages`) interroge le serveur toutes les 3 secondes pour récupérer les nouveaux messages.
- **Contextualisation** : Chaque message est lié à un `task_id`, permettant des conversations isolées par projet.

## Système de Notifications
- **Badges Unread** : Des pastilles rouges s'affichent dans le header si des messages n'ont pas été lus.
- **Mark as Read** : Les messages sont marqués comme lus (`is_read = 1`) dès l'ouverture de la conversation.

## Modèle de Données
Table `messages` :
- `sender_id`, `receiver_id`
- `task_id`
- `content`
- `is_read`, `created_at`
