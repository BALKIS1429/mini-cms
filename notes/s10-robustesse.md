# Session 10 - Robustesse

TagAdminTest contient 5 tests verts : oui
/posts/categorie/inconnue affiche Catégorie introuvable avec le statut 404 : oui
php artisan test est vert : oui

1. Pourquoi le message de messages() l'emporte-t-il sur celui de lang/fr/validation.php ?
Laravel choisit le message le plus spécifique à la règle et au champ dans la Form Request avant le message général du fichier de langue.

2. Pourquoi phpunit.xml fixe-t-il APP_LOCALE ?
Les tests comparent des messages en français ; fixer la locale rend leur résultat indépendant de .env et identique sur chaque poste.

3. Pourquoi CategoryController n'a-t-il besoin d'aucun try/catch ?
Les Form Requests et le middleware gèrent validation et lecture seule, tandis que le route model binding et le gestionnaire d'exceptions traitent les erreurs 404.
