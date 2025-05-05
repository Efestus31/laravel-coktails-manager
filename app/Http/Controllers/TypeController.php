<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::orderBy('name')->paginate(10);
        return view('types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:types,name',
        ]);

        Type::create(['name' => $request->name]);

        return redirect()
            ->route('types.index')
            ->with('success', 'Type creato con successo!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        $type->load('cocktails.ingredients');

        return view('types.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        return view('types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:types,name,'.$type->id,
        ]);

        $type->update(['name' => $request->name]);

        return redirect()
            ->route('types.index')
            ->with('success', 'Type aggiornato con successo!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->cocktails()->update(['type_id' => null]);
        $type->delete();

        return redirect()
            ->route('types.index')
            ->with('success', 'Type eliminato con successo!');
    }
}
