<?php namespace App\Http\Controllers;

use App\Cliente;

use Illuminate\Http\Request;

class ClienteController extends Controller
{

	public function __construct()
	{
		$this->middleware('oauth', ['except' => ['index', 'show']]);
	}
	
	public function index()
	{
		$clientes = Cliente::all();
		return $this->crearRespuesta($clientes, 200);
	}

	public function show($id)
	{
		$cliente = $this->buscar(Cliente::class, $id);

		return $this->crearRespuesta($cliente, 200);

		return $this->crearRespuestaError('Cliente no encontrado', 404);
	}

	public function store(Request $request)
	{
		$this->validacion($request);

		Cliente::create($request->all());

		return $this->crearRespuesta('El cliente ha sido creado', 201);
	}

	public function update(Request $request, $cliente_id)
	{
		$cliente = Cliente::find($cliente_id);

		if($cliente)
		{
			$this->validacion($request);

			$nombre = $request->get('nombre');
			$direccion = $request->get('direccion');
			$telefono = $request->get('telefono');
			$profesion = $request->get('profesion');

			$cliente->nombre = $nombre;
			$cliente->direccion = $direccion;
			$cliente->telefono = $telefono;
			$cliente->profesion = $profesion;

			$cliente->save();

			return $this->crearRespuesta("El cliente $cliente->id has sido editado", 200);
		}

		return $this->crearRespuestaError('El id especificado no corresponde a un cliente', 404);
	}

	public function destroy($cliente_id)
	{
		$cliente = Cliente::find($cliente_id);

		if($cliente)
		{
			if(sizeof($cliente->reservas) > 0)
			{
				return $this->crearRespuestaError('El cliente tiene reservas asociados. Se deben eliminar estos reservas previamente', 409);
			}
			$cliente->delete();

			return $this->crearRespuesta('El cliente ha sido eliminado', 200);
		}

		return $this->crearRespuestaError('No existe cliente con el id especificado', 404);
	}

	public function validacion($request)
	{
		$reglas = 
		[
			'nombre' => 'required',
			'direccion' => 'required',
			'telefono' => 'required',
			'profesion' => 'required|in:ingeniería,matemática,física',
		];

		$this->validate($request, $reglas);
	}
}