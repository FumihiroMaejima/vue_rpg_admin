<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Trait\ProcessingRoleDataTrait;

class RolesServiceResource extends JsonResource
{
    use ProcessingRoleDataTrait;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->processingRoleCollection($this->resource)
        ];
    }
}
