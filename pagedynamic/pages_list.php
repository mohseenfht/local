<?php
//error_reporting(0);
require_once (dirname(dirname(dirname(__FILE__))).'/config.php');
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");
require_login();
//call to curl api
$strheading = get_string('list_pages', 'local_pagedynamic');
$PAGE->set_pagelayout('standard');
$PAGE->set_context(context_system::instance());
$PAGE->set_title( $strheading );
$PAGE->navbar->add($strheading);
global $CFG, $PAGE, $USER,$DB;   
echo $OUTPUT->header();

if(isset($_GET['mode']) == 'delete' && isset($_GET['id']) ) {

  $id = trim($_GET['id']);
  $res = $DB->execute("DELETE FROM {cms_pages} WHERE id='".$id."'");
    
  if($res){
      $msg = "<h4>Page Deleted </h4>";
  }
  else{
    $msg = "<h4>Unable to Delete page</h4>";
  }
     
}
$pages  = $DB->get_records_sql("select * from {cms_pages}");
?>
<div class="span12 col-md-12">

<div class='span12 col-md-12' style='margin-bottom: 40px;'>
  <a href='<?= $CFG->wwwroot.'/local/pagedynamic/create_pages.php' ; ?>' class="btn btn-success pull-right"><i class="fa fa-list"></i> Add new page</a>
</div>
<br/><br/>

<?php 
if(isset($msg)){ ?>
<div class="alert alert-danger demo">
  <?= $msg; ?>
</div>
<?php } ?>
</div>

<?php
$i = 1;  
$table = new html_table();
$table->head = array('Sr No. ','Page Title', 'Slug / Link ', 'Status' ,'Action');  
foreach ($pages as $key => $page) { 
          $table->data[$key] = array($i , $page->page_title , $CFG->wwwroot .'/pages.php?view='.$page->page_slug , $page->page_status == 1 ? 'Active' : 'Inactive' , '<a href="'.$CFG->wwwroot.'/local/pagedynamic/edit_pages.php?id='.$page->id.'" >Edit </a> / <a href="'.$CFG->wwwroot.'/local/pagedynamic/pages_list.php?mode=delete&id='.$page->id.'" >Delete</a>'  );
 $i++ ;} 

echo html_writer::table($table);
 ?>

 <div class='span12 col-md-12' style='margin-top: 40px;'>
  <a href='<?= $CFG->wwwroot.'/local/pagedynamic/create_pages.php' ; ?>' class="btn btn-success pull-right"><i class="fa fa-list"></i> Add new page</a>
</div>


<?php  echo $OUTPUT->footer(); ?>

