<?php

namespace App\Http\Controllers;

use App\Models\Cocktail;
use App\Models\Ingredient;
use App\Models\Type;
use Illuminate\Http\Request;

class CocktailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all the cocktails  with the data of the relationship
        $cocktails = Cocktail::with('type', 'ingredients')->get();
        return view('cocktails.index', compact('cocktails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //get all the types and ingredients
        $types = Type::all();
        $ingredients = Ingredient::all();
        return view('cocktails.create', compact('types', 'ingredients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validation of data of the form
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'image' => 'nullable|string',
            'type_id' => 'required|exists:types,id',
            'ingredients' => 'array|exists:ingredients,id',
        ]);

        $newCocktail = new Cocktail();

        $newCocktail->name = $data['name'];
        $newCocktail->description = $data['description'] ?? null;
        $newCocktail->instructions = $data['instructions'] ?? null;
        $newCocktail->image = $data['image'] ?? null;
        $newCocktail->type_id = $data['type_id'];

        $newCocktail->save();

        //if there are ingredients, we link them
        if(isset($data['ingredients'])) {
            $newCocktail->ingredients()->attach($data['ingredients']);
        }

        //redirect successfully message
        return redirect()->route('cocktails.index')->with('success', 'Cocktail created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Cocktail $cocktail)
    {
        $cocktail->load('type', 'ingredients');
        return view('cocktails.show', compact('cocktail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cocktail $cocktail)
    {
        //gather all the types and ingredients available
        $types = Type::all();
        $ingredients = Ingredient::all();

        $cocktail->load('ingredients');

        return view('cocktails.edit', compact('cocktail', 'types', 'ingredients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cocktail $cocktail)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'image' => 'nullable|string',
            'type_id' => 'required|exists:types,id',
            'ingredients' => 'array|exists:ingredients,id',
        ]);

        $cocktail->name =$data['name'];
        $cocktail->description = $data['description'] ?? null;
        $cocktail->instructions = $data['instructions'] ?? null;
        $cocktail->image = $data['image'] ?? null;
        $cocktail->type_id = $data['type_id'];

        $cocktail->save();

        //update the links with the ingredients
        if(isset($data['ingredients'])) {
            $cocktail->ingredients()->sync($data['ingredients']);
        }

        //redirect with message
        return redirect()->route('cocktails.index')->with('success', 'Cocktail updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cocktail $cocktail)
    {
        //detach linked ingredients
        $cocktail->ingredients()->detach();
        $cocktail->delete();

        return redirect()->route('cocktail.index')->with('success', 'Cocktail deleted successfully!');
    }
}
