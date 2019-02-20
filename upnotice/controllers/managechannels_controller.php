<?php
  class ManageChannelsController {
    public function index() {
      hasAccess(1);

      // for pagination
      $limit = 20;  
      if (isset($_GET["page"])) { $page  = $_GET["page"]; }
      else { $page=1; };  
      $start = ($page-1) * $limit;
      $pageLink = $this->makePagination($limit, $page);

      $channels = ChannelDetails::findByParentByLimit($start, $limit);

      $homeObj = new stdClass;
      $homeObj->title = 'Home';
      $homeObj->url = '?controller=pages&action=home';
      $homeObj->isActive = false;
      $pages[] = $homeObj;

      $channelObj = new stdClass;
      $channelObj->title = 'Manage Channels';
      $channelObj->url = '?controller=channels&action=managechannels';
      $channelObj->isActive = true;
      $pages[] = $channelObj;

      $breadcrumb = genBreadCrumb($pages);

      require_once('views/channels/managechannels.php');
    }

    public function edit() {
      hasAccess(1);

      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right channel
      $channel = Channel::find($_GET['id']);

      if(isset($_POST['submit'])){
        $channel = new Channel($channel->id, $_POST['name'], $channel->created_by);
        Channel::update($channel);
        return redirectCall('?controller=managechannels&action=index');
      }

      $homeObj = new stdClass;
      $homeObj->title = 'Home';
      $homeObj->url = '?controller=pages&action=home';
      $homeObj->isActive = false;
      $pages[] = $homeObj;

      $channelsObj = new stdClass;
      $channelsObj->title = 'Manage Channels';
      $channelsObj->url = '?controller=managechannels&action=index';
      $channelsObj->isActive = false;
      $pages[] = $channelsObj;

      $showObj = new stdClass;
      $showObj->title = 'Edit Channel';
      $showObj->url = '?controller=managechannels&action=index';
      $showObj->isActive = true;
      $pages[] = $showObj;

      $breadcrumb = genBreadCrumb($pages);

      require_once('views/channels/edit.php');
    }    

    public function delete() {
      hasAccess(1);

      if (!isset($_GET['id']))
        return call('pages', 'error');
      // we use the given id to get the right channel
      $channel = Channel::find($_GET['id']);

      Channel::delete($channel);
      return redirectCall('?controller=managechannels&action=index');
    }

    private function makePagination($limit, $defaultPage) {
      $channels = ChannelDetails::all();
      $pages = ceil(count($channels)/$limit);
      $pagLink = '';

      if($defaultPage > 1){
        $prev_page = $defaultPage-1;
        $pagLink .= '<li class="page-item"><a class="page-link" href="?controller=managechannels&action=index&page='.$prev_page.'">Previous</a></li>';  
      }

      for ($i=1; $i<=$pages; $i++) {  
        $active = '';
        if($defaultPage == $i)
          $active = 'active';

        $pagLink .= '<li class="page-item '.$active.'"><a class="page-link" href="?controller=managechannels&action=index&page='.$i.'">'.$i.'</a></li>';  
      };  

      if($defaultPage < $pages){
        $next_page = $defaultPage+1;
        $pagLink .=  '<li class="page-item"><a class="page-link" href="?controller=managechannels&action=index&page='.$next_page.'">Next</a></li>'; 
      }

      return $pagLink;
    }
  }
?>