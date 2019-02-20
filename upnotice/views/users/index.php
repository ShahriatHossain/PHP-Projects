<?php echo $breadcrumb;?>
<section class="charts">
    <div class="container-fluid">
        <div class="card">
		  <div class="card-header">
		  	<div class="row">
			    <div class="col-sm">
					User List
			    </div>
			    <div class="col-sm">
					<ul class="nav justify-content-end">
					  <li class="nav-item">
					    <a class="nav-link active" href="?controller=manageusers&action=create" title="Create New User"><span class="oi oi-plus"></span></a>
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
				      <th scope="col">Email</th>
				      <th scope="col">Name</th>
				      <th scope="col">Address</th>
				      <th scope="col">Role Name</th>
				      <th scope="col">Action</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php $i = 1; foreach($users as $user){?>
				    <tr>
				      <th scope="row">
				      	<?php echo $i;?>
				      </th>
				      <td><?php echo $user->email?></td>
				      <td><?php echo $user->name?></td>
				      <td><?php echo $user->address?></td>
				      <td><?php echo $user->role_name?></td>
				       <td>
				       	<a href="?controller=manageusers&action=edit&id=<?php echo $user->id; ?>" title="Edit" class="text-success"><span class="oi oi-pencil"></span></a>
				       	&nbsp;
				      	<a href="?controller=manageusers&action=delete&id=<?php echo $user->id; ?>" title="Delete" class="text-danger"><span class="oi oi-delete"></span></a>
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
