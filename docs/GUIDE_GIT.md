# Guide Git & GitHub pour FreelanceFlow

Ce guide contient les commandes essentielles pour naviguer dans ton projet, sauvegarder ton travail et collaborer sur GitHub.

## 1. Naviguer entre les branches

Pour voir sur quelle branche tu es :
```powershell
git branch
```

Pour changer de branche :
```powershell
git checkout <nom-de-la-branche>
```
*Exemple : `git checkout main` ou `git checkout feature/mobile-responsive`*

Pour créer une nouvelle branche et y aller directement :
```powershell
git checkout -b <nom-de-la-nouvelle-branche>
```

## 2. Sauvegarder ton travail (Commit)

1. Voir ce qui a changé :
```powershell
git status
```

2. Ajouter tous les fichiers modifiés :
```powershell
git add .
```

3. Créer un "point de sauvegarde" (commit) :
```powershell
git commit -m "Description de ce que tu as fait"
```

## 3. Envoyer sur GitHub (Push)

Pour la première fois sur une branche :
```powershell
git push -u origin <nom-de-la-branche>
```

Ensuite, juste :
```powershell
git push
```

## 4. Récupérer les changements de GitHub (Pull)

Si tu travailles sur plusieurs ordinateurs ou avec d'autres personnes :
```powershell
git pull origin <nom-de-la-branche>
```

## 5. Fusionner ton travail (Merge)

Quand tu as fini une fonctionnalité (ex: mobile) et que tu veux l'envoyer sur la branche principale :

1. Retourne sur main : `git checkout main`
2. Récupère les dernières modifs : `git pull origin main`
3. Fusionne la branche mobile : `git merge feature/mobile-responsive`
4. Envoie le tout sur GitHub : `git push origin main`

## 6. En cas d'erreur (Oups !)

Annuler les modifications non sauvegardées d'un fichier :
```powershell
git restore <nom-du-fichier>
```

Revenir au dernier commit (attention, efface tout ce qui n'est pas commit) :
```powershell
git reset --hard HEAD
```

---
*Astuce : Utilise toujours `git status` pour savoir où tu en es.*
