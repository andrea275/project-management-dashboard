<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'uuid' => $this->uuid,
            'title' => $this->title,
            'description' => $this->description,
            'order' => $this->order,
            'status' => new StatusResource($this->status),
            'priority' => new PriorityResource($this->priority),
            'project' => new ProjectResource($this->project),
            'user' => new UserResource($this->user),
            'assignedUsers' => UserResource::collection($this->users),
            'comments' => CommentResource::collection($this->comments)
        ];
    }
}
