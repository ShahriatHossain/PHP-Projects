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
$table_notice = $wpdb->prefix . "digialert_notice";
$table_notice_vote = $wpdb->prefix . "digialert_notice_vote";

$user_id = get_current_user_id();
$notice_id = $_GET['id'];

$notice_detail = $wpdb->get_results(
  $wpdb->prepare(
  "SELECT *
  FROM $table_notice
  WHERE id = %s", $notice_id));

$channel_id = $notice_detail[0]->channel_id;

$channel_detail = $wpdb->get_results(
  $wpdb->prepare(
  "SELECT *
  FROM $table_channel
  WHERE id = %s", $channel_id));

$notice_vote_detail = $wpdb->get_results(
  $wpdb->prepare(
  "SELECT COUNT(*) as total_vote, 
  SUM(if(response='1',1,0))as yes,
  SUM(if(response='0',1,0))AS no 
  FROM $table_notice_vote 
  WHERE notice_id = %s", $notice_id));

$total_yes_voted = $notice_vote_detail[0]->yes;
$total_no_voted = $notice_vote_detail[0]->no;
$total_not_voted = $notice_vote_detail[0]->total_vote - ($total_yes_voted + $total_no_voted);

?>

<div class="container">
  <div class="row">&nbsp;</div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="pull-left"><?php echo $channel_detail[0]->name;?></div>
        <div class="pull-right">
          <a href="<?php echo admin_url('admin.php?page=digialert_notice_board&id='.$channel_id); ?>" class="btn btn-primary btn-xs" role="button"><span class="glyphicon glyphicon-home"></span></a>
        </div>
        <div class="clearfix">&nbsp;</div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-8"><?php echo $notice_detail[0]->notice?></div>
          <div class="pull-right col-md-4">
            <div id="canvas-holder">
              <canvas id="chart-area" />
            </div>
          </div>
        </div>
        
         
      </div>
      
    </div>
</div>

<script>
    var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
    };
  
  var data = {
      labels: [
        "Not voted",
        "Yes",
        "No"
      ],
      datasets: [
        {
          data: [<?php echo $total_not_voted?>, <?php echo $total_yes_voted?>, <?php echo $total_no_voted?>],
          backgroundColor: [
            "#FF6384",
            "#36A2EB",
            "#FFCE56"
          ],
          hoverBackgroundColor: [
            "#FF6384",
            "#36A2EB",
            "#FFCE56"
          ]
        }]
    };

    var config = {
        type: 'pie',
        data: data,
        options: {
            responsive: true
        }
    };

    window.onload = function() {
        var ctx = document.getElementById("chart-area").getContext("2d");
        window.myPie = new Chart(ctx, config);
    };

    

    var colorNames = Object.keys(window.chartColors);
    
    </script>