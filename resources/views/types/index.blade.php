@extends('layouts.app')

@section('title', 'Manage Types')

@section('content')
<div class="container">
    <h1 class="mb-4">Types 📋</h1>

    @auth
    <a href="{{ route('types.create') }}" class="btn btn-success mb-3">
        ➕ Add New Type
    </a>
    @endauth

    @if(session('success'))
        <div id="flash-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($types->count())
    <div class="table-responsive">
        <table id="types-table" class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($types as $type)
                    <tr class="{{ $type->cocktails->count() ? '' : 'table-secondary' }}">
                        <td>{{ $type->name }}</td>
                        <td class="text-end">
                            <a href="{{ route('types.show', $type) }}" class="btn btn-sm btn-primary">Show</a>
                            @auth
                                <a href="{{ route('types.edit', $type) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('types.destroy', $type) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this type?')">
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
            No types available.
        </div>
    @endif

    <div class="text-center mt-3">
        {{ $types->links() }}
    </div>
</div>
@endsection
