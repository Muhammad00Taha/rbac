<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'section_id' => $this->section_id,
            'section' => [
                'id' => $this->section?->id,
                'name' => $this->section?->name,
            ],
            'teacher_id' => $this->teacher_id,
            'teacher' => [
                'id' => $this->teacher?->id,
                'name' => $this->teacher?->name,
                'email' => $this->teacher?->email,
            ],
            'capacity' => $this->capacity,
            'status' => $this->status,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
