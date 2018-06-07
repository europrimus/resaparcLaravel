<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reservation extends Model
{
    protected $table = 'reservation';
    public $timestamps = false;
    protected $fillable = ['numero_billet','horaire','id_manege'];

    public function manege()
      {
          return $this->hasOne('App\manege');
      }
}
