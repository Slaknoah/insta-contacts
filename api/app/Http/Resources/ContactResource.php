<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result                 = parent::toArray($request);
        $result['bookmarks']    = $this->bookmarks()->count();
        $result['bookmarked']   = 0;

        if ( $this->bookmarks->contains( Auth::guard('sanctum')->user()->id ) )
            $result['bookmarked'] = 1;

        return $result;
    }
}
