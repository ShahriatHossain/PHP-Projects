<?php echo $breadcrumb;?>
<section class="charts">
    <div class="container-fluid">
        <div class="card">
		  <div class="card-header">
		  	<div class="row">
			    <div class="col-sm">
					Channel List
			    </div>
			    <div class="col-sm">
					<ul class="nav justify-content-end">
					  <li class="nav-item">
					    <a class="nav-link active" href="#" data-toggle="modal" data-target="#newChannelModal" title="Create New Channel"><span class="oi oi-plus"></span></a>
					  </li>
					  
					</ul>	      
			    </div>
		  	</div>
		  </div>
		  <div class="card-body">

			  <nav class="nav nav-tabs" id="myTab" role="tablist">
				  <a class="nav-item nav-link active" id="nav-all-tab" data-toggle="tab" href="#nav-all" role="tab" aria-controls="nav-all" aria-selected="true">All Channels</a>
				  <a class="nav-item nav-link" id="nav-my-tab" data-toggle="tab" href="#nav-my" role="tab" aria-controls="nav-my" aria-selected="true">My Channels</a>
				  <a class="nav-item nav-link" id="nav-subscribe-tab" data-toggle="tab" href="#nav-subscribe" role="tab" aria-controls="nav-subscribe" aria-selected="false">Subscribed Channels</a>
			</nav>

			<div class="tab-content" id="nav-tabContent">
			  <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
			  	<ul class="list-group">
				  <?php foreach($remainChannels as $channel){?>			  	
				  <li class="list-group-item d-flex justify-content-between align-items-center">
				  	<div class="col-sm-10">
				  		<a href="?controller=channels&action=show&id=<?php echo $channel->id; ?>"><?php echo $channel->name;?></a>
				  	</div>
				  	<div class="col-sm-1">
				  		<a href="?controller=channels&action=subscribe&id=<?php echo $channel->id; ?>" class="btn btn-warning btn-sm float-right" role="button">Subscribe It</a>
				  	</div>
				  	<div class="col-sm-1">
				  		<span class="badge badge-primary badge-pill"><?php echo $channel->notice_count;?></span>
				  	</div>
				  </li>
				  <?php }?>
				</ul>
			  </div>

			  <div class="tab-pane fade show" id="nav-my" role="tabpanel" aria-labelledby="nav-all-my">
			  	<ul class="list-group">
				  <?php foreach($ownChannels as $channel){?>			  	
				  <li class="list-group-item d-flex justify-content-between align-items-center">
				  	<div class="col-sm-11">
				  		<a href="?controller=channels&action=show&id=<?php echo $channel->id; ?>"><?php echo $channel->name;?></a>
				  	</div>
				  	<div class="col-sm-1">
				  		<span class="badge badge-primary badge-pill"><?php echo $channel->notice_count;?></span>
				  	</div>
				  </li>
				  <?php }?>
				</ul>
			  </div>

			  <div class="tab-pane fade show" id="nav-subscribe" role="tabpanel" aria-labelledby="nav-subscribe-tab">
			  	<ul class="list-group">
				  <?php foreach($subscribedChannels as $channel){?>			  	
				  <li class="list-group-item d-flex justify-content-between align-items-center">
				  	<div class="col-sm-10">
				  		<a href="?controller=channels&action=show&id=<?php echo $channel->id; ?>"><?php echo $channel->name;?></a>
				  	</div>
				  	<div class="col-sm-1">
				  		<a href="#" class="btn btn-secondary btn-sm float-right" role="button">Subscribed</a>
				  	</div>
				  	<div class="col-sm-1">
				  		<span class="badge badge-primary badge-pill"><?php echo $channel->notice_count;?></span>
				  	</div>
				  </li>
				  <?php }?>
				</ul>
			  </div>

			</div>
		  </div>
		</div>

		<div class="modal fade" id="newChannelModal" tabindex="-1" role="dialog" aria-labelledby="newChannelModalLabel" aria-hidden="true">
			
		  <form method="post" action="?controller=channels&action=post">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="postNoticeModalLabel">New Channel</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		          <div class="form-group">
		            <label for="inputName" class="col-form-label">Name</label>
		    		<input type="text" name="name" class="form-control" id="inputName" placeholder="Channe Name">
		          </div>
		      </div>
		      <div class="modal-footer">
		        <input type="hidden" name="submit" value="1">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Create Channel</button>
		      </div>
		    </div>
		  </div>
		</form>
		</div>

		<script type="text/javascript">
			$('#newChannelModal').on('show.bs.modal', function (event) {
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

