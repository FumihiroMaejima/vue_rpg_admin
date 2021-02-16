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
        $test = $request->query();
        $this->resource->appends($request->query())->Array();
        // $this->resource->appends($request->query())->toArray();
        // $response['data']
        // return parent::toArray($request);
        $response['data'][] = $this->resource->appends($request->query())->toArray();
        return $response;
    }
}
