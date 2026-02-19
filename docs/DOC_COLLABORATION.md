# Documentation : Système de Collaboration & Team Workspace

## Workspace Collaboratif
Le Workspace est le centre de travail pour chaque mission active. Il est accessible via `?page=collaboration&id=ID_MISSION`.

### Fonctionnalités
- **Gestion d'Équipe** : Affiche tous les freelances et le client travaillant sur la mission.
- **Tableau de Bord de Tâches** : Permet de diviser la mission principale en sous-tâches gérables.
- **Suivi de la Progression** : Une barre de progression calcule automatiquement l'avancement total basé sur les sous-tâches complétées.
- **Chat en Temps Réel** : Un salon de discussion dédié à l'équipe pour une communication fluide.

## Structure des Données
- `team_members` : Lie les utilisateurs à une mission avec des rôles spécifiques.
- `sub_tasks` : Tâches atomiques liées à une mission parente.

## Roles
- **Client** : Supervise le projet et valide les livrables.
- **Freelance Principal** : Responsable de la mission.
- **Membre de l'Équipe** : Collaborateurs invités par le freelance principal.
