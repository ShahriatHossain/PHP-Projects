@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    <div class="pull-left">
                <h3>Show Program</h3>
            </div>

            <div class="pull-right">
                <a title="Back" class="btn btn-primary btn-sm" href="{{ route('programs.index') }}"><span class="oi oi-arrow-thick-left"></span></a>
            </div>
  </div>
  <div class="card-body">
    <form>
  <div class="form-group row">
    <label for="Name" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      {{ $program->name}}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Code</div>
    <div class="col-sm-10">
      {{ $program->code}}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Total Semester</div>
    <div class="col-sm-10">
      {{ $program->total_semester}}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Description</div>
    <div class="col-sm-10">
      {{ $program->description}}
    </div>
  </div>
  
</form>
  </div>
</div>


@endsection