<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Plugin lang file: French.
 *
 * @package    local_uca_mycourses
 * @author     Université Clermont Auvergne - Pierre Raynaud, Anthony Durif
 * @copyright  2018 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//======================================================================
// TRADUCTIONS PARTIE COURS
//======================================================================
$string['pluginname'] = 'Plugin local "Mes Cours"';
$string['my_courses_all'] = 'Tous mes cours';
$string['my_courses_bookmarks'] = 'Mes cours mis en favori';

//======================================================================
// TRADUCTIONS GESTION DES FAVORIS
//======================================================================
$string['uca_mycourses:manage_bookmarks'] = 'Gérer ma liste de cours favoris';
$string['bookmarks_pluginname'] = 'Mes favoris';
$string['bookmarks_root_folder'] = 'Mes favoris';
$string['bookmarks_manage'] = 'Gérer mes favoris';
$string['bookmarks_add'] = 'Ajouter le(s) cours à mes favoris';
$string['bookmarks_add_folder'] = 'Créer un dossier';
$string['bookmarks_new_folder'] = 'Nouveau dossier';
$string['bookmarks_delete'] = 'Supprimer de mes favoris';
$string['bookmarks_delete_folder'] = 'Supprimer le dossier';
$string['bookmarks_my_courses'] = 'Cours auxquels je suis inscrit';
$string['bookmarks_no_course'] = 'Vous n\'êtes inscrit à aucun cours.';
$string['bookmarks_list'] = 'Cours mis en favoris';
$string['bookmarks_info'] = 'Les changements sur vos favoris ne seront pas pris en compte tant que vous ne les avez pas validés.';
$string['bookmarks_confirm'] = 'Valider les favoris ?';
$string['bookmarks_validation'] = 'Validation des favoris';
$string['bookmarks_validation_ok'] = 'Liste des favoris mise à jour.';
$string['bookmarks_show_in_block'] = 'Afficher mes cours mis en favoris sur le bloc "Mes cours"';
$string['bookmarks_access_course'] = 'Accéder à ce cours';

//======================================================================
// TRADUCTIONS TACHES PROGRAMMEES
//======================================================================
$string['taskcleanuplocallogs'] = 'Nettoyage spécifique des logs standards et talend liés à la synchronisation quotidienne';
$string['cleanbookmarks'] = 'Nettoyage des préférences "Mes favoris"';
$string['cleanbookmarks_delete'] = 'Suppression du cours de la liste des favoris.';
$string['cleanbookmarks_update'] = 'Mise à jour de la préférence utilisateur.';

//======================================================================
// TRADUCTIONS RGPD
//======================================================================
$string['privacy:metadata:preference:bookmarksshow'] = 'Ce plugin enregistre si l\'utilisateur a choisi de faire afficher ou non ses cours mis en favoris sur le bloc "Mes cours".';
$string['privacy:bookmarksshow:yes'] = 'L\'utilisateur fait afficher ses cours mis en favoris.';
$string['privacy:bookmarksshow:no'] = 'L\'utilisateur ne fait pas afficher ses cours mis en favoris.';
$string['privacy:metadata:preference:bookmarkslist'] = 'Ce plugin enregistre la liste des cours mis en favoris par l\'utilisateur sous la forme d\'une chaîne de caractère au format json.';
$string['privacy:bookmarkslist'] = 'Liste des cours mis en favoris par l\'utilisateur (attention chaîne au format json) : <br/><pre>{$a->json}</pre>';