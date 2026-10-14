# Session 03 - Routes, contrôleurs et layout

## Défi

### 1. URL produite par `route('about')` :

La route `about` correspond à l'URL `/a-propos`.

### 2. URL produite par `route('posts.show', 'routes-et-controleurs')` :

L'URL générée est `/posts/routes-et-controleurs`.

### 3. URL produite par `route('posts.archive', 2025)` :

L'URL générée est `/posts/archive/2025`.

### 4. Pourquoi `/posts/archive/abc` et `/posts/article-inconnu` répondent toutes deux 404, et quelle ligne de code en est responsable dans chaque cas ?

- `/posts/archive/abc` répond 404 parce que le paramètre `year` doit être numérique. La contrainte `->whereNumber('year')` dans `routes/web.php` empêche cette URL de correspondre à la route.
- `/posts/article-inconnu` répond 404 parce que l'article avec le slug `article-inconnu` n'existe pas. Dans `PostController.php`, la méthode `show()` utilise `abort(404)` lorsque l'article est introuvable.

### 5. Que se passe-t-il si une vue appelle `route('posts.show')` sans paramètre ?

Laravel déclenche une exception, car la route `posts.show` exige le paramètre `slug`. Il faut fournir ce paramètre pour générer l'URL.