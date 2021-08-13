Plugin et Bloc - UCA "Mes cours"
==================================
Projet ayant pour but de faire afficher de manière intuitive les cours suivis par un utilisateur dans un bloc Moodle. 
Le bloc est étroitement lié au plugin qui contiendra toutes les librairies et fonctions nécessaires à l'affichage du bloc ainsi qu'à la gestion de favoris (fonctionnalité non disponible dans le Moodle de base).

Pré-requis
------------
- Moodle en version 3.3 (build 2017051500) ou plus récente.<br/>
-> Tests effectués sur des versions 3.3 à 3.11.0.<br/>
- Bloc "<a href="https://github.com/andurif/moodle-block_uca_mycourses">UCA Mes Cours"</a> (build 2018020801) pour afficher les informations des favoris<br/>
- Thème qui supporte bootstrap.
- Plugin JS Jstree => https://github.com/vakata/jstree (joint dans le dossier jstree/)

Installation
------------
1. Installation du module

- Avec git:
> git clone https://github.com/andurif/moodle-local_uca_mycourses.git local/uca_mycourses

- Téléchargement:
> Télécharger le zip depuis <a href="https://github.com/andurif/moodle-local_uca_mycourses/archive/refs/heads/master.zip" target="_blank">https://github.com/andurif/moodle-local_uca_mycourses/archive/refs/heads/master.zip </a>, dézipper l'archive dans le dossier local/ et renommer le si besoin le dossier en "uca_mycourses".
  
2. Installation du bloc

- Avec git:
> git clone https://github.com/andurif/moodle-block_uca_mycourses.git blocks/uca_mycourses

- Téléchargement:
> Télécharger le zip depuis <a href="https://github.com/andurif/moodle-block_uca_mycourses/archive/refs/heads/master.zip" target="_blank">https://github.com/andurif/moodle-block_uca_mycourses/archive/refs/heads/master.zip </a>, dézipper l'archive dans le dossier blocks/ et renommer le si besoin le dossier en "uca_mycourses".

3. Pour l'utilisation du plugin nous avons été obligé de modifier quelques éléments du code du core de Moodle en modifiant la structure d'une des tables (cf. fichier /db/install.php) ainsi qu'une fonction dans le fichier lib/moodlelib.php. Nous utilisons la table mdl_user_preferences pour stocker les cours mis en favoris.

> Dans la fonction set_user_preference, la porttion de code suivante est à commenter ou à supprimer (cette portion lance une exception si la taille de la préférence est > 1333 caractères):<br/>
```
// Value column maximum length is 1333 characters.
$value = (string)$value;
if (core_text::strlen($value) > 1333) {
    throw new coding_exception('Invalid value in set_user_preference() call, value is is too long for the value column');
}
```

4. Aller sur la page de notifications pour finaliser l'installation du plugin.

5. Une fois l'installation terminée, plusieurs options d'administration sont à renseigner:

> Administration du site -> Plugins -> Blocs -> Bloc UCA "Mes cours" -> list_view_limit

Ce réglage permet de déterminer jusqu'à combien de cours, le bloc utilisera la "vue en liste". Ce paramétrage sera utilisé tant que l'utilisateur n'a pas renseigné de préférence pour l'affichage.

> Administration du site -> Plugins -> Blocs -> Bloc UCA "Mes cours" -> roles_to_exclude

Ce réglage permet de sélectionner les roles qui seront ignorés pour afficher les cours d'un utilisateur. Si l'utilisateur possède un de ces rôles dans un cours, ce cours ne sera pas affiché dans le bloc (et ne pourra pas être ajouté aux cours favoris le cas échéant).

Usages
-----
1. Visualisation de la liste de mes cours dans un bloc selon 2 vues différentes (vue en liste ou vue en arborescence).
2. Visualisation des cours que j'ai ajouté dans mes favoris. 
3. Gestion avancée de mes cours mis en favori (classement dans des dossiers, renommage, affichage dans le bloc, mise à jour en cas de suppression).
4. Option permettant d'afficher ou non les cours dont la date de fin a été atteinte.


A propos
------
<a target="_blank" href="https://www.uca.fr">Université Clermont Auvergne</a> - 2021.<br/>
