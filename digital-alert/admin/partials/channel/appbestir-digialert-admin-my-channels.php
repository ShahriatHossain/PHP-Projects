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

  if($_POST["unsubscribe"]){
    $channel_id = $_POST["channel_id"];
    $wpdb->query($wpdb->prepare("DELETE FROM $table_subscribe WHERE channel_id = %s AND user_id = %s ", $channel_id, $user_id));
  }

  $page = $_GET['p'];
  $limit = 10;

  if($page == '')
  {
    $page = 1;
    $start = 0;
  }
  else
  {
    $start = $limit*($page-1);
  }

?>
<div class="container">
  <div class="row">&nbsp;</div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="pull-left">My Channels</div>
        <div class="pull-right">
          <a href="<?php echo admin_url('admin.php?page=digialert_channel_create'); ?>" class="btn btn-primary btn-xs" role="button"><span class="glyphicon glyphicon-plus"></span></a>
          <a href="<?php echo admin_url('admin.php?page=digialert_channel_search'); ?>" class="btn btn-primary btn-xs" role="button"><span class="glyphicon glyphicon-search"></span></a>
        </div>
        <div class="clearfix">&nbsp;</div>
      </div>
      <div class="panel-body">
            <div>

              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab">All</a></li>
                <li role="presentation"><a href="#subscribedChannel" aria-controls="subscribedChannel" role="tab" data-toggle="tab">Subscribed</a></li>
                <li role="presentation"><a href="#approvedChannel" aria-controls="approvedChannel" role="tab" data-toggle="tab">Approved</a></li>
                <li role="presentation"><a href="#pendingChannel" aria-controls="pendingChannel" role="tab" data-toggle="tab">Pending</a></li>
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <!-- All -->
                <div role="tabpanel" class="tab-pane fade in active" id="all">
                  <br>
                  <ul class="list-group">
                    <?php 
                      $tots = $wpdb->get_results(
                        "SELECT id, name, status, $table_channel.user_id as channel_user_id
                         FROM $table_channel
                         LEFT JOIN $table_subscribe
                         ON $table_channel.id=$table_subscribe.channel_id
                         WHERE ($table_channel.user_id=$user_id || $table_subscribe.user_id=$user_id)
                         AND ($table_channel.status!=0 || $table_channel.user_id!=$user_id)");

                      $total = count($tots);

                      $num_page = ceil($total/$limit);

                      $rows = $wpdb->get_results(
                        "SELECT id, name, status, $table_channel.user_id as channel_user_id
                         FROM $table_channel
                         LEFT JOIN $table_subscribe
                         ON $table_channel.id=$table_subscribe.channel_id
                         WHERE ($table_channel.user_id=$user_id || $table_subscribe.user_id=$user_id)
                         AND ($table_channel.status!=0 || $table_channel.user_id!=$user_id)
                         ORDER BY $table_channel.id
                         LIMIT $start, $limit");
                    ?>
                    <?php foreach ($rows as $row) {?>
                    <li class="list-group-item">
                      <a href="<?php echo admin_url('admin.php?page=digialert_notice_board&id=' . $row->id); ?>"><?php echo $row->name?></a>
                    </li>
                    <?php }?>
                  </ul>
                  <?php 
                  if($num_page>1)
                  {
                    pagination($page, $num_page, admin_url('admin.php?page=digialert_my_channels'), '#all');
                  }
                  ?>
                </div>
                
                <!-- Subscribed -->
                <div role="tabpanel" class="tab-pane fade in" id="subscribedChannel">
                  <br>
                  <ul class="list-group">
                    <?php 
                      $tots = $wpdb->get_results(
                        "SELECT id, name
                         FROM $table_channel
                         INNER JOIN $table_subscribe
                         ON $table_channel.id=$table_subscribe.channel_id
                         WHERE $table_subscribe.user_id=$user_id");

                      $total = count($tots);

                      $num_page = ceil($total/$limit);

                      $rows = $wpdb->get_results(
                        "SELECT id, name
                         FROM $table_channel
                         INNER JOIN $table_subscribe
                         ON $table_channel.id=$table_subscribe.channel_id
                         WHERE $table_subscribe.user_id=$user_id
                         ORDER BY $table_channel.id
                         LIMIT $start, $limit");
                    ?>
                    <?php foreach ($rows as $row) {?>
                    
                      <li class="list-group-item">
                        <form class="form-inline" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        <a class="pull-left" href="<?php echo admin_url('admin.php?page=digialert_notice_board&id=' . $row->id); ?>"><?php echo $row->name?></a>
                        <input type="hidden" name="channel_id" value="<?php echo $row->id?>">
                        <input type='submit' name="unsubscribe" value='Unsubscribe It' class="pull-right btn btn-warning btn-xs" onclick="return confirm('Do you want to unsubscribe this channel?')">
                      </form
                    </li>
                    <div class="clearfix">&nbsp;</div>
                    <?php }?>
                  </ul>
                  <?php 
                  if($num_page>1)
                  {
                    pagination($page, $num_page, admin_url('admin.php?page=digialert_my_channels'), '#subscribedChannel');
                  }
                  ?>
                </div>
                <!-- Approved -->
                <div role="tabpanel" class="tab-pane fade in" id="approvedChannel">
                  <br>
                  <ul class="list-group">
                    <?php 
                      $tots = $wpdb->get_results(
                        "SELECT id, name
                         FROM $table_channel
                         LEFT JOIN $table_subscribe
                         ON $table_channel.id=$table_subscribe.channel_id
                         WHERE $table_channel.user_id=$user_id AND $table_channel.status=1");

                      $total = count($tots);

                      $num_page = ceil($total/$limit);

                      $rows = $wpdb->get_results(
                        "SELECT id, name
                         FROM $table_channel
                         LEFT JOIN $table_subscribe
                         ON $table_channel.id=$table_subscribe.channel_id
                         WHERE $table_channel.user_id=$user_id AND $table_channel.status=1
                         ORDER BY $table_channel.id
                         LIMIT $start, $limit");
                    ?>
                    <?php foreach ($rows as $row) {?>
                    <li class="list-group-item">
                      <a href="<?php echo admin_url('admin.php?page=digialert_channel_update&id=' . $row->id); ?>"><?php echo $row->name?></a>
                    </li>
                    <?php }?>
                  </ul>
                  <?php 
                  if($num_page>1)
                  {
                    pagination($page, $num_page, admin_url('admin.php?page=digialert_my_channels'), '#approvedChannel');
                  }
                  ?>
                </div>
                <!-- Pending -->
                <div role="tabpanel" class="tab-pane fade in" id="pendingChannel">
                  <br>
                  <ul class="list-group">
                    <?php 
                      $tots = $wpdb->get_results(
                        "SELECT id, name
                         FROM $table_channel
                         LEFT JOIN $table_subscribe
                         ON $table_channel.id=$table_subscribe.channel_id
                         WHERE $table_channel.user_id=$user_id AND $table_channel.status=0");

                      $total = count($tots);

                      $num_page = ceil($total/$limit);

                      $rows = $wpdb->get_results(
                        "SELECT id, name
                         FROM $table_channel
                         LEFT JOIN $table_subscribe
                         ON $table_channel.id=$table_subscribe.channel_id
                         WHERE $table_channel.user_id=$user_id AND $table_channel.status=0
                         ORDER BY $table_channel.id
                         LIMIT $start, $limit");
                    ?>
                    <?php foreach ($rows as $row) {?>
                    <li class="list-group-item">
                      <a href="<?php echo admin_url('admin.php?page=digialert_channel_update&id=' . $row->id); ?>"><?php echo $row->name?></a>
                    </li>
                    <?php }?>
                  </ul>
                  <?php 
                  if($num_page>1)
                  {
                    pagination($page, $num_page, admin_url('admin.php?page=digialert_my_channels'), '#pendingChannel');
                  }
                  ?>
                </div>
              </div>

              <?php 
              function pagination($page, $num_page, $url, $tab) {
                echo'<nav aria-label="Page navigation">
                  <ul class="pagination">';
                  if($page > 1){
                    $prev = $page-1;
                    echo '<li>
                      <a href="'.$url.'&p='.$prev.''.$tab.'" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>';
                    }
                    else{
                      echo '<li class="disabled">
                        <a href="#" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                        </a>
                      </li>';
                    } 

                  for($i=1; $i <= $num_page; $i++)
                  {
                     if($i == $page)
                      {
                        echo'<li class="active"><a href="#">'.$i.'</a></li>';
                      }
                      else
                      {
                        echo'<li><a href="'.$url.'&p='.$i.''.$tab.'">'.$i.'</a></li>';
                      }
                  }

                  if($page < $num_page){
                    $next = $page+1;
                    echo '<li>
                        <a href="'.$url.'&p='.$next.''.$tab.'" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                        </a>
                      </li>';
                  }
                  else {
                    echo '<li class="disabled">
                        <a href="#" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                        </a>
                      </li>';
                  }

                  echo'</ul></nav>';
              }
              ?>

            </div>
      </div>
    </div>
</div>
    