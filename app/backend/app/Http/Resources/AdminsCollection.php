<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdminsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // レスポンス
        $response = [];

        // $this->resourceはCollection
        // 各itemは1レコードずつのデータを持つAdminsResourceクラス
        foreach ($this->resource as $item) {
            // 各itemのresourceはstdClassオブジェクトの１レコード分のデータ
            $response['data'][] = $item->resource;
        }

        return $response;
    }
}
