<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AdminCreateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /* $carbon = new Carbon();
        $test = $carbon->now()->format('Y-m-d H:i:s'); */
        $dateTime = Carbon::now()->format('Y-m-d H:i:s');

        return [
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'created_at' => $dateTime,
            'updated_at' => $dateTime
        ];
    }
}
