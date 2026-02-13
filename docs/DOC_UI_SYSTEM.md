# Système UI & Design Premium - FreelanceFlow

Ce document détaille les standards visuels et les composants interactifs qui définissent l'identité "Indigo-Slate" du projet.

## 🌙 Identité Visuelle (Indigo-Slate)

Le projet utilise une palette de couleurs équilibrée entre le professionnalisme des tons ardoise (Slate) et le dynamisme de l'indigo.

### Palette de Couleurs
- **Indigo Primary**: `#4f46e5` - Couleur principale pour les actions et le branding.
- **Slate Dark**: `#0f172a` - Utilisé pour la sidebar, les panneaux visuels et le texte d'en-tête.
- **Background Light**: `#f8fafc` - Fond des tableaux de bord et formulaires pour une lisibilité maximale.
- **Accent Gold**: `#fbbf24` - Pour les alertes, étoiles de notation et éléments d'attention.

### Typographie
- **HK Grotesk** : Utilisé pour tous les titres (`h1` à `h6`) pour son aspect moderne et géométrique.
- **Inter** : Utilisé pour le corps du texte, les formulaires et les paragraphes pour sa clarté exceptionnelle.

## 🧭 Navigation & Ergonomie

### Sidebar "Elite" (100% Rétractable)
La navigation latérale a été optimisée pour libérer de l'espace de travail :
- **Mode 0px** : La sidebar peut être totalement masquée (0px de largeur) au lieu de simplement se réduire à des icônes.
- **Toggle Intelligent** : Un bouton de menu persistant dans le header permet de rouvrir la sidebar lorsqu'elle est cachée.
- **Transition Smooth** : Animations CSS `bezier(0.4, 0, 0.2, 1)` pour une sensation de fluidité premium.

## ✨ Composants Premium

### Cartes & Listes (`tasks_list.css`)
- **Effets Hover** : Elévation subtile des cartes au survol (`scale(1.02)` et ombre portée accentuée).
- **Badges de Statut** : Couleurs sémantiques pour identifier immédiatement l'état d'une mission (Publiée, En cours, Validée).

### Glassmorphism (Authentification)
- **Blurs** : Utilisation de `backdrop-filter: blur()` pour les formulaires.
- **Bordures Lumineuses** : Bordures semi-transparentes (`rgba(255, 255, 255, 0.1)`) pour un effet de profondeur.

## 📱 Responsivité
Le système est entièrement "Responsive" :
- La sidebar disparaît sur mobile au profit d'un menu burger.
- Les grilles de missions passent automatiquement de 3 colonnes à 1 colonne sur les petits écrans.
