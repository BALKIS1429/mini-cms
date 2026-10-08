# Session 02 - Git et GitHub

Réponses rédigées avec mes propres mots, puis comparées au corrigé de la page.

## 1. Index et commit

Réponse :La commande `git add` déplace les modifications du répertoire de travail vers l’index (staging). Ensuite, la commande `git commit` enregistre les modifications de l’index dans le dépôt local.


## 2. Branche et tag

Réponse :
Une branche peut avancer avec les nouveaux commits.
Un tag reste fixé sur un commit précis.

## 3. Le fichier .env

Réponse :
Le fichier .env contient des informations importantes et secrètes, donc on ne le met pas sur GitHub.
Un autre développeur peut créer son .env à partir de .env.example et utiliser php artisan key:generate.

## 4. Le dossier vendor/

Réponse :
Le dossier vendor/ contient les dépendances du projet, donc on ne le met pas sur GitHub.
On peut le recréer avec composer install grâce au fichier composer.lock.

## 5. Git Credential Manager

Réponse :
Git Credential Manager garde le token GitHub dans le Gestionnaire d’identifiants Windows.
Sur un PC universitaire ou partagé, il faut supprimer le token à la fin du travail.