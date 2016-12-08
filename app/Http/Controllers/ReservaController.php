<?php namespace App\Http\Controllers;

use App\Reserva;

class ReservaController extends Controller
{
	public function index()
	{
		$reservas = Reserva::all();
		return $this->crearRespuesta($reservas, 200);
	}

	public function show($id)
	{
		$reserva = $this->buscar(Reserva::class, $id);
		
		return $this->crearRespuesta($reserva, 200);
	}
}