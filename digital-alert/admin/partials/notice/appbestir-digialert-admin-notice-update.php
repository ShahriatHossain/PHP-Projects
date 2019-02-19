<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Appbestir_Digialert
 * @subpackage Appbestir_Digialert/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php 
global $wpdb;
    $table_name = $wpdb->prefix . "digialert_notice";
    $id = $_GET["id"];
    $notice_type = $_POST["notice_type"];
    $is_voting_enabled = empty($_POST["is_voting_enabled"])? 0 : $_POST["is_voting_enabled"];;
    $channel_id = $_POST["channel_id"];

    if(isset($_POST["voting_last_date"]) && !empty($_POST["voting_last_date"])) {
      $voting_last_date = $_POST["voting_last_date"];
    }
    else { 
      $voting_last_date = date("Y-m-d");
    }

    switch ($notice_type) {
      case 'text':
          $notice = $_POST["notice"];
          $file_display_name = '';
        break;
      
      case 'image':
          $upload = wp_upload_bits($_FILES["image"]["name"], null, file_get_contents($_FILES["image"]["tmp_name"]));
          $notice = $upload['url'];
          $file_display_name = $_FILES["image"]["name"];
        break;

        case 'pdf':
          $upload = wp_upload_bits($_FILES["pdf"]["name"], null, file_get_contents($_FILES["pdf"]["tmp_name"]));
          $notice = $upload['url'];
          $file_display_name = $_FILES["pdf"]["name"];
        break;
    }

    //update
    if (isset($_POST['update'])) {
        $wpdb->update(
                $table_name, //table
                array(
                    'notice' => $notice, 
                    'notice_type' => $notice_type,
                    'file_display_name' => $file_display_name,
                    'is_voting_enabled' => $is_voting_enabled, 
                    'channel_id' => $channel_id, 
                    'voting_last_date' => $voting_last_date.' 23:59:59'
                ),//data
                array('ID' => $id), //where
                array('%s'), //data format
                array('%s') //where format
        );
    }
//delete
    else if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %s", $id));
    } else {//selecting value to update 
        $notices = $wpdb->get_results($wpdb->prepare("SELECT * from $table_name where id=%s", $id));
        foreach ($notices as $n) {
            $notice = $n->notice;
            $notice_type = $n->notice_type;
            $file_display_name = $n->file_display_name;
            $is_voting_enabled = $n->is_voting_enabled;
            $channel_id = $n->channel_id;
            $voting_last_date = $n->voting_last_date;
        }
    }
    ?>
    <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">Update Notice</div>
      <div class="panel-body">
    <div class="wrap">

        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Notice deleted</p></div>
            <a href="<?php echo admin_url('admin.php?page=digialert_notice_list') ?>">&laquo; Back to notice list</a>

        <?php } else if ($_POST['update']) { ?>
            <div class="updated"><p>Notice updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=digialert_notice_list') ?>">&laquo; Back to notice list</a>

        <?php } else { ?>
            <form class="form-horizontal" id="create_notice_section" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
          <div class="form-group">
            <label for="notice_type" class="col-sm-2 control-label">Notice Type</label>
            <div class="col-sm-10">
                <label class="radio-inline">
                  <input type="radio" name="notice_type" id="notice_typ1" value="text" <?php if($notice_type=='text') echo'checked="checked"'; ?>> Text
                </label>
                <label class="radio-inline">
                  <input type="radio" name="notice_type" id="notice_typ2" value="image" <?php if($notice_type=='image') echo'checked="checked"'; ?>> Image
                </label>
                <label class="radio-inline">
                  <input type="radio" name="notice_type" id="notice_typ3" value="pdf" <?php if($notice_type=='pdf') echo'checked="checked"'; ?>> Pdf
                </label>
            </div>
          </div>
          <div class="form-group" id="notice_text" style="display:none;">
            <label for="notice" class="col-sm-2 control-label">Notice</label>
            <div class="col-sm-10">
              <textarea name="notice" class="form-control" rows="3"><?php echo $notice; ?></textarea>
            </div>
          </div>
          <div class="form-group" id="notice_image" style="display:none;">
            <label for="image" class="col-sm-2 control-label">Image</label>
            <div class="col-sm-10">
              <input type="file" name="image" id="image"><?php if($notice_type=='image') echo $file_display_name; ?>
            </div>
          </div>
          <div class="form-group" id="notice_pdf" style="display:none;">
            <label for="pdf" class="col-sm-2 control-label">Pdf</label>
            <div class="col-sm-10">
              <input type="file" name="pdf" id="pdf"><?php if($notice_type=='pdf') echo $file_display_name; ?>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="is_voting_enabled" id="is_voting_enabled" value="<?php echo $is_voting_enabled;?>" <?php if($is_voting_enabled)echo'checked="checked"';?>> Enable voting?
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="pdf" class="col-sm-2 control-label">Last voting date</label>
            <div class="col-sm-10">
              <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                  <input type="text" name="voting_last_date" id="voting_last_date" value="<?php echo $voting_last_date;?>" class="form-control"  disabled>
                  <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                  </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name="channel_id" value="<?php echo $channel_id;?>"  />
              <input type='submit' name="update" value='Save' class="btn btn-primary"> &nbsp;&nbsp;
              <input type='submit' name="delete" value='Delete' class="btn btn-primary" onclick="return confirm('Do you want to delete this item?')">
            </div>
          </div>
        </form>
        <?php } ?>

    </div>


    </div>
    </div>
</div>