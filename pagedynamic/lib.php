<?php

defined('MOODLE_INTERNAL') || die;

	function local_pagedynamic_extend_navigation(global_navigation $navigation) {
	    global $CFG, $PAGE, $USER;
	    if(is_siteadmin()){
	        $nodesampleplugin = $navigation->add(get_string('pluginname', 'local_pagedynamic') );
	        $nodesampleplugin->add(get_string('list_pages', 'local_pagedynamic'), new moodle_url($CFG->wwwroot.'/local/pagedynamic/pages_list.php'));
		}
	}

	function getSlugURL($string){
		return strtolower(str_replace(' ', '-', $string));
	}

	function getCleanContent($content){
		return trim(str_replace("'", "`", $content));
	}
