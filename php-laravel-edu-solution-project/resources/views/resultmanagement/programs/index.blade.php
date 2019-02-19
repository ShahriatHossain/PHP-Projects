@extends('layouts.app')

@section('content')

<div class="card">
  <div class="card-header">
    <div class="pull-left">
                <h3>Programs</h3>
            </div>

            <div class="pull-right">
                <a title="Create New Program" class="btn btn-primary btn-sm" href="{{ route('programs.create') }}"><span class="oi oi-plus"></span></a>
            </div>
  </div>
  <div class="card-body">
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ $message }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
    @endif
    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Name</th>
      <th scope="col">Code</th>
      <th scope="col">Total Semester</th>
      <th scope="col">Description</th>
      <th scope="col" width="280px">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($programs as $program)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $program->name}}</td>
        <td>{{ $program->code}}</td>
        <td>{{ $program->total_semester}}</td>
        <td>{{ $program->description}}</td>
        <td>
            <a title="Show" class="btn btn-info btn-sm" href="{{ route('programs.show',$program->id) }}"><span class="oi oi-eye"></span></a>
            <a title="Edit" class="btn btn-primary btn-sm" href="{{ route('programs.edit',$program->id) }}"><span class="oi oi-pencil"></span></a>
            {!! Form::open(['method' => 'DELETE','route' => ['programs.destroy', $program->id],'style'=>'display:inline']) !!}
            {{ Form::button('<span class="oi oi-delete"></span>', array('title'=>'Delete','type' => 'submit', 'class' => 'btn btn-danger btn-sm')) }}
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
  </tbody>
</table>
{!! $programs->links() !!}
    
  </div>
</div>
@endsection