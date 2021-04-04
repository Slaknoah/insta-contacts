<?php


namespace App\Services\Contacts;


use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class LoadContacts
{
    private $take;
    private $search;
    private $query;
    private $orderBy;
    private $orderDirection;

    public function __construct( $parameters )
    {
        $this->setLocalParameters( $parameters );
        $this->query = Contact::query();
    }

    public function load() {
        $this->applySearch();
        $this->applyOrder();

        return $this->query->paginate( $this->take );
    }

    public function loadUserContacts()
    {
        $this->applyUserBookmarked();
        $this->applySearch();
        $this->applyOrder();

        return $this->query->paginate( $this->take );
    }

    private function applySearch()
    {
        if( $this->search != '' ){
            $this->query->where(function( $query ){
                $query->where('full_name', 'LIKE', '%'.$this->search.'%');
                $query->orWhere('email', 'LIKE', '%'.$this->search.'%');
                $query->orWhere('phone_number', 'LIKE', '%'.$this->search.'%');
            });
        }
    }

    private function applyUserBookmarked()
    {
        $this->query->whereHas('bookmarks', function ( $query ) {
            $query->where('users.id', Auth::guard('sanctum')->user()->id );
        });
    }

    private function applyOrder()
    {
        $this->query->orderBy( $this->orderBy, $this->orderDirection );
    }

    private function setLocalParameters( $parameters )
    {
        $this->take             = isset( $parameters['take'] ) ? $parameters['take'] : 10;
        $this->search           = isset( $parameters['search'] ) ? $parameters['search'] : '';
        $this->orderBy          = isset( $parameters['order_by'] ) ? $parameters['order_by'] : 'full_name';
        $this->orderDirection   = isset( $parameters['order_direction'] ) ? $parameters['order_direction'] : 'ASC';
    }
}
