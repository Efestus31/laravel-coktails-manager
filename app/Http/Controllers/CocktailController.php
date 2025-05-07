<?php

namespace App\Http\Controllers;

use App\Models\Cocktail;
use App\Models\Ingredient;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CocktailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cocktails = Cocktail::with('type','ingredients')->paginate(6);
        return view('cocktails.index', compact('cocktails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        $ingredients = Ingredient::all();

        return view('cocktails.create', compact('types', 'ingredients'));
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
            'image' => 'nullable|image|max:4096',
            'type_id' => 'required|exists:types,id',
            'ingredients' => 'array|exists:ingredients,id',
        ]);

        $cocktail = new Cocktail();
        $cocktail->name = $data['name'];
        $cocktail->description = $data['description'] ?? null;
        $cocktail->instructions = $data['instructions'] ?? null;
        $cocktail->type_id = $data['type_id'];

        // Save image binary to BLOB column
        if ($request->hasFile('image')) {
            $binary = file_get_contents($request->file('image')->getRealPath());
            $cocktail->image_data = $binary;
        }

        $cocktail->save();

        if (isset($data['ingredients'])) {
            $cocktail->ingredients()->attach($data['ingredients']);
        }

        return redirect()
            ->route('cocktails.show', $cocktail)
            ->with('success', 'Cocktail creato con successo!');
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
            'image' => 'nullable|image|max:4096',
            'type_id' => 'required|exists:types,id',
            'ingredients' => 'array|exists:ingredients,id',
        ]);

        $cocktail->name = $data['name'];
        $cocktail->description = $data['description'] ?? null;
        $cocktail->instructions = $data['instructions'] ?? null;
        $cocktail->type_id = $data['type_id'];

        // Update image blob if new file uploaded
        if ($request->hasFile('image')) {
            $binary = file_get_contents($request->file('image')->getRealPath());
            $cocktail->image_data = $binary;
        }

        $cocktail->save();

        if (isset($data['ingredients'])) {
            $cocktail->ingredients()->sync($data['ingredients']);
        }

        return redirect()
            ->route('cocktails.show', $cocktail)
            ->with('success', 'Cocktail aggiornato con successo!');
    }

    /**
     * Return the image BLOB with correct MIME-type and caching headers.
     */
    public function image(Cocktail $cocktail)
    {
        if (! $cocktail->image_data) {
            abort(404);
        }

        $finfo = finfo_open();
        $mime = finfo_buffer($finfo, $cocktail->image_data, FILEINFO_MIME_TYPE);
        finfo_close($finfo);

        return response($cocktail->image_data, 200)
               ->header('Content-Type', $mime)
               ->header('Cache-Control', 'public, max-age=86400')
               ->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cocktail $cocktail)
    {
        $cocktail->ingredients()->detach();
        $cocktail->delete();

        return redirect()
            ->route('cocktails.index')
            ->with('success', 'Cocktail eliminato con successo!');
    }
}
