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
  $table_channel = $wpdb->prefix . "digialert_channel";
  $table_subscribe = $wpdb->prefix . "digialert_channel_subscribe";
  $user_id = get_current_user_id();

  //update
    if (isset($_POST['subscribe'])) {
        $channel_id = $_POST["channel_id"];
        $wpdb->insert(
                $table_subscribe, //table
                array(
                    'channel_id' => $channel_id, 
                    'user_id' => $user_id
                ), //data
                array('%s', '%s') //data format         
        );
        $message.="Channel subscribed successfully.";
    }
?>
<div class="container">
  <div class="row">&nbsp;</div>
    <div class="panel panel-default">
      <div class="panel-heading">
        Channel Search
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-6">
            <div class="input-group">
              <input id="search" type="text" class="form-control" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
              </span>
            </div><!-- /input-group -->
          </div><!-- /.col-lg-6 -->
        </div>
        <?php if (isset($_POST['subscribe'])) { ?>
            <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
            <a href="<?php echo admin_url('admin.php?page=digialert_my_channels') ?>">&laquo; Back to my channel list</a>
        <?php }?>
        <div class="row">&nbsp;</div>
        <ul class="list-group">
          <?php 
          $rows = $wpdb->get_results(
            "SELECT id, name
            FROM $table_channel 
            WHERE id NOT IN (SELECT channel_id FROM $table_subscribe)
            AND $table_channel.user_id!=$user_id");
          ?>
          <?php foreach ($rows as $row) {?>
            <li class="list-group-item"> 
              <form class="form-inline" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <label class="channelName pull-left"><?php echo $row->name?></label>
                <input type="hidden" name="channel_id" value="<?php echo $row->id?>">
                <input type='submit' name="subscribe" value='Subscribe It' class="pull-right btn btn-warning btn-xs" onclick="return confirm('Do you want to subscribe this channel?')">
              </form
            </li>
            <div class="clearfix">&nbsp;</div>
          <?php }?>
        </ul>
            
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <li>
              <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li>
              <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
</div>
    