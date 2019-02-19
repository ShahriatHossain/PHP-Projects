@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    <div class="pull-left">
                <h3>Add New Course</h3>
            </div>

            <div class="pull-right">
                <a title="Back" class="btn btn-primary btn-sm" href="{{ route('courses.index') }}"><span class="oi oi-arrow-thick-left"></span></a>
            </div>
  </div>
  <div class="card-body">
    @if (count($errors) < 0)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Whoops!</strong> There were some problems with your input.<br><br>
          <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
    @endif
    {!! Form::open(array('route' => 'courses.store','method'=>'POST')) !!}
         @include('resultmanagement.courses.form')
    {!! Form::close() !!}
  </div>
</div>
    


    

@endsection