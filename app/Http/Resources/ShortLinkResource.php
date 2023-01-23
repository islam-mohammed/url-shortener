<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShortLinkResource extends JsonResource
{
       /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
          return [
            "id" => $this->id,
            "destination" => $this->destination,
            "slug" => $this->slug,
            "shortened_url" => $this->shortLink,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
