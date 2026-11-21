# Rapport qualité – MediaHub

## 1. Tests automatisés

Les tests ont été réalisés avec PHPUnit et Laravel.

Configuration :
- Base de données SQLite en mémoire pour les tests.
- Environnement `testing`.
- Cache configuré avec le pilote `array`.

Résultat final :

- **10 tests réussis**
- **19 assertions**
- Aucune erreur détectée.

### Tests réalisés

| Test | Résultat |
|---|---|
| Test unitaire de base | Réussi |
| Consultation de l'API des publications | Réussi |
| Refus de création API sans authentification | Réussi |
| Création d'un compte utilisateur | Réussi |
| Refus de connexion avec mauvais mot de passe | Réussi |
| Création de catégorie par un administrateur | Réussi |
| Refus de création de catégorie par un auteur | Réussi |
| Modification de sa propre publication | Réussi |
| Refus de modification de la publication d'un autre auteur | Réussi |

## 2. Sécurité et autorisations

Les contrôles d'accès ont été vérifiés :

- Seuls les administrateurs peuvent gérer les catégories.
- Un auteur peut modifier sa propre publication.
- Un auteur ne peut pas modifier la publication d'un autre utilisateur.
- Les routes API protégées nécessitent une authentification.

## 3. Optimisation des requêtes SQL

Le problème N+1 a été étudié grâce à `DB::listen()` et aux journaux Laravel.

L'application utilise le chargement anticipé des relations :

```php
Publication::with(['categorie', 'auteur'])
```

Cette optimisation permet de récupérer les catégories et les auteurs avec des requêtes groupées.

Le compteur de commentaires est récupéré avec :

```php
->withCount('commentaires')
```

Cela évite de charger individuellement tous les commentaires pour afficher leur nombre.

## 4. Mise en cache

La liste des catégories est conservée en cache pendant une heure avec :

```php
Cache::remember('categories_liste', 3600, function () {
    return Categorie::withCount('publications')->get();
});
```

Le cache est invalidé après :
- La création d'une catégorie.
- La modification d'une catégorie.
- La suppression d'une catégorie.

La méthode utilisée est :

```php
Cache::forget('categories_liste');
```

## 5. Conclusion

Les tests automatisés, les contrôles d'accès, l'optimisation des requêtes SQL et la mise en cache ont permis d'améliorer la qualité et les performances de MediaHub.

Le résultat final des tests est de **10 tests réussis et 19 assertions**.