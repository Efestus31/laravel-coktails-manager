<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cocktail;
use Illuminate\Http\Request;
use App\Http\Resources\CocktailResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CocktailApiController extends Controller
{
    /**
     * Display a paginated listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
         // 1. Leggi i parametri di filtro
    $perPage           = $request->get('per_page', 12);
    $typeFilter        = $request->get('type');        // es. /api/cocktails?type=3
    $ingredientFilter  = $request->get('ingredient');  // es. /api/cocktails?ingredient=7

    // 2. Costruisci la query di base con le relazioni
    $query = Cocktail::with(['type', 'ingredients']);

    // 3. Applica il filtro per tipo (1-N)
    if ($typeFilter) {
        $query->where('type_id', $typeFilter);
    }

    // 4. Applica il filtro per ingrediente (N-N)
    if ($ingredientFilter) {
        $query->whereHas('ingredients', function ($q) use ($ingredientFilter) {
            $q->where('ingredient_id', $ingredientFilter);
        });
    }

    // 5. Esegui la paginazione
    $paginator = $query->paginate($perPage);

    // 6. Ritorna la collection di risorse
    return CocktailResource::collection($paginator);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'instructions' => 'nullable|string',
            'image_url'    => 'nullable|url',
            'type_id'      => 'required|exists:types,id',
            'ingredients'  => 'array',
            'ingredients.*'=> 'exists:ingredients,id',
        ]);

        $cocktail = Cocktail::create([
            'name'         => $data['name'],
            'description'  => $data['description'] ?? null,
            'instructions' => $data['instructions'] ?? null,
            'type_id'      => $data['type_id'],
            // Nota: l'API accetta un URL, non salva direttamente il blob
        ]);

        if (! empty($data['ingredients'])) {
            $cocktail->ingredients()->sync($data['ingredients']);
        }

        return new CocktailResource($cocktail->load(['type','ingredients']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Cocktail $cocktail): CocktailResource
    {
        return new CocktailResource($cocktail->load(['type', 'ingredients']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cocktail $cocktail): CocktailResource
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'instructions' => 'nullable|string',
            'image_url'    => 'nullable|url',
            'type_id'      => 'required|exists:types,id',
            'ingredients'  => 'array',
            'ingredients.*'=> 'exists:ingredients,id',
        ]);

        $cocktail->update([
            'name'         => $data['name'],
            'description'  => $data['description'] ?? null,
            'instructions' => $data['instructions'] ?? null,
            'type_id'      => $data['type_id'],
        ]);

        if (isset($data['ingredients'])) {
            $cocktail->ingredients()->sync($data['ingredients']);
        }

        return new CocktailResource($cocktail->load(['type','ingredients']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cocktail $cocktail)
    {
        $cocktail->delete();

        return response()->noContent();
    }
}
