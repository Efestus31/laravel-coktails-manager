@extends('layouts.app')

@section('title', 'Cocktails List')

@section('content')
    <div class="container">
        <h1 class="mb-4">Cocktails List 🍸</h1>

        {{-- Link to create a new cocktail --}}
        @auth
            <a href="{{ route('cocktails.create') }}" class="btn btn-success mb-3">
                ➕ Add New Cocktail
            </a>
        @endauth

        {{-- Success message after an action --}}
        @if (session('success'))
            <div id="flash-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Cocktails Table --}}
        @if ($cocktails->count())
            <div class="table-responsive">
                <table id="cocktails-table" class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Ingredients</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cocktails as $cocktail)
                            <tr>
                                {{-- Thumbnail column --}}
                                <td>
                                    @if ($cocktail->image_data)
                                        <img src="{{ route('cocktails.image', $cocktail) }}" loading="lazy"
                                            alt="{{ $cocktail->name }}"
                                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>

                                <td>{{ $cocktail->name }}</td>
                                {{-- Cocktail's type --}}
                                <td>{{ $cocktail->type?->name ?? '-' }}</td>

                                {{-- Cocktail's ingredients --}}
                                <td>
                                    @foreach ($cocktail->ingredients as $ingredient)
                                        <span class="badge bg-info text-dark">{{ $ingredient->name }}</span>
                                    @endforeach
                                </td>

                                {{-- Action buttons: Show, Edit, Delete --}}
                                <td>
                                    <a href="{{ route('cocktails.show', $cocktail) }}"
                                        class="btn btn-sm btn-primary">Show</a>
                                    @auth
                                        <a href="{{ route('cocktails.edit', $cocktail) }}"
                                            class="btn btn-sm btn-warning">Edit</a>

                                        <form action="{{ route('cocktails.destroy', $cocktail) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this cocktail?')">
                                                Delete
                                            </button>
                                        </form>
                                    @endauth
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                No cocktails available at the moment.
            </div>
        @endif
        <div class="text-center mt-3 medium">
            {{ $cocktails->links() }}
        </div>
        
    </div>

@endsection
