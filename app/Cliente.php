<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
	protected $table = 'clientes';

	protected $fillable = ['nombre', 'direccion', 'telefono', 'profesion'];

	public function reservas()
	{
		return $this->hasMany('App\Reserva');
	}
}
