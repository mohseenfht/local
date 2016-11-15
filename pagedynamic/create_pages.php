<?php
require_once (dirname(dirname(dirname(__FILE__))).'/config.php');
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");
require_login();
//call to curl api
$strheading = get_string('create_page', 'local_pagedynamic');
$PAGE->set_pagelayout('standard');
$PAGE->set_context(context_system::instance());
$PAGE->set_title( $strheading );
$PAGE->navbar->add($strheading);

echo $OUTPUT->header();
if(!is_siteadmin()){
    $return_url = $CFG->wwwroot;
    redirect($return_url, $OUTPUT->notification("You are not valid user"));
}


if(isset($_POST['page_submit'])){

    global $CFG, $PAGE, $USER,$DB;   
    extract($_POST);

    $insert_data     =  new stdClass(); 
    $insert_data->page_title    =  $page_title;
    $insert_data->page_content  =  getCleanContent($page_content);
    $insert_data->page_slug     =  getSlugURL($page_title);
    $insert_data->page_status   =  $page_status; 
    $res= $DB->insert_record('cms_pages',$insert_data,true);
    
     if($res){
        $msg = "<span style='color:green'>Page Created </span>";
     }
     else{
      $msg = "<span style='color:red'>Unable to create page</span>";
     }
}

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
<form class="mform" id="mform1" accept-charset="utf-8" method="post" >
<div class="tab-content">
   <div id="mydropdown1" class="tab-pane fade in active">
          <!-- For English -->
          <fieldset id="id_supplyinfo" class="clearfix collapsible">
                 <div class="fitem required fitem_ftext " id="fitem_id_seats">
                      <div class="fitemtitle">
                        <label for="id_lastname">Page Title <span style="color:red;">*</span></label>
                      </div>
                        <div class="felement ftext">
                              <input type='text' name="page_title"  id='page_title' value="" required="" />
                        </div>
                 </div>
                <div class="fitem required fitem_ftext " id="fitem_id_seats">
                    <div class="fitemtitle">
                        <label for="page_content">Page Content <span style="color:red;">*</span> </label>
                    </div>
                    <div class="felement ftext">
                        <textarea id="page_content" spellcheck="true" cols="80" rows="15" name="page_content" class="ckeditor"  required=""  ></textarea>
                    </div>
                </div>
            </fieldset> 
          <!-- For English End -->
   </div>

   <fieldset class="hidden">
              <div class="fitem fitem_fselect " id="fitem_id_country">
                <div class="fitemtitle">
                    <label for="page_status">Status </label>
                </div>
                <div class="felement fselect">
                  <select id="page_status" name="page_status" required>
                      <option value="">---Select---</option>
                      <option value="1">Active</option>
                      <option value="0">Deactive</option>
                   
                  </select>
                </div>
              </div>
              <div>
                <div class="fitem fitem_actionbuttons fitem_fgroup" id="fgroup_id_buttonar">
                  <div class="felement fgroup">
                     <input type="submit" id="page_submit" value="Create Page" name="page_submit"> 
                     <input type="submit" id="id_cancel" class=" btn-cancel" onclick="skipClientValidation = true; return true;" value="Cancel" name="cancel">
                  </div>
                </div>
                <div class="fdescription required">There are required fields in this form marked <span style="color:red;">*</span>.</div>
              </div>
          </fieldset>
</div>       
</form>
<?php  echo $OUTPUT->footer(); ?>
<script src="//cdn.ckeditor.com/4.5.11/full/ckeditor.js"></script>
<script>
  CKEDITOR.replace('ckeditor');
</script>

						