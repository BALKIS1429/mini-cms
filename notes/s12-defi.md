# Session 12 - Défi

1. `role` reste hors de `#[Fillable]` pour bloquer l'affectation de masse. Après l'autorisation et la validation de `author` ou `admin`, le contrôleur affecte directement l'attribut puis appelle `save()`.
2. `Gate::before` renvoie `null` pour un auteur afin que Laravel poursuive vers la Policy correspondante. Renvoyer `false` refuserait aussi les actions que la Policy autorise, comme modifier son propre article.
