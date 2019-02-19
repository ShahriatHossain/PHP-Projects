@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    <div class="pull-left">
                <h3>Show Course</h3>
            </div>

            <div class="pull-right">
                <a title="Back" class="btn btn-primary btn-sm" href="{{ route('courses.index') }}"><span class="oi oi-arrow-thick-left"></span></a>
            </div>
  </div>
  <div class="card-body">
    <form>
  <div class="form-group row">
    <label for="Name" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      {{ $course->name}}
    </div>
  </div>
  <div class="form-group row">
    <label for="Program" class="col-sm-2 col-form-label">Program</label>
    <div class="col-sm-10">
      {{ $course->program_id}}
    </div>
  </div>
  <div class="form-group row">
    <label for="Program" class="col-sm-2 col-form-label">Semester</label>
    <div class="col-sm-10">
      {{ $course->semester_id}}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Code</div>
    <div class="col-sm-10">
      {{ $course->code}}
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">Description</div>
    <div class="col-sm-10">
      {{ $course->description}}
    </div>
  </div>
  
</form>
  </div>
</div>


@endsection