# Session 07 - Défi : articles de la même catégorie

La section « Dans la même catégorie » apparaît sous un article publié qui a une catégorie : oui
L'article affiché n'apparaît pas dans sa propre section : oui
Un brouillon de la même catégorie n'apparaît pas : oui
La page s'ouvre sans LazyLoadingViolationException : oui
Le nouveau test passe et php artisan test est vert : oui

Combien de requêtes SQL charge la section, et pourquoi pas une par carte ?

La section charge une requête pour les articles apparentés, puis une requête pour les auteurs, une pour les catégories et une pour les tags grâce à with(). Ainsi, le nombre de requêtes reste constant quel que soit le nombre de cartes.
