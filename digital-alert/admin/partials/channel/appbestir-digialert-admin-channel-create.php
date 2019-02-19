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


    $name = $_POST["name"];
    $short_name = $_POST["short_name"];
    $description = $_POST["description"];
    $user_id = get_current_user_id();
    $modified_date = current_time( 'mysql', true );

    //insert
    if (isset($_POST['insert'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . "digialert_channel";

        $wpdb->insert(
                $table_name, //table
                array(
                    'name' => $name, 
                    'short_name' => $short_name, 
                    'description' => $description, 
                    'user_id' => $user_id,
                    'modified_date' => $modified_date
                ), //data
                array('%s', '%s') //data format         
        );
        $message.="New channel created";
    }
    ?>
    <div class="container">
      <div class="row">&nbsp;</div>
      <div class="panel panel-default">
        <div class="panel-heading">Add New Channel</div>
        <div class="panel-body">
        <?php if (isset($_POST['insert'])) { ?>
            <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
            <a href="<?php echo admin_url('admin.php?page=digialert_my_channels') ?>">&laquo; Back to my channel list</a>
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
              <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" name="insert" value="Save" class="btn btn-primary">
              </div>
            </div>
          </form>
          <?php } ?>
        </div>
      </div>
</div>
    
