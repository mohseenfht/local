<?php


defined('MOODLE_INTERNAL') || die;

/**
 * vmchat module upgrade task
 *
 * @param int $oldversion the version we are upgrading from
 * @return bool always true
 */
function xmldb_local_pagedynamic_upgrade($oldversion) {
    global $CFG, $DB;
    $dbman = $DB->get_manager();
    return true;
}
