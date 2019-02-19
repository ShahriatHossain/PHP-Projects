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
    <label for="Program" class="col-sm-2 col-form-label">Program</label>
    <div class="col-sm-10">
      {{ Form::select('program_id', ['Under 18', '19 to 30', 'Over 30'], null, ['id'=>'Program', 'placeholder' => 'Pick a size...', 'class' => 'form-control']) }}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Type</div>
    <div class="col-sm-10">
      {!! Form::text('type', null, array('placeholder' => 'Type','class' => 'form-control')) !!}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Year</div>
    <div class="col-sm-10">
      {!! Form::text('year', null, array('placeholder' => 'Year','class' => 'form-control')) !!}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Start Date</div>
    <div class="col-sm-10">
      {!! Form::text('start_date', null, array('placeholder' => 'Start Date','class' => 'form-control', 'id'=>'semsStartDate')) !!}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">End Date</div>
    <div class="col-sm-10">
      {!! Form::text('end_date', null, array('placeholder' => 'End Date','class' => 'form-control', 'id'=>'semsEndDate')) !!}
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
