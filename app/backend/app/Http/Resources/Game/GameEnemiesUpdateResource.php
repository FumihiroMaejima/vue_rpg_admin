<?php

namespace App\Http\Resources\Game;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class GameEnemiesUpdateResource extends JsonResource
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
            'name'       => $request->name,
            'level'      => $request->level,
            'hp'         => $request->hp,
            'mp'         => $request->mp,
            'offence'    => $request->offence,
            'defense'    => $request->defense,
            'speed'      => $request->speed,
            'magic'      => $request->magic,
            'updated_at' => $dateTime
        ];
    }
}
