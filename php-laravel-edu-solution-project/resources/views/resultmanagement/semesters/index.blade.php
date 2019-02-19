@extends('layouts.app')

@section('content')

<div class="card">
  <div class="card-header">
    <div class="pull-left">
                <h3>Semesters</h3>
            </div>

            <div class="pull-right">
                <a title="Create New Semester" class="btn btn-primary btn-sm" href="{{ route('semesters.create') }}"><span class="oi oi-plus"></span></a>
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
      <th scope="col">Program</th>
      <th scope="col">Type</th>
      <th scope="col">Year</th>
      <th scope="col">Start Date</th>
      <th scope="col">End Date</th>
      <th scope="col">Description</th>
      <th scope="col" width="280px">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($semesters as $semester)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $semester->name}}</td>
        <td>{{ $semester->code}}</td>
        <td>{{ $semester->program_id}}</td>
        <td>{{ $semester->type}}</td>
        <td>{{ $semester->year}}</td>
        <td>{{ $semester->start_date}}</td>
        <td>{{ $semester->end_date}}</td>
        <td>{{ $semester->description}}</td>
        <td>
            <a title="Show" class="btn btn-info btn-sm" href="{{ route('semesters.show',$semester->id) }}"><span class="oi oi-eye"></span></a>
            <a title="Edit" class="btn btn-primary btn-sm" href="{{ route('semesters.edit',$semester->id) }}"><span class="oi oi-pencil"></span></a>
            {!! Form::open(['method' => 'DELETE','route' => ['semesters.destroy', $semester->id],'style'=>'display:inline']) !!}
            {{ Form::button('<span class="oi oi-delete"></span>', array('title'=>'Delete','type' => 'submit', 'class' => 'btn btn-danger btn-sm')) }}
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
  </tbody>
</table>
{!! $semesters->links() !!}
    
  </div>
</div>
@endsection