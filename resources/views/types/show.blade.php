@extends('layouts.app')

@section('title', 'Type Details')

@section('content')
<div class="container">
  <div class="card shadow-sm p-4 mb-4">
    <h1 class="mb-4">Type: {{ $type->name }}</h1>

    @auth
      <div class="mb-4">
        <a href="{{ route('types.edit', $type) }}" class="btn btn-warning me-2">Edit</a>
        <form action="{{ route('types.destroy', $type) }}" method="POST" class="d-inline">
          @csrf
          @method('DELETE')
          <button class="btn btn-danger" onclick="return confirm('Delete this type?')">
            Delete
          </button>
        </form>
      </div>
    @endauth

    <hr>

    <h5 class="card-subtitle mb-2">Cocktails with this type</h5>
    @if($type->cocktails->count())
      <ul class="list-group">
        @foreach($type->cocktails as $cocktail)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ route('cocktails.show', $cocktail) }}">{{ $cocktail->name }}</a>
            <span class="badge bg-secondary">{{ $cocktail->ingredients->count() }} ing.</span>
          </li>
        @endforeach
      </ul>
    @else
      <p class="text-muted">No cocktails assigned to this type.</p>
    @endif

    <a href="{{ route('types.index') }}" class="btn btn-link mt-4">← Back to Types</a>
  </div>
</div>
@endsection
