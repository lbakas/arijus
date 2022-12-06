<?php

namespace App\Models;

use App\Helpers\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['number', 'date', 'truckNumber', 'clientId', 'file'];

    public static $rules = array(
        'date' => 'bail|required',
        'clientId' => 'bail|required',
    );

    public function client()
    {
        return $this->belongsTo(Client::class, 'clientId')->withDefault();
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $pad_char = '0';
            $pad_length = 6;
            $str_type = 'd';
            $format = "%{$pad_char}{$pad_length}{$str_type}";

            $last = Order::query()->orderBy('id', 'DESC')->first();

            if ($last) {
              $model->number = 'U' . sprintf($format, $last->id + 1);
            } else {
              $model->number = 'U' . sprintf($format, 1);
            }
        });
    }
}
