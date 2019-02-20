<?php echo $breadcrumb;?>
<section class="charts">
    <div class="container-fluid">
        <form method="post" action="?controller=managenotices&action=edit&id=<?php echo $notice->id?>">
  
            <div class="form-group">
                <label for="notice-title" class="col-form-label">Title:</label>
                <input type="text" name="notice" class="form-control" id="notice-title" value="<?php echo $notice->notice?>">
            </div>
            <div class="form-group">
                <label for="notice-description" class="col-form-label">Description:</label>
                <textarea name="description" class="form-control" id="notice-description"><?php echo $notice->description?></textarea>
            </div>
          <input type="hidden" name="submit" value="1">
          <button type="submit" class="btn btn-primary">Edit</button>
        </form>
    </div>
</section>
