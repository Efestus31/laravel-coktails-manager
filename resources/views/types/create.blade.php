@extends('layouts.app')
@section('title', 'New Type')

@section('content')
<div class="container">
  <h1 class="mb-4">Add New Type</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('types.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">Type Name</label>
      <input type="text" name="name" id="name"
             class="form-control"
             value="{{ old('name') }}"
             required>
    </div>

    <div class="d-flex gap-2">
      <button class="btn btn-primary">Save</button>
      <a href="{{ route('types.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
