# Brif 16: API de Plateforme de Volontariat

**YouCare** souhaite développer une plateforme permettant aux organisateurs d'événements de créer des annonces pour des initiatives bénévoles. Les bénévoles pourront consulter ces annonces et s'engager dans les projets qui correspondent à leurs intérêts et disponibilités.

Vous êtes chargé(e) de développer une **API REST** avec Laravel pour cette plateforme.

## Fonctionnalités Requises

### Gestion des Organisateurs et des Bénévoles :
- Les organisateurs et bénévoles peuvent s'inscrire avec leurs informations, y compris leur nom, adresse e-mail et mot de passe.
- Les organisateurs peuvent créer des annonces pour des initiatives bénévoles, en précisant :
  - Titre de l'événement
  - Type d'événement
  - Date
  - Description
  - Localisation
  - Compétences requises
- Les bénévoles peuvent consulter toutes les annonces disponibles et les filtrer par type d'événement ou par localisation.

### Authentification :
- Mise en place d'un système d'authentification **JWT** pour sécuriser les routes nécessitant une authentification.

### Gestion des Annonces :
- Chaque annonce comprend :
  - Un titre
  - Une description
  - Une date
  - Une localisation
  - Les compétences requises
- Les bénévoles peuvent postuler à une annonce, et les organisateurs peuvent accepter ou refuser les demandes de bénévolat.

### Documentation et Tests :
- Génération de la documentation **Swagger** pour l'API afin de faciliter son utilisation.
- Réalisation de tests unitaires pour chaque fonctionnalité de l'API.
- Utilisation de **Postman** pour valider le bon fonctionnement de l'API dans différents scénarios.

## Bonus :

- Les administrateurs ont la possibilité de gérer les utilisateurs.
- Les organisateurs peuvent noter les bénévoles après chaque événement.
- Les bénévoles peuvent utiliser leurs points pour bénéficier de récompenses ou d'avantages sur la plateforme.
- Système de réputation permettant aux bénévoles de laisser des commentaires sur les organisateurs après chaque événement.


