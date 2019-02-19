<form>
  <div class="form-group row">
    <label for="Name" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      {!! Form::text('name', null, array('id'=>'Name', 'placeholder' => 'Name','class' => 'form-control')) !!}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Code</div>
    <div class="col-sm-10">
      {!! Form::text('code', null, array('placeholder' => 'Code','class' => 'form-control')) !!}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Total Semester</div>
    <div class="col-sm-10">
      {!! Form::text('total_semester', null, array('placeholder' => 'Total Semester','class' => 'form-control')) !!}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Description</div>
    <div class="col-sm-10">
      {!! Form::textarea('description', null, array('placeholder' => 'Description','class' => 'form-control','style'=>'height:150px')) !!}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">&nbsp;</div>
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </div>
</form>
