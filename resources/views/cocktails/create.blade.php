@extends('layouts.app')

@section('title', 'New cocktail')

@section('content')
    <div class="container">
        <h1 class="mb-4"> Create a new Cocktail!</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops!</strong> There are problems with the form data:<br><br>
                <ul>
                    @foreach ($errors->all as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- Form  --}}
        <form action="{{ route('cocktails.store') }}" method="POST">
            @csrf

            {{-- Cocktail name --}}
            <div class="mb-3">
                <label for="name" class="form-label">Cocktail name:</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
            </div>

            {{-- Cocktail Type --}}
            <div class="mb-3">
                <label for="type_id" class="form-label">Tipologia</label>
                <select name="type_id" id="type_id" class="form-select" required>
                    <option value="">-- Seleziona tipologia --</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Ingredienti del cocktail (multi-select) --}}
            <div class="mb-3">
                <label for="ingredients" class="form-label">Ingredienti</label>
                <select name="ingredients[]" id="ingredients" class="form-select" multiple>
                    @foreach ($ingredients as $ingredient)
                        <option value="{{ $ingredient->id }}"
                            {{ collect(old('ingredients'))->contains($ingredient->id) ? 'selected' : '' }}>
                            {{ $ingredient->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Descrizione --}}
            <div class="mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            {{-- Istruzioni --}}
            <div class="mb-3">
                <label for="instructions" class="form-label">Istruzioni</label>
                <textarea name="instructions" id="instructions" class="form-control" rows="4">{{ old('instructions') }}</textarea>
            </div>

            {{-- Immagine --}}
            <div class="mb-3">
                <label for="image" class="form-label">URL Immagine (opzionale)</label>
                <input type="text" name="image" id="image" class="form-control" value="{{ old('image') }}">

                <button type="submit" class="btn btn-primary">Crea Cocktail</button>


                <a href="{{ route('cocktails.index') }}" class="btn btn-secondary">Annulla</a>
            </div>
        </form>
    </div>
@endsection
