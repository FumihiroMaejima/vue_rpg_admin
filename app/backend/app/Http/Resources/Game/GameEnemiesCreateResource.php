<?php

namespace App\Http\Resources\Game;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class GameEnemiesCreateResource extends JsonResource
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

        $response = [];

        foreach ($this->resource as $key => $item) {
            if ($key !== 0) {
                $response[] = [
                    'name'                 => $item[0],
                    'level'                => $item[1],
                    'hp'                   => $item[2],
                    'mp'                   => $item[3],
                    'offence'              => $item[4],
                    'defense'              => $item[5],
                    'speed'                => $item[6],
                    'magic'                => $item[7],
                    'offence_equipment_id' => 1,
                    'defense_equipment_id' => 1,
                    'encount_area_id'      => 1,
                    'image_name'           => $item[0] . '_' . $key . '_' . $dateTime,
                    'image_url'            => $item[0] . '_' . $key . '_' . $dateTime,
                    'created_at'           => $dateTime,
                    'updated_at'           => $dateTime
                ];
            }
        }

        return $response;
    }
}
