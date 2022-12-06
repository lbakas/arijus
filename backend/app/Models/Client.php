<?php

namespace App\Models;

use App\Helpers\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public static $rules = array(
        'date' => 'bail|required',
    );
}
