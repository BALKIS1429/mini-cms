\# Défi S05 — Derniers articles publiés



\## Objectif



Afficher sur la page d'accueil les trois derniers articles publiés et vérifier le résultat avec un test automatisé.



\## Travail réalisé



\- \[x] Filtrer les articles avec `where('is\_published', true)`.

\- \[x] Trier les articles par date de publication décroissante avec `latest('published\_at')`.

\- \[x] Limiter les résultats à trois articles avec `take(3)`.

\- \[x] Afficher les articles avec le composant Blade `x-post-card`.

\- \[x] Afficher un message si aucun article n'est publié.

\- \[x] Supprimer le bloc « Sprint en cours » de la page d'accueil.

\- \[x] Tester l'affichage des articles publiés et l'exclusion des brouillons et des articles plus anciens.



\## Vérification



Commande exécutée :



`php artisan test --filter=PostPagesTest`



Résultat : \*\*PASS — 1 test réussi, 7 assertions\*\*.



\## Conclusion



La page d'accueil affiche les trois articles publiés les plus récents. Les brouillons et les articles publiés plus anciens ne sont pas affichés.

