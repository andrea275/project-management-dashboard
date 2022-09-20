<?php

namespace App\Http\Resources;

use App\Models\Project;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $array = [
            'token' => $this->token,
            'name' => $this->name,
            'email' => $this->email
        ];

        if ($this->pivot) {
            $array = array_merge($array, [
                'isAdmin' => $this->pivot->is_admin
            ]);
        }

        return $array;
    }
}
