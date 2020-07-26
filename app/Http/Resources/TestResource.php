<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
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
            'type'          => 'tests',
            'id'            => (string)$this->id,
            'attributes'    => [
                'name' => $this->name,
            ],
            'identifier' => crypt($this->id,'YES'),

//                'self' => route('testrun', ['test' => crypt($this->id,'YES')]),

        ];
    }
}
