@extends('layouts.app')

@section('title', 'Cocktail detail')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ $cocktail->name }}</h1>

    {{-- Cocktail Image --}}
    @if($cocktail->image)
        <div class="mb-4">
            <img src="{{ $cocktail->image }}" alt="{{ $cocktail->name }}" class="img-fluid rounded">
        </div>
    @endif

    {{-- Cocktail Type --}}
    <div class="mb-3">
        <strong>Type:</strong> {{ $cocktail->type ? $cocktail->type->name : 'No type assigned' }}
    </div>

    {{-- Cocktail Ingredients --}}
    <div class="mb-3">
        <strong>Ingredients:</strong>
        @if($cocktail->ingredients->count())
            <ul>
                @foreach($cocktail->ingredients as $ingredient)
                    <li>{{ $ingredient->name }}</li>
                @endforeach
            </ul>
        @else
            <p>No ingredients assigned.</p>
        @endif
    </div>

    {{-- Cocktail Description --}}
    <div class="mb-3">
        <strong>Description:</strong>
        <p>{{ $cocktail->description ?? 'No description provided.' }}</p>
    </div>

    {{-- Cocktail Instructions --}}
    <div class="mb-3">
        <strong>Instructions:</strong>
        <p>{{ $cocktail->instructions ?? 'No instructions provided.' }}</p>
    </div>

    {{--  Buttons --}}
    <a href="{{ route('cocktails.edit', $cocktail) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('cocktails.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
