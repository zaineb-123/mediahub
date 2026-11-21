
# MediaHub API Documentation

## 1. Présentation

L'API MediaHub permet de consulter, créer, modifier et supprimer des publications.

Elle est développée avec Laravel et utilise Laravel Sanctum pour sécuriser les opérations nécessitant une authentification.

**URL de base :**
`http://127.0.0.1:8000/api`

**Format des données :** JSON

## 2. Authentification

Les opérations de lecture sont publiques.

Les opérations de création, modification et suppression nécessitent un token Sanctum.

Pour obtenir un token, utiliser :

`POST /connexion`

Pour les requêtes protégées, ajouter l'en-tête :

`Authorization: Bearer VOTRE_TOKEN`

Les requêtes JSON doivent également contenir :

`Accept: application/json`

## 3. Liste des points d'accès

| Méthode | URL | Authentification | Description |
|---|---|---|---|
| GET | /publications | Non | Liste des publications |
| GET | /publications/{publication} | Non | Détail d'une publication |
| POST | /connexion | Non | Connexion et obtention d'un token |
| POST | /publications | Oui | Créer une publication |
| PUT/PATCH | /publications/{publication} | Oui | Modifier une publication |
| DELETE | /publications/{publication} | Oui | Supprimer une publication |
| GET | /user | Oui | Informations de l'utilisateur connecté |

## 4. Exemples de requêtes et réponses

### 4.1 Consulter les publications

**Méthode :** GET

**URL :** `/api/publications`

**Authentification :** Aucune.

Exemple de requête :

```bash
curl -X GET http://127.0.0.1:8000/api/publications \
-H "Accept: application/json"
```

Exemple de réponse :

```json
{
  "data": [
    {
      "id": 24,
      "titre": "Publication test",
      "contenu": "Contenu de la publication...",
      "categorie": "Image11",
      "auteur": "zaineb",
      "image": "http://localhost/storage/publications/image.jpg",
      "miniature": "http://localhost/storage/miniatures/image.jpg",
      "fichier_media": null,
      "type_media": null,
      "publie_le": "2026-11-19"
    }
  ]
}
```

La liste est paginée avec 10 publications par page.

### 4.2 Consulter une publication

**Méthode :** GET

**URL :** `/api/publications/{publication}`

**Authentification :** Aucune.

Exemple de requête :

```bash
curl -X GET http://127.0.0.1:8000/api/publications/24 \
-H "Accept: application/json"
```

Exemple de réponse :

```json
{
  "data": {
    "id": 24,
    "titre": "Publication test",
    "contenu": "Contenu de la publication...",
    "categorie": "Image11",
    "auteur": "zaineb",
    "image": null,
    "miniature": null,
    "fichier_media": null,
    "type_media": null,
    "publie_le": "2026-11-19"
  }
}
```

### 4.3 Se connecter et obtenir un token

**Méthode :** POST

**URL :** `/api/connexion`

**Authentification :** Aucune.

Exemple de requête :

```json
{
  "email": "utilisateur@example.com",
  "password": "votre_mot_de_passe"
}
```

Exemple de réponse :

```json
{
  "token": "1|votre_token_sanctum"
}
```

Le token obtenu doit être utilisé dans les requêtes protégées.

### 4.4 Créer une publication

**Méthode :** POST

**URL :** `/api/publications`

**Authentification :** Token Sanctum obligatoire.

En-têtes :

```text
Accept: application/json
Content-Type: application/json
Authorization: Bearer VOTRE_TOKEN
```

Exemple de requête :

```json
{
  "titre": "Ma nouvelle publication",
  "contenu": "Voici le contenu de ma nouvelle publication MediaHub.",
  "categorie_id": 1
}
```

Exemple de réponse :

```json
{
  "data": {
    "id": 25,
    "titre": "Ma nouvelle publication",
    "contenu": "Voici le contenu de ma nouvelle publication MediaHub.",
    "categorie": "Image11",
    "auteur": "zaineb",
    "image": null,
    "miniature": null,
    "fichier_media": null,
    "type_media": null,
    "publie_le": "2026-11-19"
  }
}
```

**Code HTTP attendu :** 201 Created.

Les champs `image` et `fichier_media` peuvent également être envoyés en multipart/form-data.

### 4.5 Modifier une publication

**Méthode :** PUT ou PATCH

**URL :** `/api/publications/{publication}`

**Authentification :** Token Sanctum obligatoire.

Seul l'auteur de la publication ou un administrateur peut la modifier.

En-têtes :

```text
Accept: application/json
Content-Type: application/json
Authorization: Bearer VOTRE_TOKEN
```

Exemple de requête :

```json
{
  "titre": "Titre modifié",
  "contenu": "Le contenu de cette publication a été modifié."
}
```

Exemple de réponse :

```json
{
  "data": {
    "id": 25,
    "titre": "Titre modifié",
    "contenu": "Le contenu de cette publication a été modifié.",
    "categorie": "Image11",
    "auteur": "zaineb",
    "image": null,
    "miniature": null,
    "fichier_media": null,
    "type_media": null,
    "publie_le": "2026-11-19"
  }
}
```

**Code HTTP attendu :** 200 OK.

### 4.6 Supprimer une publication

**Méthode :** DELETE

**URL :** `/api/publications/{publication}`

**Authentification :** Token Sanctum obligatoire.

Seul l'auteur de la publication ou un administrateur peut la supprimer.

Exemple de requête :

```bash
curl -X DELETE http://127.0.0.1:8000/api/publications/25 \
-H "Accept: application/json" \
-H "Authorization: Bearer VOTRE_TOKEN"
```

**Réponse attendue :**

```text
HTTP 204 No Content
```

La suppression utilise le mécanisme SoftDeletes de Laravel.

### 4.7 Consulter l'utilisateur connecté

**Méthode :** GET

**URL :** `/api/user`

**Authentification :** Token Sanctum obligatoire.

Exemple de requête :

```bash
curl -X GET http://127.0.0.1:8000/api/user \
-H "Accept: application/json" \
-H "Authorization: Bearer VOTRE_TOKEN"
```

Exemple de réponse :

```json
{
  "id": 1,
  "name": "zaineb",
  "email": "utilisateur@example.com",
  "role": "auteur"
}
```

## 5. Codes de réponse HTTP

| Code | Signification |
|---|---|
| 200 | Requête réussie |
| 201 | Publication créée avec succès |
| 204 | Publication supprimée avec succès |
| 401 | Utilisateur non authentifié ou identifiants incorrects |
| 403 | Action interdite : l'utilisateur n'a pas les droits nécessaires |
| 404 | Ressource introuvable |
| 422 | Erreur de validation des données |

## 6. Règles de sécurité

- Les routes de lecture des publications sont publiques.
- Les routes de création, modification et suppression sont protégées par `auth:sanctum`.
- Chaque publication est associée à son auteur lors de sa création.
- Un utilisateur peut modifier ou supprimer ses propres publications.
- Un administrateur peut modifier ou supprimer toutes les publications.
- Les données envoyées sont validées avec les Form Requests Laravel.
- Les mots de passe ne sont jamais retournés dans les réponses API.

---

**Projet : MediaHub**

**Framework : Laravel**

**Authentification : Laravel Sanctum**

**Format des échanges : JSON**
