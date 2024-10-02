# MyAMP - Guide d'utilisation

MyAMP est une application de gestion de serveurs web locale, similaire à WAMP, qui vous permet de créer et gérer des projets PHP/MySQL via une interface web conviviale. Avec MyAMP, vous pouvez créer, visualiser et supprimer des projets, accéder rapidement à phpMyAdmin pour la gestion des bases de données, et automatiser certaines tâches locales de développement.

## Fonctionnalités principales

- **Création de projets PHP localement** : Créez facilement des projets avec un fichier `index.php` par défaut.
- **Suppression de projets** : Supprimez les projets que vous n'utilisez plus directement depuis l'interface web.
- **Accès rapide à phpMyAdmin** : Gérez vos bases de données MySQL directement depuis phpMyAdmin.
- **Recherche automatique de fichier `index.php`** : Le système détecte automatiquement le fichier `index.php` dans les projets pour un accès rapide.

## Prérequis

Avant d'utiliser MyAMP, vous devez vous assurer que les outils suivants sont installés sur votre machine :

- **PHP** : Pour exécuter les scripts PHP localement. Assurez-vous que PHP est accessible depuis la ligne de commande.
- **MySQL** : Pour gérer les bases de données MySQL via phpMyAdmin.
- **Serveur web local** : MyAMP est conçu pour fonctionner avec un serveur local (comme Apache ou Nginx) configuré pour utiliser `localhost`.

## Installation

### Étape 1 : Configuration initiale

1. Placez tous les fichiers de MyAMP dans un dossier dédié sur votre machine locale.
2. Assurez-vous que **PHP** et **MySQL** sont installés et fonctionnels. Vous pouvez vérifier cela en exécutant les commandes `php -v` et `mysql -v` dans votre terminal ou invite de commande.

### Étape 2 : Lancement de l'application

Pour accéder à MyAMP, ouvrez un navigateur et allez à l'adresse suivante :

http://localhost/index.php


Cette interface est votre panneau de contrôle pour créer, visualiser et gérer vos projets.

## Utilisation de MyAMP

### 1. Créer un nouveau projet

Pour créer un projet, suivez les étapes ci-dessous :

1. Dans l'interface principale, vous verrez un formulaire où vous pouvez entrer le **nom du projet**.
2. Tapez le nom du projet souhaité et cliquez sur **Créer le Projet**.
3. Un dossier sera créé dans le répertoire de votre serveur local avec un fichier `index.php` par défaut contenant un message de bienvenue.

Le projet sera alors visible dans la liste des projets disponibles.

### 2. Accéder à un projet

Dans la liste des projets affichés sur la page principale, cliquez simplement sur le nom du projet que vous souhaitez ouvrir. MyAMP recherchera automatiquement un fichier `index.php` dans le dossier du projet et vous redirigera vers celui-ci dans votre navigateur.

Si aucun fichier `index.php` n'est trouvé, un message d'erreur s'affichera.

### 3. Supprimer un projet

Si vous souhaitez supprimer un projet :

1. Dans la liste des projets, à côté du nom de chaque projet, vous verrez un bouton **Supprimer**.
2. Cliquez sur ce bouton et confirmez la suppression. Le dossier du projet ainsi que tous les fichiers qu'il contient seront supprimés de votre disque.

### 4. Accéder à phpMyAdmin

Un lien direct vers phpMyAdmin est disponible sur l'interface principale de MyAMP. Cliquez sur le bouton **Accéder à phpMyAdmin** pour gérer vos bases de données MySQL à l'adresse suivante :

http://localhost/phpmyadmin/index.php


Assurez-vous que **MySQL** est correctement configuré et que phpMyAdmin est accessible via `localhost`.


Le fichier `index.php` contient un simple script PHP qui affiche un message de bienvenue sur le projet. Vous pouvez le modifier pour démarrer le développement de votre projet.

## Supprimer des fichiers spécifiques

L'application ignore certains fichiers spécifiques tels que **phpMyAdmin** lors de l'affichage de la liste des projets. Si un dossier s'appelle `phpmyadmin` (peu importe la casse), il sera automatiquement ignoré et ne s'affichera pas dans la liste des projets.

## Conclusion

MyAMP est conçu pour vous fournir un environnement de développement local simple et efficace. En suivant ce guide, vous pourrez créer, gérer et supprimer vos projets PHP tout en profitant d'un accès facile à phpMyAdmin pour la gestion de vos bases de données MySQL.

Si vous rencontrez des problèmes ou avez des questions, n'hésitez pas à vérifier vos configurations de PHP et MySQL, ou à ajuster les permissions de votre serveur local.


