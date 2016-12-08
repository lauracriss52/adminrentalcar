<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
	protected $fillable = ['titulo', 'descripcion', 'valor', 'cliente_id'];

	public function cliente()
	{
		return $this->belongsTo('App\Cliente');
	}

	public function servicios()
	{
		return $this->belongsToMany('App\Servicio');
	}
}