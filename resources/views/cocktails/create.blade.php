@extends('layouts.app')

@section('title', 'New Cocktail')

@section('content')
<div class="container">
    <div class="card shadow-sm p-4" id="create-card">
        <h1 class="mb-4">Create a New Cocktail! 🍸</h1>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger" id="error-alert">
                <strong>Oops!</strong> There were some problems with your input:<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Cocktail creation form --}}
        <form action="{{ route('cocktails.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Cocktail Name --}}
            <div class="mb-3">
                <label for="name" class="form-label">Cocktail Name:</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
            </div>

            {{-- Cocktail Type --}}
            <div class="mb-3">
                <label for="type_id" class="form-label">Type</label>
                <select name="type_id" id="type_id" class="form-select" required>
                    <option value="">-- Select Type --</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Cocktail Ingredients (multi-select) --}}
            <div class="mb-3">
                <label for="ingredients" class="form-label">Ingredients</label>
                <select name="ingredients[]" id="ingredients" class="form-select" multiple>
                    @foreach ($ingredients as $ingredient)
                        <option value="{{ $ingredient->id }}" {{ collect(old('ingredients'))->contains($ingredient->id) ? 'selected' : '' }}>
                            {{ $ingredient->name }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple ingredients.</small>
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            {{-- Instructions --}}
            <div class="mb-3">
                <label for="instructions" class="form-label">Instructions</label>
                <textarea name="instructions" id="instructions" class="form-control" rows="4">{{ old('instructions') }}</textarea>
            </div>

            {{-- Image Upload --}}
            <div class="mb-3">
                <label for="image" class="form-label">Upload Image (optional)</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                <small>Max size: 4MB</small>
            </div>

            {{-- Form Buttons --}}
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Create Cocktail</button>
                <a href="{{ route('cocktails.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
