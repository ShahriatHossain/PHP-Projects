<?php
  class ManageNoticesController {
    public function index() {
      hasAccess(1);

      if (!isset($_GET['cid']))
        return call('pages', 'error');

      // we use the given id to get the right channel
      $channel = Channel::find($_GET['cid']);
      
      // for pagination
      $limit = 20;  
      if (isset($_GET["page"])) { $page  = $_GET["page"]; }
      else { $page=1; };  
      $start = ($page-1) * $limit;
      $pageLink = $this->makePagination($limit, $page);

      $notices = NoticeDetails::findByParentByLimit($_GET['cid'], $start, $limit);

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
      $showObj->title = 'Notice List';
      $showObj->url = '?controller=managenotices&action=index&cid='.$_GET['cid'];
      $showObj->isActive = true;
      $pages[] = $showObj;

      $breadcrumb = genBreadCrumb($pages);

      require_once('views/notices/index.php');
    }

    public function edit() {
      hasAccess(1);

      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right channel
      $notice = Notice::find($_GET['id']);

      if(isset($_POST['submit'])){
        $notice = new Notice($notice->id, $notice->channel_id, $_POST['notice'], $_POST['description'], $notice->filename, $notice->file_displayname, $channel->created_by);
        Notice::update($notice);
        return redirectCall('?controller=managenotices&action=index&cid='.$notice->channel_id);
      }

      $homeObj = new stdClass;
      $homeObj->title = 'Home';
      $homeObj->url = '?controller=pages&action=home';
      $homeObj->isActive = false;
      $pages[] = $homeObj;

      $channelsObj = new stdClass;
      $channelsObj->title = 'Manage Notices';
      $channelsObj->url = '?controller=managenotices&action=index&cid='.$notice->channel_id;
      $channelsObj->isActive = false;
      $pages[] = $channelsObj;

      $noticeObj = new stdClass;
      $noticeObj->title = 'Edit Notice';
      $noticeObj->url = '?controller=managenotices&action=edit&id='.$notice->id;
      $noticeObj->isActive = true;
      $pages[] = $noticeObj;

      $breadcrumb = genBreadCrumb($pages);

      require_once('views/notices/edit.php');
    }    

    public function delete() {
      hasAccess(1);
      
      if (!isset($_GET['id']))
        return call('pages', 'error');
      // we use the given id to get the right channel
      $notice = Notice::find($_GET['id']);

      Notice::delete($notice);
      return redirectCall('?controller=managenotices&action=index&cid='.$notice->channel_id);
    }

    private function makePagination($limit, $defaultPage) {
      $notices = NoticeDetails::findByParent($_GET['cid']);
      $pages = ceil(count($notices)/$limit);
      $pagLink = '';

      if($defaultPage > 1){
        $prev_page = $defaultPage-1;
        $pagLink .= '<li class="page-item"><a class="page-link" href="?controller=channels&action=show&id='.$_GET['cid'].'&page='.$prev_page.'">Previous</a></li>';  
      }

      for ($i=1; $i<=$pages; $i++) {  
        $active = '';
        if($defaultPage == $i)
          $active = 'active';

        $pagLink .= '<li class="page-item '.$active.'"><a class="page-link" href="?controller=channels&action=show&id='.$_GET['cid'].'&page='.$i.'">'.$i.'</a></li>';  
      };  

      if($defaultPage < $pages){
        $next_page = $defaultPage+1;
        $pagLink .=  '<li class="page-item"><a class="page-link" href="?controller=channels&action=show&id='.$_GET['cid'].'&page='.$next_page.'">Next</a></li>'; 
      }

      return $pagLink;
    }
  }
?>