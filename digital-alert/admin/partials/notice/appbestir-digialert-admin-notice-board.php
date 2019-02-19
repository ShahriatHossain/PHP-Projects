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
  $table_notice_vote = $wpdb->prefix . "digialert_notice_vote";

  $user_id = get_current_user_id();
  $channel_id = $_GET['id'];

  $channel_detail = $wpdb->get_results(
    $wpdb->prepare(
    "SELECT name, user_id as channel_user_id
    FROM $table_channel
    WHERE id = %s", $channel_id));

  $subscribe_detail = $wpdb->get_results(
    $wpdb->prepare(
    "SELECT user_id as channel_user_id
    FROM $table_subscribe
    WHERE channel_id = %s", $channel_id));

  $is_channel_owner = false;

  if(!empty($channel_detail)){
    if($channel_detail[0]->channel_user_id == $user_id){
      $is_channel_owner = true;
    }
  }

  $is_channel_subscriber = false;

  if(!empty($subscribe_detail)){
    if($subscribe_detail[0]->channel_user_id ==  $user_id){
      $is_channel_subscriber = true;
    }
  }

  if($_POST["unsubscribe"]){
    $channel_id = $_POST["channel_id"];
    $wpdb->query($wpdb->prepare("DELETE FROM $table_subscribe WHERE channel_id = %s AND user_id = %s ", $channel_id, $user_id));
  }

  if($_POST["noticeupvote"]){

    $notice_id = $_POST["notice_id"];
    $response = $_POST["response"];

    $wpdb->insert(
                $table_notice_vote, //table
                array(
                    'notice_id' => $notice_id, 
                    'user_id' => $user_id,
                    'response' => $response
                ), //data
                array('%s', '%s') //data format         
        );
  }

  if($_POST["noticedownvote"]){
    
    $notice_id = $_POST["notice_id"];
    $response = $_POST["response"];

    $wpdb->insert(
                $table_notice_vote, //table
                array(
                    'notice_id' => $notice_id, 
                    'user_id' => $user_id,
                    'response' => $response
                ), //data
                array('%s', '%s') //data format         
        );
  }
?>
<div class="container">
  <div class="row">&nbsp;</div>
  <?php if($is_channel_owner || $is_channel_subscriber){?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="pull-left"><?php echo $channel_detail[0]->name?></div>
        <div class="pull-right">
          <a href="<?php echo admin_url('admin.php?page=digialert_my_channels'); ?>" class="btn btn-primary btn-xs" role="button"><span class="glyphicon glyphicon-home"></span></a>
          <?php if($is_channel_owner){?><a href="<?php echo admin_url('admin.php?page=digialert_notice_create&channel_id='.$channel_id); ?>" class="btn btn-primary btn-xs" role="button"><span class="glyphicon glyphicon-plus"></span></a><?php }?>
          <?php if($is_channel_subscriber){?><a href="#" id="unsubscribe_channel_notice" class="btn btn-danger btn-xs" role="button"><span class="glyphicon glyphicon-remove"></span></a><?php }?>
        </div>
        <div class="clearfix">&nbsp;</div>
      </div>
      <div class="panel-body">
        <form method="post" id="noticeBoard" name="noticeBoard" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
          <input type="hidden" name="channel_id" value="<?php echo $channel_id?>">
          <input type='hidden' name="unsubscribe" value="unsubscribe">
        </form
         <div class="table-responsive"> 
          <table class="table table-striped">
            <tbody>
              <?php 
              $table_notice = $wpdb->prefix . "digialert_notice";

              $rows = $wpdb->get_results(
                $wpdb->prepare(
                  "SELECT *
                  FROM $table_notice
                  WHERE channel_id = %s", $channel_id));?>

                  <?php foreach ($rows as $row) {?>
                      <?php 
                        $notice_id = $row->id;
                        $table_notice_vote = $wpdb->prefix . "digialert_notice_vote";

                        $voting_result = $wpdb->get_results(
                          $wpdb->prepare(
                            "SELECT *
                            FROM $table_notice_vote
                            WHERE notice_id = %s AND user_id = %s", $notice_id, $user_id));

                        $is_vote_casted = false;

                        if(!empty($voting_result) && $voting_result[0]->notice_id > 0){
                          $is_vote_casted = true;
                        }
                        
                        $voting_last_date = date("d-M-y H:i:s", strtotime($row->voting_last_date));
                        $current_date = date("d-M-y H:i:s", time());

                        $is_voting_over = false;

                        if(strtotime($voting_last_date) < strtotime($current_date)){
                          $is_voting_over = true;
                        }
                      ?>
                      <tr>
                        <td>
                          <div class="row">
                            <div class="col-md-12"><?php echo $row->notice?></div>
                          </div>
                          <div>&nbsp;</div>
                          <div class="row">
                            <div class="col-md-10 text-danger">
                              <?php 
                              if($is_vote_casted){
                                echo'<a href="'.admin_url('admin.php?page=digialert_notice_voting_result&id='.$notice_id).'" class="text-danger">View Result</a>';
                              }
                              else if($is_voting_over){
                                echo' ';
                              }
                              else {
                                echo 'Last Voting Date -  '.date("d-M-y", strtotime($row->voting_last_date)); 
                              }
                              
                              ?>
                            </div>
                            <div class="col-md-2 text-success">
                              <?php 
                              if($is_vote_casted){
                                echo'vote casted';
                              }
                              else if($is_voting_over){
                                echo'voting over';
                              }
                              else {
                              ?>
                              <a href="#" id="notice_up_vote" style="margin-left:20px;" onClick="$(this).NoticeUpVote('<?php echo $row->id?>');" class="btn btn-success btn-xs" role="button" title="Up vote"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                              <a href="#" id="notice_down_vote" style="margin-left:10px;" onClick="$(this).NoticeDownVote('<?php echo $row->id?>');" class="btn btn-info btn-xs" role="button" title="Down vote"><span class="glyphicon glyphicon-thumbs-down"></span></a>

                              <form method="post" id="noticeBoardUpVote<?php echo $row->id?>" name="noticeBoardUpVote" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                <input type="hidden" name="notice_id" value="<?php echo $row->id?>" />
                                <input type="hidden" name="response" value="1" />
                                <input type='hidden' name="noticeupvote" value="noticeupvote" />
                              </form>

                              <form method="post" id="noticeBoardDownVote<?php echo $row->id?>" name="noticeBoardDownVote" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                <input type="hidden" name="notice_id" value="<?php echo $row->id?>" />
                                <input type="hidden" name="response" value="0" />
                                <input type='hidden' name="noticedownvote" value="noticedownvote" />
                              </form>
                              <?php }?>
                            </div>
                          </div>
                        </td>
                      </tr>
                  <?php }?>
            </tbody>
          </table>
        </div>
      </div>
      <?php } else {?>
        <div class="row">No record found</div>
      <?php }?>
    </div>
</div>
    