<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{

    /**
     * @OA\Schema(
     *     schema="TagResource",
     *     @OA\Property(property="id", type="integer"),
     *     @OA\Property(property="name", type="string"),
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
        ];
    }
}
