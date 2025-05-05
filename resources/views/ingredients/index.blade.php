@extends('layouts.app')

@section('title', 'Manage Ingredients')

@section('content')
<div class="container">
    <h1 class="mb-4">Ingredients 🧂</h1>

    @auth
    <a href="{{ route('ingredients.create') }}" class="btn btn-success mb-3">
        ➕ Add New Ingredient
    </a>
    @endauth

    @if(session('success'))
        <div id="flash-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($ingredients->count())
    <div class="table-responsive">
        <table id="ingredients-table" class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ingredients as $ingredient)
                    <tr class="{{ $ingredient->cocktails->count() ? '' : 'table-secondary' }}">
                        <td>{{ $ingredient->name }}</td>
                        <td class="text-end">
                            <a href="{{ route('ingredients.show', $ingredient) }}" class="btn btn-sm btn-primary">Show</a>
                            @auth
                                <a href="{{ route('ingredients.edit', $ingredient) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('ingredients.destroy', $ingredient) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this ingredient?')">
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
            No ingredients available.
        </div>
    @endif

    <div class="text-center mt-3">
        {{ $ingredients->links() }}
    </div>
</div>
@endsection
