# WoodyCraft Admin - Documentation API

API REST Laravel pour le projet **WoodyCraftWeb**.

- **Application Web en flutter liée à l'API :** [Situation_Pro_2_Front](https://github.com/ludo-mastant/Situation_Pro_2_Front.git)

---

## Liste des routes publiques

| Méthode | Route | Description |
|---|---|---|
| GET | `/api/puzzles` | Liste tous les puzzles |
| GET | `/api/puzzles/{id}` | Détail d'un puzzle |
| POST | `/api/puzzles` | Créer un puzzle |
| PUT | `/api/puzzles/{id}` | Modifier un puzzle |
| DELETE | `/api/puzzles/{id}` | Supprimer un puzzle |
| GET | `/api/paniers` | Liste des paniers en cours |
| POST | `/api/paniers` | Créer un panier |
| PUT | `/api/paniers/id/validate` | Validé commandes |
| PUT | `/api/paniers/id/checkout` |  Commandes terminée Validée + Expédiée |
| DELETE | `/api/paniers/id` | Suppression paniers |
| GET | `/api/paniers/{id}` | Détail complet d'une commande |
| PUT | `/api/puzzles/{id}/validate` | Modifier le statut d'une commande en validé |
| PUT | `/api/puzzles/{id}/checkout` | Modifier le statut d'une commande validé en expediée |
| DELETE | `/api/puzzles/{id}` | Supprimer une commande |
| GET | `/api/dashboard/resume` | Chiffres clés du tableau de bord |
| GET | `/api/dashboard/commandes-attente` | Commandes en attente |
| GET | `/api/dashboard/stock-bas` | Puzzles en stock bas |
| GET | `/api/dashboard/stats-ventes` | Statistiques de ventes |
| GET | `/api/dashboard/top-puzzles` | Top 5 puzzles les plus vendus |
| GET | `/api/dashboard/stocks` | Liste des stocks disponibles |

---

## Puzzles

### GET `/api/puzzles`
Retourne la liste de tous les puzzles triés par ID décroissant.

**Réponse 200 :**
```json
[
  {
    "id": 15,
    "nom": "Fond marin",
    "categorie_id": 5,
    "description": "Plongée dans les profondeurs de l'océan, 2000 pièces.",
    "image": "fond_marin.jpg",
    "prix": 42.99,
    "stock": 8,
    "seuil_alerte": 5
  }
]
```

---

### GET `/api/puzzles/{id}`
Retourne le détail d'un puzzle par son ID.

**Paramètre :** `id` - identifiant du puzzle

**Réponse 200 :**
```json
{
  "id": 3,
  "nom": "Tour Eiffel 3D",
  "categorie_id": 2,
  "description": "Reproduisez la Tour Eiffel en 3D, 216 pièces plastique.",
  "image": "tour_eiffel_3d.jpg",
  "prix": 24.99,
  "stock": 3,
  "seuil_alerte": 5
}
```

**Réponse 404 :**
```json
{ "message": "Puzzle introuvable" }
```

---

### POST `/api/puzzles`
Crée un nouveau puzzle.

**Body JSON :**
```json
{
  "nom": "Nouveau puzzle",
  "categorie_id": 1,
  "description": "Description du puzzle.",
  "image": "image.jpg",
  "prix": 29.99,
  "stock": 10
}
```

**Réponse 201 :**
```json
{
  "message": "Puzzle créé avec succès",
  "data": { ... }
}
```

---

### PUT `/api/puzzles/{id}`
Met à jour un puzzle existant.

**Paramètre :** `id` - identifiant du puzzle

**Body JSON :** identique au POST

**Réponse 200 :**
```json
{
  "message": "Puzzle mis à jour",
  "data": { ... }
}
```

**Réponse 404 :**
```json
{ "message": "Puzzle introuvable" }
```

---

### DELETE `/api/puzzles/{id}`
Supprime un puzzle par son ID.

**Paramètre :** `id` - identifiant du puzzle

**Réponse 200 :**
```json
{ "message": "Puzzle supprimé avec succès" }
```

**Réponse 404 :**
```json
{ "message": "Puzzle introuvable" }
```

---

## Paniers / Commandes

