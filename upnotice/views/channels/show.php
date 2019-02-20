<?php echo $breadcrumb;?>
<section class="charts">
    <div class="container-fluid">
        <div class="card">
          <div class="card-header">

            <div class="row">
              <div class="col-sm">
              <?php echo $channel->name;?>
              </div>
              <div class="col-sm">
              <ul class="nav justify-content-end">
                <li class="nav-item">
                  <?php if($isChannelOwner){?>
                  <a class="nav-link active" href="#" data-toggle="modal" data-target="#postNoticeModal" title="Post Notice"><span class="oi oi-plus"></span></a>
                  <?php }?>
                </li>
              </ul>       
              </div>
            </div>

          </div>
          <div class="card-body">
          <div class="card-columns">
              <?php foreach($notices as $notice){?>
              <div class="card" style="max-width: 20rem;">
                <div class="card-header">
                  <?php if($notice->user_id != $_SESSION["loggedInUserId"]){?>
                    <a href="?controller=channels&action=postvoting&cid=<?php echo $channel->id; ?>&nid=<?php echo $notice->notice_id?>&status=1" class="float-right text-info"><span class="oi oi-thumb-up"></span></a>
                    <a href="?controller=channels&action=postvoting&cid=<?php echo $channel->id; ?>&nid=<?php echo $notice->notice_id?>&status=0" class="float-right text-info" style="padding-right: 10px;"><span class="oi oi-thumb-down"></span></a>
                    <?php }
                    else {?>
                      <span class="float-right text-muted oi <?php echo ($notice->response==1)? 'oi-thumb-up':'oi-thumb-down';?>"></span>
                    <?php }?>
                    <div style="clear:both;"></div>
                  </div>
                <div class="card-body">
                  <!--<h4 class="card-title"><?php echo $notice->notice;?></h4>-->
                  <p class="card-text" style="height: 100px;">
                    <?php echo strlen($notice->description) > 30 ? substr($notice->description, 0, 70) . '..' : $notice->description; ?></p>
                  <a href="?controller=channels&action=noticedetails&id=<?php echo $notice->notice_id?>" class="btn btn-outline-info btn-sm float-right">GO</a>
                  <div style="clear: both;"></div>
                </div>
                <div class="card-footer">
                  <small class="text-muted"><?php echo $notice->created_date;?></small>
                </div>
            </div>
            <?php }?>
          </div>
            <nav class="float-right" aria-label="Page navigation example">
              <ul class="pagination">
                <?php echo $pageLink;?>
              </ul>
            </nav>
          </div>
        </div>



        <div class="modal fade" id="postNoticeModal" tabindex="-1" role="dialog" aria-labelledby="postNoticeModalLabel" aria-hidden="true">
          <form method="post" action="?controller=channels&action=postnotice&id=<?php echo $channel->id; ?>">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="postNoticeModalLabel">New Notice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                    <label for="notice-title" class="col-form-label">Title:</label>
                    <input type="text" name="notice" class="form-control" id="notice-title">
                  </div>
                  <div class="form-group">
                    <label for="notice-description" class="col-form-label">Description:</label>
                    <textarea name="description" class="form-control" id="notice-description"></textarea>
                  </div>
              </div>
              <div class="modal-footer">
                <input type="hidden" name="submit" value="1">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Post Notice</button>
              </div>
            </div>
          </div>
        </form>
        </div>

        <script type="text/javascript">
          $('#postNoticeModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var recipient = button.data('whatever') // Extract info from data-* attributes
          // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
          // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
          var modal = $(this)
          modal.find('.modal-title').text('New message to ' + recipient)
          modal.find('.modal-body input').val(recipient)
        })
        </script>
    </div>
</section>

