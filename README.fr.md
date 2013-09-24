Pegase
======

Pegase est un projet de framework PHP, conçu pour:
- être simple d'utilisation
- faciliter le développement
- n'imposer que le minimum: la gestion de l'authentification n'est pas intégrée dans la base du framework

Pour l'instant, l'objectif n'est pas la performance: Le framework se construit au fur et à mesure, des benchmarks seront effectués par la suite, des optimisations aussi (mise en cache via APC, et génération de fichiers .php pour éviter de parser tous les fichiers de configuration à chaque requête par exemple).

Parser de YAML par défaut : Spyc
================================

Spyc est codé en php5 et est suffisant.
Il ne semble pas retourner d'erreurs, ce qui peut éventuellement être problématique pour un débeuggage (pb de syntaxe dans un .yml dur à trouver par exemple).
Pour l'instant je ne compte pas recoder une implémentation de parser de Yaml, mais c'est une possibilité.

Moteur de templates supporté: Twig
==================================

Twig est un très bon moteur de templates, développé par l'équipe de Symfony(2).

Modules disponibles:
====================

- doctrine2

Configuration du projet:
========================

Configurez votre vhost dans le dossier web/, et acceptez l'URL Rewriting.

-----------

Premiers tests sur composer, préparation du projet en cours.
Documentation et détails sur le projet à venir.
