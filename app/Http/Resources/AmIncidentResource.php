<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AmIncidentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'date'              => $this->date,
            'am_movment_id'     => $this->am_movment_id,
            'note'              => $this->note,
            'status'            => $this->status,
            'status_label'      => $this->status ? $this->status->label() : null,
            'action'            => $this->action,
            'action_label'      => $this->action ? $this->action->label() : null,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'contract_movment'  => $this->whenLoaded('contractMovment'),
        ];
    }
}
