<?php

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    // New settings page
    $page = new admin_settingpage(get_string('pluginname', 'local_pagedynamic'), get_string('pluginname', 'local_pagedynamic'));
    // Document directory
   
    $ADMIN->add('localplugins', $page);
}
?>