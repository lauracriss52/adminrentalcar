<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
	protected $fillable = ['nombre', 'direccion', 'telefono', 'carrera'];

	public function reservas()
	{
		return $this->belongsToMany('App\Reserva');
	}
}