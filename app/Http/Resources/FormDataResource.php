<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormDataResource extends JsonResource
{

    /**
     * @OA\Schema(
     *     schema="FormDataResource",
     *     @OA\Property(property="id", type="integer"),
     *     @OA\Property(property="name", type="string"),
     *     @OA\Property(property="json_form", type="string"),
     *     @OA\Property(property="process_flow_id", type="integer")
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
        ];
    }
}
