<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingredients = Ingredient::orderBy('name')->paginate(10);
        return view('ingredients.index', compact('ingredients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ingredients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:ingredients,name',
        ]);

        Ingredient::create(['name' => $request->name]);

        return redirect()
            ->route('ingredients.index')
            ->with('success', 'Ingredient creato con successo!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ingredient $ingredient)
    {
        // Carica i cocktail collegati e per ciascuno il suo tipo
        $ingredient->load('cocktails.type');

        return view('ingredients.show', compact('ingredient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', compact('ingredient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:ingredients,name,'.$ingredient->id,
        ]);

        $ingredient->update(['name' => $request->name]);

        return redirect()
            ->route('ingredients.index')
            ->with('success', 'Ingredient aggiornato con successo!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingredient $ingredient)
    {
        
        $ingredient->cocktails()->detach();
        $ingredient->delete();

        return redirect()
            ->route('ingredients.index')
            ->with('success', 'Ingredient eliminato con successo!');
    }
}
