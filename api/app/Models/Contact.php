<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contacts';

    protected $guarded = [];

    /**
     * A contact has many bookmarks
     */
    public function bookmarks()
    {
        return $this->belongsToMany('App\Models\User', 'contacts_bookmarks', 'contact_id', 'user_id');
    }
}
