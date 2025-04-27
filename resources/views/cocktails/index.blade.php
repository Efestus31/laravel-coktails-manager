@extends('layouts.app')

@section('title', 'Cocktails List')

@section('content')
<div class="container">
    <h1 class="mb-4">Cocktails List 🍸</h1>

    {{-- Link to create a new cocktail --}}
    <a href="{{ route('cocktails.create') }}" class="btn btn-primary mb-3">
        Add New Cocktail
    </a>

    {{-- Success message after an action --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Check if there are any cocktails --}}
    @if($cocktails->count())
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Ingredients</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop through all cocktails --}}
                @foreach($cocktails as $cocktail)
                    <tr>
                        <td>{{ $cocktail->name }}</td>

                        {{-- Cocktail's type --}}
                        <td>{{ $cocktail->type ? $cocktail->type->name : '-' }}</td>

                        {{-- Cocktail's ingredients --}}
                        <td>
                            @foreach($cocktail->ingredients as $ingredient)
                                <span class="badge bg-info">{{ $ingredient->name }}</span>
                            @endforeach
                        </td>

                        {{-- Action buttons: Show, Edit, Delete --}}
                        <td>
                            <a href="{{ route('cocktails.show', $cocktail) }}" class="btn btn-sm btn-success">Show</a>
                            <a href="{{ route('cocktails.edit', $cocktail) }}" class="btn btn-sm btn-warning">Edit</a>

                            {{-- Delete form --}}
                            <form action="{{ route('cocktails.destroy', $cocktail) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this cocktail?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        {{-- Message if no cocktails --}}
        <p>No cocktails available at the moment.</p>
    @endif
</div>
@endsection
