Plugin et Bloc - UCA "Mes cours"
==================================
Projet ayant pour but de faire afficher de manière intuitive les cours suivis par un utilisateur dans un bloc Moodle. 
Le bloc est étroitement lié au plugin qui contiendra toutes les librairies et fonctions nécessaires à l'affichage du bloc ainsi qu'à la gestion de favoris (fonctionnalité non disponible dans le Moodle de base).

Pré-requis
------------
- Moodle en version 3.3 (build 2017051500) ou plus récente.<br/>
-> Tests effectués sur des versions 3.3 et 3.4.<br/>
- Bloc "<a href="https://github.com/andurif/moodle-block_uca_mycourses">UCA Mes Cours"</a> (build 2018020801) pour afficher les informations des favoris<br/>
- Thème qui supporte bootstrap.
- Plugin JS Jstree => https://github.com/vakata/jstree (joint dans le dossier jstree/)

Installation
------------
1. Installation du module

- Avec git:
> git clone https://github.com/andurif/moodle-local_uca_mycourses.git local/uca_mycourses

- En téléchargement:
> Télécharger le zip depuis https://github.com/andurif/moodle-local_uca_mycourses/archive/master.zip, dézipper l'archive dans le dossier local/ et renommer le si besoin le dossier en "uca_mycourses".
  
2. Installation du bloc

- Avec git:
> git clone https://github.com/andurif/moodle-block_uca_mycourses.git blocks/uca_mycourses

- En téléchargement:
> Télécharger le zip depuis https://github.com/andurif/moodle-block_uca_mycourses/archive/master.zip, dézipper l'archive dans le dossier blocks/ et renommer le si besoin le dossier en "uca_mycourses".

3. Aller sur la page de notifications pour finaliser l'installation du plugin.

4. Une fois l'installation terminée, plusieurs options d'administration sont à renseigner:

> Administration du site -> Plugins -> Blocs -> Bloc UCA "Mes cours" -> list_view_limit

Ce réglage permet de déterminer jusqu'à combien de cours, le bloc utilisera la "vue en liste". Ce paramétrage sera utilisé tant que l'utilisateur n'a pas renseigné de préférence pour l'affichage.

> Administration du site -> Plugins -> Blocs -> Bloc UCA "Mes cours" -> roles_to_exclude

Ce réglage permet de sélectionner les roles qui seront ignorés pour afficher les cours d'un utilisateur. Si l'utilisateur possède un de ces rôles dans un cours, ce cours ne sera pas affiché dans le bloc.

Usages
-----
1. Visualisation de la liste de mes cours dans un bloc selon 2 vues différentes (vue en liste ou vue en arbre).
2. Visualisation des cours que j'ai ajouté dans mes favoris. 
3. Gestion avancée de mes cours mis en favori (classement dans des dossiers, renommage, affichage dans le bloc, mise à jour en cas de suppression). 


A propos
------
<a href="https://www.uca.fr">Université Clermont Auvergne</a> - 2018.<br/>
