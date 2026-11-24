# Session 13 - Défi

/api/posts/3 affiche tags avec des noms : oui
/api/posts ne contient aucun body, /api/posts/3 en contient un : oui
Aucune LazyLoadingViolationException : oui

Pourquoi ne pas envoyer body dans la liste, et qui en profite ?

Le contenu complet d'un article est le champ le plus volumineux. La liste n'en a pas besoin :
elle affiche un titre, un extrait et des métadonnées. En l'omettant, la réponse est plus légère,
plus rapide à produire, à transmettre et à mettre en cache. Les clients qui paient des données
mobiles, les connexions lentes et le serveur en profitent ; le client demande le contenu seulement
quand l'utilisateur ouvre la page d'un article (`/api/posts/{post}`).

Un brouillon renvoie 403. Quel avantage aurait un 404 pour un brouillon ?

Un 403 confirme que l'article existe, même si son contenu est refusé : un visiteur peut deviner
les identifiants des brouillons et apprendre qu'un article non publié est en préparation. Un 404
ne révèle pas l'existence de la ressource : du point de vue du visiteur, un brouillon est
indistinguable d'un identifiant qui n'existe pas. Pour une API publique, le 404 protège donc
mieux l'information. L'inconvénient est un message moins précis pour un client autorisé, qui ne
sait pas s'il s'est trompé d'adresse ou s'il n'a pas le droit.
