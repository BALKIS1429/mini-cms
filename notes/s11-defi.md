# Défi — Session 11

- Le formulaire de connexion propose « Se souvenir de moi » ; sa valeur est passée séparément des identifiants à `Auth::attempt`.
- La page `/mes-articles` récupère les articles via la relation de l'utilisateur connecté, les charge avec leurs relations et utilise une pagination de quatre éléments.
- Les contrôles de modification des articles sont visibles uniquement à leur auteur ou à un administrateur.
