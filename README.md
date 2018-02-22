Moodle UCA My Courses - Plugin and Block
==================================
Development made in order to intuitively display all user's courses in a Moodle block.
The block will need the local plugin which will contain all libs and fonctions needed to this display and also for course bookmarks management (feature not available in a basic Moodle).

Requirements
------------
- Moodle 3.3 (build 2017051500) or later.<br/>
-> Tests on Moodle 3.3 and 3.4 versions.<br/>
- Moodle <a href="https://github.com/andurif/moodle-block_uca_mycourses">UCA My Courses Block</a> (build 2018020801) to show plugin's informations.
- Bootstrap support in your moodle theme.
- JS Plugin Jstree => https://github.com/vakata/jstree (available in jstree/).

Installation
------------
1. Local plugin installation

- Git way:
> git clone https://github.com/andurif/moodle-local_uca_mycourses.git local/uca_mycourses

- Download way:
> Download the zip from <a href="https://github.com/andurif/moodle-local_uca_mycourses/archive/master.zip">https://github.com/andurif/moodle-local_uca_mycourses/archive/master.zip</a>, unzip it in local/ folder and rename it "uca_mycourses" if necessary.
  
2. Block installation

- Git way:
> git clone https://github.com/andurif/moodle-block_uca_mycourses.git blocks/uca_mycourses

- Download way:
> Download the zip from <a href="https://github.com/andurif/moodle-block_uca_mycourses/archive/master.zip">https://github.com/andurif/moodle-block_uca_mycourses/archive/master.zip</a>, unzip it in blocks/ folder and rename it "uca_mycourses" if necessary.

3. Then visit your Admin Notifications page to complete the installation.

4. Once installed, you should see new administration options:

> Site administration -> Plugins -> Blocks -> My courses block -> list_view_limit

This option will decide since how many courses we display the "My courses" block on tree view and it will be used only if the user has not chosen a preference view yet.

> Site administration -> Plugins -> Blocks -> My courses block -> roles_to_exclude

This option will decide roles you want to exclude from the block. If users have this/these role(s) in a course it won't be visible in the block. 

Usages
-----
1. Display the list of your course in a block according 2 views (a tree view or a list view).
2. Display courses you chose to bookmark.
3. Advanced bookmarks management (filing in folders, renaming, display or not in the block, updates in cases of deletion).


About us
------
<a href="https://www.uca.fr">Université Clermont Auvergne</a> - 2018.
