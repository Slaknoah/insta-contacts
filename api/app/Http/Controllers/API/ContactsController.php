<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Services\Contacts\BookmarkContact;
use App\Services\Contacts\LoadContacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('index', 'bookmark', 'getUserContacts');
    }

    public function index( Request $request )
    {
        $loadContacts   = new LoadContacts( $request->all() );
        $contacts       = $loadContacts->load();

        return ContactResource::collection( $contacts )->response();
    }

    public function getUserContacts( Request $request )
    {
        $loadContacts   = new LoadContacts( $request->all() );
        $contacts       = $loadContacts->loadUserContacts();

        return ContactResource::collection( $contacts )->response();
    }

    public function bookmark( Contact $contact )
    {
        $bookmarkContact = new BookmarkContact( $contact );
        $bookmarked      = $bookmarkContact->toggle();

        return response()->json( $bookmarked, 201 );
    }
}
