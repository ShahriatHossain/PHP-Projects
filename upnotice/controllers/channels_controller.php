<?php
  class ChannelsController {
    public function index() {
      hasLoggedIn();

      $ownChannels = Channel::findByCreator($_SESSION["loggedInUserId"]);
      $subscribedChannels = Channel::findBySubscriber($_SESSION["loggedInUserId"]);
      $remainChannels = Channel::findByNotSubscribedOrOwned($_SESSION["loggedInUserId"]);

      $homeObj = new stdClass;
      $homeObj->title = 'Home';
      $homeObj->url = '?controller=pages&action=home';
      $homeObj->isActive = false;
      $pages[] = $homeObj;

      $channelObj = new stdClass;
      $channelObj->title = 'Channels';
      $channelObj->url = '?controller=channels&action=index';
      $channelObj->isActive = true;
      $pages[] = $channelObj;

      $breadcrumb = genBreadCrumb($pages);

      require_once('views/channels/index.php');
    }

    public function getsubscribedchannels() {
      hasLoggedIn();

      $subscribedChannels = Channel::findBySubscriber($_SESSION["loggedInUserId"]);
      echo json_encode($subscribedChannels) ;
    }

    public function show() {
      hasLoggedIn();

      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right channel
      $channel = Channel::find($_GET['id']);
      $isChannelOwner = ($channel->created_by == intval($_SESSION["loggedInUserId"]));

      // for pagination
      $limit = 6;  
      if (isset($_GET["page"])) { $page  = $_GET["page"]; }
      else { $page=1; };  
      $start = ($page-1) * $limit;
      $pageLink = $this->makePagination($limit, $page);

      $notices = NoticeDetails::findByParentByLimit($_GET['id'], $start, $limit);

      $homeObj = new stdClass;
      $homeObj->title = 'Home';
      $homeObj->url = '?controller=pages&action=home';
      $homeObj->isActive = false;
      $pages[] = $homeObj;

      $channelsObj = new stdClass;
      $channelsObj->title = 'Channels';
      $channelsObj->url = '?controller=channels&action=index';
      $channelsObj->isActive = false;
      $pages[] = $channelsObj;

      $showObj = new stdClass;
      $showObj->title = 'Notice List';
      $showObj->url = '?controller=channels&action=show&id='.$_GET['id'];
      $showObj->isActive = true;
      $pages[] = $showObj;

      $breadcrumb = genBreadCrumb($pages);

      require_once('views/channels/show.php');
    }

    private function makePagination($limit, $defaultPage) {
      $notices = NoticeDetails::findByParent($_GET['id']);
      $pages = ceil(count($notices)/$limit);
      $pagLink = '';

      if($defaultPage > 1){
        $prev_page = $defaultPage-1;
        $pagLink .= '<li class="page-item"><a class="page-link" href="?controller=channels&action=show&id='.$_GET['id'].'&page='.$prev_page.'">Previous</a></li>';  
      }

      for ($i=1; $i<=$pages; $i++) {  
        $active = '';
        if($defaultPage == $i)
          $active = 'active';

        $pagLink .= '<li class="page-item '.$active.'"><a class="page-link" href="?controller=channels&action=show&id='.$_GET['id'].'&page='.$i.'">'.$i.'</a></li>';  
      };  

      if($defaultPage < $pages){
        $next_page = $defaultPage+1;
        $pagLink .=  '<li class="page-item"><a class="page-link" href="?controller=channels&action=show&id='.$_GET['id'].'&page='.$next_page.'">Next</a></li>'; 
      }

      return $pagLink;
    }

    public function subscribe() {
      hasLoggedIn();

      if (!isset($_GET['id']))
        return call('pages', 'error');

      Channel::subscribe($_GET['id'], $_SESSION["loggedInUserId"]);

      return redirectCall('?controller=channels&action=index');
    }

    public function post() {
      hasLoggedIn();

      if(isset($_POST['submit'])){
        $channel = new Channel(0, $_POST['name'], $_SESSION["loggedInUserId"]);
        Channel::save($channel);

        return redirectCall('?controller=channels&action=index');
      }
    }

    public function postnotice() {
      hasLoggedIn();

      if(isset($_POST['submit'])){
        if (!isset($_GET['id']))
        return call('pages', 'error');

        $notice = new Notice(0, $_GET['id'], $_POST['notice'], $_POST['description'], '', '', date("Y-m-d H:i:s"));
        Notice::save($notice);
        $this->sendNotification($notice, $_GET['id']);

        return redirectCall('?controller=channels&action=show&id='.$_GET['id']);
      }
    }

    public function postvoting() {
      hasLoggedIn();

      if (!isset($_GET['nid']))
        return call('pages', 'error');

        $voting = new Voting(0, $_GET['nid'], $_SESSION["loggedInUserId"], $_GET['status']);
        Voting::save($voting);

        if (isset($_GET["page"])) { $page  = $_GET["page"]; }
        else { $page=1; }; 
        
        return redirectCall('?controller=channels&action=show&id='.$_GET['cid'].'&page='.$page);
    }

    public function noticedetails() {
      hasLoggedIn();

      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right notice
      $notice = NoticeDetails::find($_GET['id']);
      $response = Voting::countResponseByParent($_GET['id']);

      $homeObj = new stdClass;
      $homeObj->title = 'Home';
      $homeObj->url = '?controller=pages&action=home';
      $homeObj->isActive = false;
      $pages[] = $homeObj;

      $channelsObj = new stdClass;
      $channelsObj->title = 'Channels';
      $channelsObj->url = '?controller=channels&action=index';
      $channelsObj->isActive = false;
      $pages[] = $channelsObj;

      $showObj = new stdClass;
      $showObj->title = 'Notice List';
      $showObj->url = '?controller=channels&action=show&id='.$notice->channel_id;
      $showObj->isActive = false;
      $pages[] = $showObj;

      $noticeObj = new stdClass;
      $noticeObj->title = 'Notice Details';
      $noticeObj->url = '?controller=channels&action=noticedetails';
      $noticeObj->isActive = true;
      $pages[] = $noticeObj;

      $breadcrumb = genBreadCrumb($pages);

      require_once('views/channels/noticedetails.php');
    }

    private function sendNotification(Notice $notice, $channelId) {
      hasLoggedIn();

      $users = User::findSubscribers($channelId);
      $channel = Channel::find($channelId);

      foreach ($users as $user) {
        $to      = $user->email;
        $subject = 'A new notice has been posted to channel: <a href="?controller=channels&action=show&id='.$channel->id.'">'. $channel->name.'</a>';

        sendHtmlEmail($notice->title, $notice->description, $to, $subject);
      }

      $this->pusherNotification($channelId, $subject);
      
    }

    private function pusherNotification($channelId, $msg) {
      require './vendor/autoload.php';

      $options = array(
      'cluster' => 'mt1',
      'encrypted' => true
      );
      $pusher = new Pusher\Pusher(
      'e1965aad1a0ab55dead4',
      'cce2e0b9601641e19f02',
      '450629',
      $options
      );

      $data['message'] = $msg;
      $pusher->trigger($channelId, 'notice-event', $data);
    }
    
  }
?>