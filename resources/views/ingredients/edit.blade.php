@extends('layouts.app')
@section('title', 'Edit Ingredient')

@section('content')
<div class="container">
  <h1 class="mb-4">Edit Ingredient</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('ingredients.update', $ingredient) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="name" class="form-label">Ingredient Name</label>
      <input type="text" name="name" id="name"
             class="form-control"
             value="{{ old('name', $ingredient->name) }}"
             required>
    </div>

    <button class="btn btn-success">Update</button>
    <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
