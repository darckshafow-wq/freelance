# Guide d'Intégration du Système de Paiement

Ce guide explique comment intégrer une solution comme Stripe ou PayPal dans FreelanceFlow pour sécuriser les transactions entre clients et freelances.

## 1. Intégration de Stripe (Recommandé)

### Configuration
1. Créer un compte sur [Stripe Dashboard](https://dashboard.stripe.com/).
2. Récupérer vos clés API (Clé Publique et Clé Secrète).

### Flux de Paiement
1. **Frontend** : Utiliser Stripe Elements pour récupérer les informations de carte de manière sécurisée.
2. **Backend (PHP)** : 
   - Créer un `PaymentIntent`.
   - Confirmer le paiement une fois le livrable validé par le client.
3. **Escrow (Séquestre)** :
   - Le client paie à la création de la mission ou au recrutement.
   - Les fonds sont conservés par Stripe.
   - Le virement vers le freelance est déclenché manuellement ou automatiquement à la fin.

## 2. Structure de la Table `payments`
```sql
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    amount DECIMAL(10,2),
    status ENUM('pending', 'completed', 'refunded'),
    transaction_id VARCHAR(255)
);
```

## 3. Sécurité
- Toujours utiliser HTTPS.
- Ne jamais stocker de coordonnées bancaires sur votre serveur (laisser Stripe gérer via des tokens).
- Utiliser des Webhooks pour confirmer que le paiement a bien été reçu côté serveur.
