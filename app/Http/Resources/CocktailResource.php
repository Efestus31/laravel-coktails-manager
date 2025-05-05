<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CocktailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'description'  => $this->description,
            'instructions' => $this->instructions,
            'type'         => ['id'=>$this->type->id,'name'=>$this->type->name] ?? null,
            'ingredients'  => $this->ingredients->map(fn($i)=>['id'=>$i->id,'name'=>$i->name]),
            'image_url'    => $this->image_data ? route('cocktails.image', $this->id) : null,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}
