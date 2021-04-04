<?php


namespace App\Services\Contacts;


use Illuminate\Support\Facades\Auth;

class BookmarkContact
{
    private $contact;

    public function __construct( $contact )
    {
        $this->contact = $contact;
    }

    public function toggle()
    {
        $user = Auth::guard('sanctum')->user()->id;
        if ( $this->contact->bookmarks->contains( $user ) ) {
            $this->contact->bookmarks()->detach( $user );

            return [
                'status'    => false,
                'bookmarks' => $this->contact->bookmarks->count() - 1
            ];
        } else {
            $this->contact->bookmarks()->attach( $user );

            return [
                'status'    => true,
                'bookmarks' => $this->contact->bookmarks->count() + 1
            ];
        }
    }
}
