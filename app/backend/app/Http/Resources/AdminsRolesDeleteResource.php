<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class AdminsRolesDeleteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $dateTime = Carbon::now()->format('Y-m-d H:i:s');
        return [
            'admin_id'   => $request->id,
            'updated_at' => $dateTime,
            'deleted_at' => $dateTime
        ];
    }
}
