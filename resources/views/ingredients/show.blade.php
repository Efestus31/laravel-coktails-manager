@extends('layouts.app')

@section('title', 'Ingredient Details')

@section('content')
<div class="container">
  <div class="card shadow-sm p-4 mb-4">
    <h1 class="mb-4">Ingredient: {{ $ingredient->name }}</h1>

    @auth
      <div class="mb-4">
        <a href="{{ route('ingredients.edit', $ingredient) }}" class="btn btn-warning me-2">Edit</a>
        <form action="{{ route('ingredients.destroy', $ingredient) }}" method="POST" class="d-inline">
          @csrf
          @method('DELETE')
          <button class="btn btn-danger" onclick="return confirm('Delete this ingredient?')">
            Delete
          </button>
        </form>
      </div>
    @endauth

    <hr>

    <h5 class="card-subtitle mb-2">Cocktails containing this ingredient</h5>
    @if($ingredient->cocktails->count())
      <ul class="list-group">
        @foreach($ingredient->cocktails as $cocktail)
          <li class="list-group-item d-flex justify-content-between align-items-center ">
            <a href="{{ route('cocktails.show', $cocktail) }}">{{ $cocktail->name }}</a>
            <span class="badge bg-secondary">{{ $cocktail->type?->name ?? '–' }}</span>
          </li>
        @endforeach
      </ul>
    @else
      <p class="text-muted">No cocktails use this ingredient.</p>
    @endif

    <a href="{{ route('ingredients.index') }}" class="btn btn-link mt-4">← Back to Ingredients</a>
  </div>
</div>
@endsection
