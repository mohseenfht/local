<?php
require_once (dirname(dirname(dirname(__FILE__))).'/config.php');
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");
require_login();
//call to curl api
$strheading = get_string('edit_page', 'local_pagedynamic');
$PAGE->set_pagelayout('standard');
$PAGE->set_context(context_system::instance());
$PAGE->set_title( $strheading );
$PAGE->navbar->add($strheading);
echo $OUTPUT->header();

if(!is_siteadmin()){
    $return_url = $CFG->wwwroot;
    redirect($return_url, $OUTPUT->notification("You are not valid user"));
}

if(isset($_POST['page_update'])){
    extract($_POST);
    global $CFG, $PAGE, $USER,$DB;
    $id = trim($page_id);
    $update_data     =  new stdClass(); 
    $update_data->id       =  $page_id;
    $update_data->page_slug     =  getSlugURL($page_title);
    $update_data->page_title    =  getCleanContent($page_title);
    $update_data->page_conent   =  getCleanContent($page_content);
    $update_data->page_status   =  $page_status; 

    $res=$DB->update_record('cms_pages',$update_data,true);

    //$res  = $DB->get_records_sql("update {cms_pages} set `page_slug`='".getSlugURL($page_slug)."',`page_title`='".getCleanContent($page_title)."',`page_conent`='".getCleanContent($page_conent)."',`page_status`='".$page_status."'  where `page_id`=".$id);
   if($res){
      $msg = "<span style='color:green'>Page Updated </span>";
   }
   else{
    $msg = "<span style='color:red'>Unable to Update page</span>";
   }
}


$id = trim($_GET['id']);
global $CFG, $PAGE, $USER,$DB;
$pages  = $DB->get_records_sql("select * from {cms_pages} where id=" .$id);

?>

<div class="span12 col-md-9">
<?php 
if(isset($msg)){ ?>
<div class="alert alert-info demo">
  <?= $msg; ?>
</div>
<?php } ?>
</div>

<ul class="nav nav-tabs">
   <li class="active"><a href="#mydropdown1" data-toggle="tab">Dynamic Pages</a></li>
</ul>
<form class="mform" id="mform1" accept-charset="utf-8" method="POST" enctype="multipart/form-data" >
<div class="tab-content">
   <div id="mydropdown1" class="tab-pane fade in active">
          <fieldset id="id_supplyinfo" class="clearfix collapsible">
                  <div class="fitem required fitem_ftext " id="fitem_id_seats">
                    <div class="fitemtitle">
                      <label for="page_title">Page Title <span style="color:red;">*</span></label>
                    </div>
                    <div class="felement ftext">
                            <input type='text' name="page_title"  id='page_title' value="<?= $pages[$id]->page_title; ?>" required="" />
                            <input type='hidden' name="page_id"  id='page_id' value="<?= $pages[$id]->id; ?>" required="" />

                    </div>
                  </div>
                  <div class="fitem required fitem_ftext " id="fitem_id_seats">
                    <div class="fitemtitle">
                      <label for="id_lastname">Page Content<span style="color:red;">*</span> </label>
                    </div>
                    <div class="felement ftext">
                        <textarea id="page_content" spellcheck="true" cols="80" rows="15" name="page_content" class="ckeditor"  required=""  ><?= $pages[$id]->page_content; ?></textarea>
                    </div>
                  </div>
          </fieldset> 
    </div>
    <fieldset class="hidden">
              <div class="fitem fitem_fselect " id="fitem_id_country">
                <div class="page_status">
                    <label for="id_country">Page Status </label>
                </div>
                <div class="felement fselect">
                  <select id="page_status" name="page_status" required>
                      <option value="">---Select---</option>
                      <option value="1" <?php  if($pages[$id]->page_status == '1') { echo "selected=selected" ; }  ?> >Active</option>
                      <option value="0" <?php if($pages[$id]->page_status == '0') { echo "selected=selected" ; } ?> >Deactive</option>
                  </select>
                </div>
              </div>
              <div>
                <div class="fitem fitem_actionbuttons fitem_fgroup" id="fgroup_id_buttonar">
                  <div class="felement fgroup">
                     <input type="submit" id="page_update" value="Update Page" name="page_update"> 
                  </div>
                </div>
                <div class="fdescription required">There are required fields in this form marked <span style="color:red;">*</span>.</div>
              </div>
          </fieldset>
</div>       
</form>
<script src="//cdn.ckeditor.com/4.5.11/full/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'ckeditor' );
</script>
<?php  echo $OUTPUT->footer(); ?>

