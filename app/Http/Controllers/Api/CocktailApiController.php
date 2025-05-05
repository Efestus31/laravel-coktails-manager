<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cocktail;
use Illuminate\Http\Request;

class CocktailApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cocktails = Cocktail::with(['type', 'ingredients'])->get();
        return response()->json($cocktails);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'image' => 'nullable|url',
            'type_id' => 'required|exists:types,id',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
        ]);

        $cocktail = Cocktail::create($data);

        if (isset($data['ingredients'])) {
            $cocktail->ingredients()->sync($data['ingredients']);
        }

        return response()->json($cocktail, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cocktail $cocktail)
    {
        $cocktail->load(['type', 'ingredients']);
        return response()->json($cocktail);
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
            'image' => 'nullable|url',
            'type_id' => 'required|exists:types,id',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
        ]);

        $cocktail->update($data);

        if (isset($data['ingredients'])) {
            $cocktail->ingredients()->sync($data['ingredients']);
        }

        return response()->json($cocktail);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cocktail $cocktail)
    {
        $cocktail->delete();
        return response()->json(null, 204); 
    }
}