### GET `/api/paniers`
Retourne la liste des paniers avec le statut `en cours`.

**Réponse 200 :**
```json
{
  "message": "Liste des paniers en cours",
  "data": [
    { "id": 10, "statut": "en cours" },
    { "id": 11, "statut": "en cours" }
  ]
}
```

---

### POST `/api/paniers`
Crée un nouveau panier.

**Body JSON :**
```json
{
  "user_id": 2,
  "statut": "en cours"
}
```

**Réponse 201 :**
```json
{
  "message": "Panier créé avec succès",
  "data": { ... }
}
```

---

### GET `/api/paniers/{id}`
Retourne le détail complet d'une commande : client, adresse de livraison, articles et informations de paiement.

**Paramètre :** `id` - identifiant du panier

**Réponse 200 :**
```json
{
  "id": 4,
  "statut": "preparation",
  "total": 84.98,
  "mode_paiement": "cheque",
  "date_commande": "2024-11-15T11:00:00.000000Z",
  "client": {
    "id": 5,
    "nom": "Moreau",
    "email": "julie.moreau@yahoo.fr",
    "telephone": "0656789012"
  },
  "adresse_livraison": {
    "rue": "17 rue du Général de Gaulle",
    "ville": "Bordeaux",
    "code_postal": "33000",
    "pays": "France"
  },
  "articles": [
    {
      "id": 9,
      "nom": "Alpes panoramique",
      "image": "alpes_panoramique.jpg",
      "prix_unitaire": 44.99,
      "quantite": 1,
      "sous_total": 44.99
    }
  ],
  "nb_articles": 2
}
```

**Réponse 404 :**
```json
{ "message": "Commande introuvable" }
```

---

##  Dashboard

### GET `/api/dashboard/resume`
Retourne les chiffres clés du tableau de bord admin.

**Réponse 200 :**
```json
{
  "commandes_en_attente": 6,
  "puzzles_stock_bas": 3,
  "chiffre_affaire_mois": 329.94,
  "nombre_clients": 9
}
```

---

### GET `/api/dashboard/commandes-attente`
Retourne la liste des commandes en statut `preparation` avec le détail client et les articles.

**Réponse 200 :**
```json
[
  {
    "id": 4,
    "statut": "preparation",
    "total": 159.89,
    "mode_paiement": "cheque",
    "date_commande": "2024-11-15T11:00:00.000000Z",
    "client": {
      "id": 4,
      "nom": "Leroy",
      "prenom": "Nicolas",
      "email": "nicolas.leroy@hotmail.com"
    },
    "articles": [
      {
        "puzzle_id": 9,
        "nom": "Alpes panoramique",
        "quantite": 1,
        "prix": 44.99,
        "sous_total": 44.99
      }
    ]
  }
]
```

---

### GET `/api/dashboard/stock-bas`
Retourne les puzzles dont le stock est inférieur ou égal au `seuil_alerte`.

**Réponse 200 :**
```json
[
  {
    "id": 3,
    "nom": "Tour Eiffel 3D",
    "stock": 3,
    "seuil_alerte": 5,
    "prix": 24.99,
    "image": "tour_eiffel_3d.jpg",
    "categorie": "Puzzle 3D"
  }
]
```

---

### GET `/api/dashboard/stats-ventes`
Retourne le chiffre d'affaires par jour (30 derniers jours) et par mois (12 derniers mois).

**Réponse 200 :**
```json
{
  "par_jour": [
    {
      "date": "2024-11-01",
      "chiffre_affaires": 64.98,
      "nb_commandes": 1
    }
  ],
  "par_mois": [
    {
      "annee": 2024,
      "mois": 11,
      "chiffre_affaires": 329.94,
      "nb_commandes": 5
    }
  ]
}
```

---

### GET `/api/dashboard/top-puzzles`
Retourne le top 5 des puzzles les plus commandés par quantité vendue.

**Réponse 200 :**
```json
[
  {
    "id": 1,
    "nom": "Paris au crépuscule",
    "prix": 29.99,
    "image": "paris_crepuscule.jpg",
    "stock": 45,
    "total_vendu": 3,
    "revenu_total": 89.97
  }
]
```
