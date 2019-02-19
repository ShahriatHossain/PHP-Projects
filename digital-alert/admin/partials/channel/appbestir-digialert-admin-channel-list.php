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
<div class="container">
  <div class="row">&nbsp;</div>
    <div class="panel panel-default">
      <div class="panel-heading">Channels</div>
      <div class="panel-body">
            <a class="btn btn-default" role="button" href="<?php echo admin_url('admin.php?page=digialert_channel_create'); ?>">Add New</a>
            <?php
            global $wpdb;
            $table_name = $wpdb->prefix . "digialert_channel";

            $rows = $wpdb->get_results("SELECT * from $table_name");
            ?>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Logo</th>
                  <th>Name</th>
                  <th>Short Name</th>
                  <th>Secure Pin</th>
                  <th>Created By</th>
                  <th>Description</th>
                  <th>Modified Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php 
                foreach ($rows as $row) { 
                  $user = get_user_by( 'id',  $row->user_id);
                  if(!empty($user))
                    $created_by = $user->user_login;
                ?>
                <tr>
                  <th scope="row"><?php echo $row->id; ?></th>
                  <td><?php echo $row->logo; ?></td>
                  <td><?php echo $row->name; ?></td>
                  <td><?php echo $row->short_name; ?></td>
                  <td><?php echo $row->secure_pin; ?></td>
                  <td><?php echo $created_by; ?></td>
                  <td><?php echo $row->description; ?></td>
                  <td><?php echo $row->modified_date; ?></td>
                  <td><a href="<?php echo admin_url('admin.php?page=digialert_channel_update&id=' . $row->id); ?>"><?php if($row->status) echo "Approved"; else echo "Unapproved"; ?></a></td>
                  <td><a href="<?php echo admin_url('admin.php?page=digialert_channel_update&id=' . $row->id); ?>">Update</a></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
      </div>
    </div>
</div>
    