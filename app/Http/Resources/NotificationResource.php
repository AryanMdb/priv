<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'id' => $this->id ?? '',
            'user_id' => $this->user_id ?? '',
            'type' => $this->type ?? '',
            'title' => $this->title ?? '',
            'body' => $this->body ?? '',
            'is_read' => $this->is_read ?? '',
            'created_at' => $this?->created_at?->toDateTimeString() ?? '',
        ];
    }
}
