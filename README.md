Moodle UCA My Courses - Plugin and Block
==================================
Development made in order to intuitively display all user's courses in a Moodle block.
The block will need the local plugin which will contain all libs and fonctions needed to this display and also for course bookmarks management (feature not available in a basic Moodle).

Requirements
------------
- Moodle 3.3 (build 2017051500) or later.<br/>
-> Tests on Moodle 3.3 to 3.9 versions.<br/>
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

3. To use the plugin we needed to change some moodle core elements like update the schema of one of the database tables (see /db/install.php file) and update a function in the lib/moodlelib.php file because we use the mdl_user_preferences table to save our bookmarks.

> In function set_user_preference, the code fragment below must be deleted or at least in comment (it will throw an exception if the preference value length has more than 1333 characters):<br/>
```
// Value column maximum length is 1333 characters.
$value = (string)$value;
if (core_text::strlen($value) > 1333) {
    throw new coding_exception('Invalid value in set_user_preference() call, value is is too long for the value column');
}
```

4. Then visit your Admin Notifications page to complete the installation.

5. Once installed, you should see new administration options:

> Site administration -> Plugins -> Blocks -> My courses block -> list_view_limit

This option will decide since how many courses we display the "My courses" block on tree view and it will be used only if the user has not chosen a preference view yet.

> Site administration -> Plugins -> Blocks -> My courses block -> roles_to_exclude

This option will decide roles you want to exclude from the block. If users have this/these role(s) in a course it won't be visible in the block (and can not be bookmarked). 

Usages
-----
1. Display the list of your course in a block according 2 views (a tree view or a list view).
2. Display courses you chose to bookmark.
3. Advanced bookmarks management (filing in folders, renaming, display or not in the block, updates in cases of deletion).


About us
------
<a target="_blank" href="https://www.uca.fr">Université Clermont Auvergne</a> - 2020.
