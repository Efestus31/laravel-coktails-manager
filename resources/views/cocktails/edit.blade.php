@extends('layouts.app')

@section('title', 'Edit Cocktail')

@section('content')
<div class="container">
    <div class="card shadow-sm p-4" id="edit-card">
        <h1 class="mb-4">Edit Cocktail 🍹</h1>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger" id="error-alert">
                <strong>Oops!</strong> There are some problems with your input:<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Edit form --}}
        <form action="{{ route('cocktails.update', $cocktail) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Cocktail name --}}
            <div class="mb-3">
                <label for="name" class="form-label">Cocktail Name</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $cocktail->name) }}" required>
            </div>

            {{-- Cocktail type --}}
            <div class="mb-3">
                <label for="type_id" class="form-label">Type</label>
                <select name="type_id" id="type_id" class="form-select" required>
                    <option value="">-- Select Type --</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}"
                            {{ old('type_id', $cocktail->type_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Cocktail ingredients (multi-select) --}}
            <div class="mb-3">
                <label for="ingredients" class="form-label">Ingredients</label>
                <select name="ingredients[]" id="ingredients" class="form-select" multiple>
                    @foreach ($ingredients as $ingredient)
                        <option value="{{ $ingredient->id }}"
                            {{ in_array($ingredient->id, old('ingredients', $cocktail->ingredients->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $ingredient->name }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple ingredients.</small>
            </div>

            {{-- Cocktail description --}}
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $cocktail->description) }}</textarea>
            </div>

            {{-- Cocktail instructions --}}
            <div class="mb-3">
                <label for="instructions" class="form-label">Instructions</label>
                <textarea name="instructions" id="instructions" class="form-control" rows="4">{{ old('instructions', $cocktail->instructions) }}</textarea>
            </div>

            {{-- Cocktail image upload and preview --}}
            <div class="mb-3">
                <label for="image" class="form-label">Upload Image</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">

                @if($cocktail->image_data)
                    <small class="form-text text-muted">Current image:</small>
                    <img src="{{ route('cocktails.image', $cocktail) }}"
                         alt="{{ $cocktail->name }}" class="img-fluid rounded mt-2" style="max-width:150px; height:auto;">
                @endif
            </div>
            <small>Max size: 4MB</small>

            {{-- Buttons --}}
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success">Update Cocktail</button>
                <a href="{{ route('cocktails.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
