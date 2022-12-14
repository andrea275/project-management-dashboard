<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvitationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'token' => $this->token,
            'email' => $this->email,
            'isAdmin' => $this->is_admin,
            'user' => new UserResource($this->user),
            'project' => new ProjectResource($this->project)
        ];
    }
}
