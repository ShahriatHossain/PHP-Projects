@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    <div class="pull-left">
                <h3>Show Semester</h3>
            </div>

            <div class="pull-right">
                <a title="Back" class="btn btn-primary btn-sm" href="{{ route('semesters.index') }}"><span class="oi oi-arrow-thick-left"></span></a>
            </div>
  </div>
  <div class="card-body">
    <form>
  <div class="form-group row">
    <label for="Name" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      {{ $semester->name}}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Code</div>
    <div class="col-sm-10">
      {{ $semester->code}}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Program</div>
    <div class="col-sm-10">
      {{ $semester->program_id}}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Type</div>
    <div class="col-sm-10">
      {{ $semester->type}}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Year</div>
    <div class="col-sm-10">
      {{ $semester->year}}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Start Date</div>
    <div class="col-sm-10">
      {{ $semester->start_date}}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">End Date</div>
    <div class="col-sm-10">
      {{ $semester->end_date}}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Description</div>
    <div class="col-sm-10">
      {{ $semester->description}}
    </div>
  </div>
  
</form>
  </div>
</div>


@endsection