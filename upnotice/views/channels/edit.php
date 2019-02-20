<?php echo $breadcrumb;?>
<section class="charts">
    <div class="container-fluid">
        <div class="card">
		  <div class="card-header">
		  	<div class="row">
			    <div class="col-sm">
					Edit Channel
			    </div>
			    <div class="col-sm">
					<ul class="nav justify-content-end">
					  <li class="nav-item">
					    
					  </li>
					  
					</ul>	      
			    </div>
		  	</div>
		  </div>
		  <div class="card-body">

			 <form method="post" action="?controller=managechannels&action=edit&id=<?php echo $channel->id?>">
		        <div class="form-group">
			        <label for="inputName" class="col-form-label">Name</label>
			    	<input type="text" name="name" class="form-control" id="inputName" placeholder="Channe Name" value="<?php echo $channel->name?>">
		        </div>
		        <input type="hidden" name="submit" value="1">
		        <button type="submit" class="btn btn-primary">Edit</button>
			</form>

		  </div>
		 </div>
    </div>
</section>


