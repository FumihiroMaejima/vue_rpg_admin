<?php

namespace App\Http\Resources\Game;

use Illuminate\Http\Resources\Json\JsonResource;

class GameEnemiesUpdateNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'pretext'   => PHP_EOL,
            'title'     => 'Update Enemy Notification',
            'titleLink' => '',
            'content'   => 'content text' . PHP_EOL,
            'color'     => 'good',
            'id'        => $request->id,
            'name'      => $request->name,
            'status'    => ':ok:',
            'detail'    => '```'. $this->resource . PHP_EOL . '```'
        ];
    }
}
