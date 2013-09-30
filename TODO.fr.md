Pour la version 1.2 (en cours)
==============================

FAIT:

- Ajout de tous les appels à l'event_manager qui manquent dans l'application
- Réalisation de la gestion des formulaires propre:
  - Utilisation d'un FormBuilder
  - Finir la gestion de la validation

NON FAIT:

- Ecriture d'un loader pour le ModuleManager
- Déplacement de Pegase/Security dans Pegase/Extension/Security: Pegase/Extension représente toutes les fonctionnalités facultatives de Pegase, mais développées dans le Framework.

- Suppression du dossier Pegase/External à venir: 
  - création des projets sous github/composer:
    - nativgames/pegase-external-twig
    - nativgames/pegase-external-michelf-markdown
    - nativgames/pegase-external-spyc
  - suppression du support pour doctrine2 pour le moment (trop de commandes à coder pour l'instant)

Pour la version 1.3
===================

- Permettre les tests unitaires
- Création éventuelle de nativgames/pegase-external-doctrine2-orm
- Ajout d'un module Pegase/Extension/Language

