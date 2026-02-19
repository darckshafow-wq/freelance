# Guide de la Responsivité - FreelanceFlow

Ce document explique comment maintenir et améliorer l'aspect mobile de la plateforme FreelanceFlow.

## 1. Principes de Base

Toutes les pages doivent inclure la balise méta suivante dans le `<head>` pour activer le responsive :
```html
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```

## 2. Breakpoints (Points de rupture)

Nous utilisons principalement trois points de rupture dans nos fichiers CSS :

- **768px** : Passage au mode smartphone. La barre latérale se cache et le contenu s'empile verticalement.
- **1024px** : Ajustements pour tablettes et petits ordinateurs.
- **+1024px** : Mode bureau complet (design premium).

## 3. Classes Utilitaires Responsives

### Tableaux
Pour rendre un tableau scrollable sur mobile, entoure-le d'une div avec la classe `table-responsive` :
```html
<div class="table-responsive">
    <table>...</table>
</div>
```

### Grilles de Statistiques
Utilise la classe `.stats-grid`. Elle passe automatiquement d'un affichage en colonnes à une pile verticale sur mobile.

### Conteneurs
Utilise la classe `.content-wrapper`. Elle gère automatiquement les marges internes (padding) pour éviter que le texte ne touche les bords de l'écran sur smartphone.

## 4. Le Menu Latéral (Sidebar)

Sur mobile, la sidebar fonctionne différemment :
1. Elle est cachée par défaut (translation de -100%).
2. Elle s'affiche par-dessus le contenu quand l'utilisateur clique sur le bouton menu.
3. Le JavaScript (`script.js`) gère l'ajout/suppression de la classe `.collapsed` sur le body ou l'élément sidebar.

## 5. Astuces pour les Nouveaux Formulaires

Évitez les styles en ligne (inline styles) comme `style="display: grid; grid-template-columns: 1fr 1fr;"`. Préférez des classes CSS ou utilisez des grilles flexibles :

```css
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}
```

## 6. Fichiers CSS Concernés

- `global.css` : Variables et mise en page de base.
- `dashboard.css` : Tout ce qui concerne les espaces Client, Freelance et Admin.
- `navbar.css` & `footer.css` : Navigation et pied de page.
- `welcome.css` / `landig.css` : Pages publiques d'accueil et d'inscription.
```
