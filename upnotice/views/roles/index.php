<?php echo $breadcrumb;?>
<section class="charts">
    <div class="container-fluid">
        <div class="card">
		  <div class="card-header">
		  	<div class="row">
			    <div class="col-sm">
					Role List
			    </div>
			    <div class="col-sm">
					<ul class="nav justify-content-end">
					  <li class="nav-item">
					    <a class="nav-link active" href="#" data-toggle="modal" data-target="#newRoleModal" title="Create New Role"><span class="oi oi-plus"></span></a>
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
				      <th scope="col">Action</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php $i = 1; foreach($roles as $role){?>
				    <tr>
				      <th scope="row">
				      	<?php echo $i;?>
				      </th>
				      <td><?php echo $role->name?></td>
				       <td>
				       	<a href="?controller=manageroles&action=edit&id=<?php echo $role->id; ?>" title="Edit" class="text-success"><span class="oi oi-pencil"></span></a>
				       	&nbsp;
				      	<a href="?controller=manageroles&action=delete&id=<?php echo $role->id; ?>" title="Delete" class="text-danger"><span class="oi oi-delete"></span></a>
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

		<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
			
		  <form method="post" action="?controller=manageroles&action=create">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="postNoticeModalLabel">New Role</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		          <div class="form-group">
		            <label for="inputName" class="col-form-label">Name</label>
		    		<input type="text" name="name" class="form-control" id="inputName" placeholder="Role Name">
		          </div>
		      </div>
		      <div class="modal-footer">
		        <input type="hidden" name="submit" value="1">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Create Role</button>
		      </div>
		    </div>
		  </div>
		</form>
		</div>

		<script type="text/javascript">
			$('#newRoleModal').on('show.bs.modal', function (event) {
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

