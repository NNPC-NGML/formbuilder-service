<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormResource extends JsonResource
{

    /**
     * @OA\Schema(
     *     schema="FormResource",
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
            "name" => $this->name,
            "json_form" =>  $this->json_form,
            "process_flow_id" => $this->process_flow_id,
            "process_flow_step_id" => $this->process_flow_step_id,
            "tag_id" => $this->tag_id,
            "form_data" => $this->activeFormdata,
        ];
    }
}
