# Session 14 - Défi

Connexion enregistre le jeton toute seule : oui
Créer un article répond 201 sans copier le jeton : oui
Le fichier exporté ne contient aucun jeton : oui

Le dépôt est public. Que risquez-vous si le fichier exporté contient un jeton, et comment l'annuler ?

Quiconque lit le dépôt peut copier le jeton et agir à ma place jusqu'à sa révocation : créer,
modifier ou supprimer mes articles, avec mes droits et sans connaître mon mot de passe. Un jeton
n'expire pas tout seul avec la configuration par défaut de Sanctum, et le retirer du fichier ne
suffit pas : il reste dans l'historique Git et dans les caches. Pour l'annuler, je supprime la
ligne correspondante de `personal_access_tokens` (par exemple en appelant `POST /api/logout` avec
ce jeton, ou en la supprimant dans Tinker), puis je réécris l'historique ou je considère le jeton
comme compromis. La bonne pratique reste de ne jamais exporter de valeur réelle : la variable
`token` garde une valeur initiale vide, et chaque utilisateur la remplit en lançant Connexion.

Pourquoi les écritures de l'API passent-elles par les Form Requests et PostPolicy plutôt que par des
règles écrites dans `Api\PostController` ?

Parce que le site et l'API manipulent les mêmes articles : dupliquer les règles dans le contrôleur
d'API créerait deux sources de vérité qui finiraient par diverger. En réutilisant `StorePostRequest`,
`UpdatePostRequest` et `PostPolicy`, une règle changée une fois s'applique partout, les messages de
validation restent les mêmes en français, et l'ordre des refus est garanti : `auth:sanctum` (401),
puis `authorize()` (403), puis `rules()` (422). Le contrôleur d'API ne fait plus que traduire la
requête vers le modèle, et les tests Pest du site couvrent déjà une partie du comportement de l'API.
