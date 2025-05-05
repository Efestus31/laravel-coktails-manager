@extends('layouts.app')

@section('title', $cocktail->name)

@section('content')
<div class="container">
    <h1 class="mb-4">{{ $cocktail->name }}</h1>

    {{-- Image display --}}
    @if($cocktail->image_data)
        <div class="mb-4 text-center">
            <img 
                src="{{ route('cocktails.image', $cocktail) }}" 
                alt="Foto di {{ $cocktail->name }}" 
                loading="lazy"
                class="img-fluid rounded mx-auto d-block" 
                style="max-width:400px; height:auto;"
            >
        </div>
    @endif

    <div class="mb-3">
        <h5>Description</h5>
        <p>{{ $cocktail->description ?? '—' }}</p>
    </div>

    <div class="mb-3">
        <h5>Instructions</h5>
        <p>{{ $cocktail->instructions ?? '—' }}</p>
    </div>

    <div class="mb-3">
        <h5>Type</h5>
        <p>{{ $cocktail->type?->name ?? '—' }}</p>
    </div>

    <div class="mb-3">
        <h5>Ingredients</h5>
        <p>
            @foreach($cocktail->ingredients as $ingredient)
                <span class="badge bg-info text-dark me-1">{{ $ingredient->name }}</span>
            @endforeach
        </p>
    </div>

    <div class="d-flex gap-2 mt-4">
        <a href="{{ route('cocktails.index') }}" class="btn btn-secondary">Back to list</a>
        @auth
            <a href="{{ route('cocktails.edit', $cocktail) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('cocktails.destroy', $cocktail) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button 
                    class="btn btn-danger" 
                    onclick="return confirm('Sei sicuro di voler eliminare questo cocktail?')">
                    Delete
                </button>
            </form>
        @endauth
    </div>

</div>
@endsection