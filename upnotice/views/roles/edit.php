<?php echo $breadcrumb;?>
<section class="charts">
    <div class="container-fluid">
        <form method="post" action="?controller=manageroles&action=edit&id=<?php echo $role->id?>">
  
		    <div class="form-group">
		      <label for="name" class="col-form-label">Name</label>
		      <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?php echo $role->name?>">
		    </div>
		  <input type="hidden" name="submit" value="1">
		  <button type="submit" class="btn btn-primary">Edit</button>
		</form>
    </div>
</section>
