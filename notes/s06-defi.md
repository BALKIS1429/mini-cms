# Session 06 - Défi : publier et dépublier

La route posts.publication apparaît dans route:list avec le verbe PATCH : oui
Le bouton affiche « Publier » sur un brouillon et « Dépublier » sur un article publié : oui
published_at est rempli à la publication et vidé à la dépublication : oui
Le nouveau test passe et php artisan test est vert : oui

Pourquoi PATCH et pas PUT ni GET pour ce bouton ?

PATCH exprime la modification partielle de l'état de publication. GET ne doit pas modifier les données, et PUT remplace une ressource entière alors que cette action ne change que sa publication.# Session 06 - Défi : publier et dépublier

La route posts.publication apparaît dans route:list avec le verbe PATCH : oui
Le bouton affiche « Publier » sur un brouillon et « Dépublier » sur un article publié : oui
published_at est rempli à la publication et vidé à la dépublication : oui
Le nouveau test passe et php artisan test est vert : oui

Pourquoi PATCH et pas PUT ni GET pour ce bouton ?

PATCH convient parce que l'action modifie uniquement l'état de publication et sa date, pas l'ensemble de l'article. GET ne doit pas modifier les données.
