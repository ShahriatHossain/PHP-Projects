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
    <div class="panel panel-default">
      <div class="panel-heading">Notices</div>
      <div class="panel-body">
            <a class="btn btn-default" role="button" href="<?php echo admin_url('admin.php?page=digialert_notice_create'); ?>">Add New</a>
            <?php
            global $wpdb;
            $table_name = $wpdb->prefix . "digialert_notice";

            $rows = $wpdb->get_results("SELECT * from $table_name");
            ?>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Voting Enabled?</th>
                  <th>Channel</th>
                  <th>Notice</th>
                  <th>Notice Type</th>
                  <th>Voting Last Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($rows as $row) { ?>
                <tr>
                  <th scope="row"><?php echo $row->id; ?></th>
                  <td><?php if($row->is_voting_enabled) echo'Yes';else echo'No'; ?></td>
                  <td><?php echo $row->channel_id; ?></td>
                  <td><?php echo $row->notice; ?></td>
                  <td><?php echo $row->notice_type; ?></td>
                  <td><?php echo $row->voting_last_date; ?></td>
                  <td><a href="<?php echo admin_url('admin.php?page=digialert_notice_update&id=' . $row->id); ?>">Update</a></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
      </div>
    </div>
</div>
    