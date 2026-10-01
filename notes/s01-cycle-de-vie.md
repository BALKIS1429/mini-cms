# Cycle de vie d'une requête Laravel

Pour une requête GET /heure, le navigateur envoie d'abord la requête vers `public/index.php`.

`public/index.php` est le point d'entrée de l'application. Il charge ensuite l'autoloader de Composer avec `vendor/autoload.php`.

Ensuite, `public/index.php` charge `bootstrap/app.php`.

Le fichier `bootstrap/app.php` crée et configure l'application Laravel et déclare notamment le fichier `routes/web.php`.

Laravel cherche ensuite la route `/heure` dans `routes/web.php`.

La route `/heure` exécute sa closure et renvoie la vue `resources/views/heure.blade.php`.

La vue Blade est compilée en HTML.

Enfin, Laravel renvoie la réponse HTML au navigateur.

## Ordre des fichiers

1. `public/index.php`
2. `vendor/autoload.php`
3. `bootstrap/app.php`
4. `routes/web.php`
5. `resources/views/heure.blade.php`
6. Navigateur