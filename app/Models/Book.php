<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'books';

    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'isbn', 'author', 'quantity', 'user_id'];
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(App\Models\User::class);
    }

}
