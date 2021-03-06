<?php

namespace App\Http\Resources\Game;

use Illuminate\Http\Resources\Json\JsonResource;

class GameEnemiesServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $this->resourceはcollection
        // $this->resource->itemsは検索結果の各レコードをstdClassオブジェクトとして格納した配列
        return [
            'data' => $this->resource->toArray($request)
        ];
    }
}
