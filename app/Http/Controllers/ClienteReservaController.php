<?php namespace App\Http\Controllers;

use App\Cliente;
use App\Reserva;

use Illuminate\Http\Request;

class ClienteReservaController extends Controller
{

	public function __construct()
	{
		$this->middleware('oauth', ['except' => ['index']]);
	}

	public function index($cliente_id)
	{
		$cliente = $this->buscar(Cliente::class, $cliente_id);
			
		$reservas = $cliente->reservas;

		return $this->crearRespuesta($reservas, 200);
	}

	public function store(Request $request, $cliente_id)
	{
		$cliente = Cliente::find($cliente_id);

		if($cliente)
		{
			$this->validacion($request);

			$campos = $request->all();
			$campos['cliente_id'] = $cliente_id;

			Reserva::create($campos);

			return $this->crearRespuesta('El reserva se ha creado satisfactoriamente', 200);
		}

		return $this->crearRespuestaError('No existe un cliente con el id dado', 404);
	}

	public function update(Request $request, $cliente_id, $reserva_id)
	{
		$cliente = Cliente::find($cliente_id);

		if($cliente)
		{
			$reserva = Reserva::find($reserva_id);

			if($reserva)
			{
				$this->validacion($request);

				$reserva->titulo = $request->get('titulo');
				$reserva->descripcion = $request->get('descripcion');
				$reserva->valor = $request->get('valor');
				$reserva->cliente_id = $cliente_id;

				$reserva->save();

				return $this->crearRespuesta('El reserva se ha actualizado', 200);
			}

			return $this->crearRespuestaError('No existe un reserva con el id dado', 404);
		}

		return $this->crearRespuestaError('No existe un cliente con el id dado', 404);
	}

	public function destroy($cliente_id, $reserva_id)
	{
		$cliente = Cliente::find($cliente_id);

		if($cliente)
		{
			$reservas = $cliente->reservas();

			if($reservas->find($reserva_id))
			{
				$reserva = Reserva::find($reserva_id);

				$reserva->servicios()->detach();

				$reserva->delete();

				return $this->crearRespuesta('Reserva eliminado', 200);
			}
			return $this->crearRespuestaError('No existe un reserva con este id asociado a este cliente', 404);

		}
		return $this->crearRespuestaError('No existe un cliente con el id dado', 404);
	}

	public function validacion($request)
	{
		$reglas = 
		[
			'titulo' => 'required',
			'descripcion' => 'required',
			'valor' => 'required|numeric'
		];

		$this->validate($request, $reglas);
	}
}