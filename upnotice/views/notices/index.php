<?php echo $breadcrumb;?>
<section class="charts">
    <div class="container-fluid">
        <div class="card">
		  <div class="card-header">
		  	<div class="row">
			    <div class="col-sm">
					Notice List
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
				      <th scope="col">Channel Name</th>
				      <th scope="col">Notice</th>
				      <th scope="col">Description</th>
				      <th scope="col">File Name</th>
				      <th scope="col">File Displayname</th>
				      <th scope="col">Created Date</th>
				      <th scope="col">Action</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php $i = 1; foreach($notices as $notice){?>
				    <tr>
				      <th scope="row">
				      	<?php echo $i;?>
				      </th>
				      <td><?php echo $notice->channel_name;?></td>
				      <td><?php echo $notice->notice?></td>
				      <td><?php echo $notice->description?></td>
				      <td><?php echo $notice->filename?></td>
				      <td><?php echo $notice->file_displayname?></td>
				      <td><?php echo $notice->created_date?></td>
				       <td>
				       	<a href="?controller=managenotices&action=edit&id=<?php echo $notice->notice_id; ?>" title="Edit" class="text-success"><span class="oi oi-pencil"></span></a>
				       	&nbsp;
				      	<a href="?controller=managenotices&action=delete&id=<?php echo $notice->notice_id; ?>" title="Delete" class="text-danger"><span class="oi oi-delete"></span></a>
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

    </div>
</section>
