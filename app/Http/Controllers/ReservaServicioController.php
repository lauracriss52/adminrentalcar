<?php namespace App\Http\Controllers;

use App\Reserva;
use App\Servicio;

class ReservaServicioController extends Controller
{

	public function __construct()
	{
		$this->middleware('oauth', ['except' => ['index']]);
	}

	public function index($reserva_id)
	{
		$reserva = $this->buscar(Reserva::class, $reserva_id);


		$servicios = $reserva->servicios;

		return $this->crearRespuesta($servicios, 200);
	}

	public function store($reserva_id, $servicio_id)
	{
		$reserva = Reserva::find($reserva_id);

		if($reserva)
		{
			$servicio = Servicio::find($servicio_id);

			if($servicio)
			{
				$servicios = $reserva->servicios();

				if($servicios->find($servicio_id))
				{
					return $this->crearRespuesta("El servicio $servicio_id ya existe en este reserva", 409);
				}

				$reserva->servicios()->attach($servicio_id);

				return $this->crearRespuesta("El servicio $servicio_id ha sido agregado al reserva $reserva_id", 201);
			}

			return $this->crearRespuestaError('No se puede encontrar un servicio con el id dado', 404);

		}

		return $this->crearRespuestaError('No se puede encontrar un reserva con el id dado', 404);
	}

	public function destroy($reserva_id, $servicio_id)
	{
		$reserva = Reserva::find($reserva_id);

		if($reserva)
		{
			$servicios = $reserva->servicios();

			if($servicios->find($servicio_id))
			{
				$servicios->detach($servicio_id);

				return $this->crearRespuesta('El servicio de eliminó', 200);
			}

			return $this->crearRespuestaError('No existe un servicio con el id dado en este reserva', 404);
		}

		return $this->crearRespuestaError('No se puede encontrar un reserva con el id dado', 404);
	}
}