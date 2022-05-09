# MenuizMan
MenuizMan is a ticket manager wep application, based on a specifications book and created as part of my AFPA training . 

# Procédure d’installation

I) Prérequis

• PHP 7.4.19 minimum.
• Base de donnée MySQL + phpMyAdmin (ou tout autre outil de gestion).
• Composer (si le dossier vendor à la racine n’est pas présent).
• PHP-CLI pour un essai en local.

II) Installation

• Si le dossier vendor n’est pas présent à la racine du projet (www), lancer la commande
composer install depuis ce dossier.

• En distant : copier le contenu du dossier www à la racine du serveur FTP (www).

• En local : à la racine du dossier www, lancer la commande php -S localhost:8000 , le
projet sera disponible à cette même adresse.

• Depuis phpMyAdmin ou votre outil de gestion de BDD, importer le fichier
Menuiz_v2.sql. Il contient la structure mais aussi les jeux d’essais et les utilisateurs
nécessaires ( ! Voir compatibilité III) !).

• Renommer la base donnée menuiz selon votre configuration.

• Modifier le fichier settings/database.ini pour configurer l’hôte et le mot de passe de la
base de donnée.

III) Compatibilité

  1) Nom de base de donnée

Dans le fichier SQL, la base de donnée est nommée menuiz par défaut, selon votre
configuration il faut changer certaines requêtes (+ la procédure ).

  2) Les utilisateurs de base de donnée

Vous devez avoir le privilège de création d’utilisateur sur la base de donnée.
Dans le fichier settings/database.ini, chaque section sous « DB » correspondent aux
utilisateurs de base de donnée.
En cas d’accès interdit, changer tous les login/mdp par celui de votre accès à la base de
donnée et commentez les requêtes d’insertions dans le fichier sql.

IV) Comptes par défaut de l’application
