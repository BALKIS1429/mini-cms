# Session 08 - Défi

La route posts.tag utilise {tag:slug} : oui
La page d'un tag n'affiche ni brouillon ni article d'autre tag : oui
Les tags des cartes sont des liens : oui
L'accueil n'affiche que les tags qui ont au moins un article publié : oui
Les trois nouveaux tests passent et php artisan test est vert : oui

Pourquoi filtrer les tags vides après get() plutôt que d'afficher (0) ?
Les tags vides représentent des catégories de navigation sans contenu, il faut donc les retirer après le comptage publié pour ne présenter que des pages utiles.

Combien de requêtes ajoute la liste des tags populaires, et pourquoi pas une par tag ?
Une requête charge les tags avec leur sous-requête de comptage publiée. withCount calcule tous les comptes dans cette requête, donc aucun article ni requête supplémentaire n'est chargé pour chaque tag.
