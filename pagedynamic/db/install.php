<?php

/**
 * This file is used to make install time changes.
 * 
 * This file replaces the legacy STATEMENTS section in db/install.xml,
 * lib.php/modulename_install() post installation hook and partially defaults.php
 *
 * @package    local_pagedynamics
 * @copyright  www.fht.co.in 
 * @author     info@fht.co.in
 */

/**
 * Post installation procedure
 *
 * @see upgrade_plugins_modules()
 */
function xmldb_local_pagedynamic_install() {
    global $DB;
    return true;
}

/**
 * Post installation recovery procedure
 *
 * @see upgrade_plugins_modules()
 */
function xmldb_local_pagedynamic_install_recovery() {
}
