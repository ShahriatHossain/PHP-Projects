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
					    
					  </li>
					  
					</ul>	      
			    </div>
		  	</div>
		  </div>
		  <div class="card-body">

			  <table class="table table-striped">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">Name</th>
				      <th scope="col">Created By</th>
				      <th scope="col">Action</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php $i = 1; foreach($channels as $channel){?>
				    <tr>
				      <th scope="row">
				      	<?php echo $i;?>
				      </th>
				      <td><a href="?controller=managenotices&action=index&cid=<?php echo $channel->id; ?>"><?php echo $channel->name;?></a></td>
				      <td><?php echo $channel->user_name?></td>
				       <td>
				       	<a href="?controller=managechannels&action=edit&id=<?php echo $channel->id; ?>" title="Edit" class="text-success"><span class="oi oi-pencil"></span></a>
				       	&nbsp;
				      	<a href="?controller=managechannels&action=delete&id=<?php echo $channel->id; ?>" title="Delete" class="text-danger"><span class="oi oi-delete"></span></a>
				      </td>
				    </tr>
				    <?php $i++;}?>
				  </tbody>
				</table>

				<nav class="float-right" aria-label="Page navigation example">
			      <ul class="pagination">
			        <?php echo $pageLink;?>
			      </ul>
			    </nav>

		  </div>
		  </div>
    </div>
</section>

