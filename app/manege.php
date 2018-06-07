<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class manege extends Model
{
  protected $table = 'manege';
  public $timestamps = false;
  protected $fillable = ['nom',
    'nb_places_reservables',
    'duree',
    'heure_ouverture',
    'heure_fermeture',
    'numero_plan',
    'consignes'];
}
