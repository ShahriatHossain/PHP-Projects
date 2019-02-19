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
    $table_name = $wpdb->prefix . "digialert_channel";
    $id = $_GET["id"];
    $name = $_POST["name"];
    $short_name = $_POST["short_name"];
    $description = $_POST["description"];
    $status = $_POST["status"];
    $modified_date = current_time( 'mysql', true );

    //update
    if (isset($_POST['update'])) {
        $wpdb->update(
                $table_name, //table
                array(
                    'name' => $name, 
                    'short_name' => $short_name, 
                    'description' => $description, 
                    'status' => $status,
                    'modified_date' => $modified_date
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
        $channels = $wpdb->get_results($wpdb->prepare("SELECT id,name,short_name,description,status from $table_name where id=%s", $id));
        foreach ($channels as $c) {
            $name = $c->name;
            $short_name = $c->short_name;
            $description = $c->description;
            $status = $c->status;
        }
    }
    ?>
    <div class="container">
      <div class="row">&nbsp;</div>
    <div class="panel panel-default">
      <div class="panel-heading">Update Channel</div>
      <div class="panel-body">
    
    <div class="wrap">
        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Channel deleted</p></div>
            <a href="<?php echo admin_url('admin.php?page=digialert_channel_list') ?>">&laquo; Back to channel list</a>

        <?php } else if ($_POST['update']) { ?>
            <div class="updated"><p>Channel updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=digialert_channel_list') ?>">&laquo; Back to channel list</a>

        <?php } else { ?>
        <form class="form-horizontal" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label for="short_name" class="col-sm-2 control-label">Short Name</label>
            <div class="col-sm-10">
              <input type="text" name="short_name" value="<?php echo $short_name; ?>" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
              <textarea name="description" class="form-control" /><?php echo $description; ?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="status" class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10">
              <select name="status" class="form-control">
                <option value="1" <?php if($status == 1)echo'selected="selected"';?>>Approved</option>
                <option value="0" <?php if($status == 0)echo'selected="selected"';?>>Unapproved</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
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