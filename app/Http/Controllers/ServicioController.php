<?php namespace App\Http\Controllers;

use App\Servicio;

use Illuminate\Http\Request;

class ServicioController extends Controller
{

	public function __construct()
	{
		$this->middleware('oauth', ['except' => ['index', 'show']]);
	}

	public function index()
	{
		$servicios = Servicio::all();
		return $this->crearRespuesta($servicios, 200);
	}

	public function show($id)
	{
		$servicio = $this->buscar(Servicio::class, $id);

		return $this->crearRespuesta($servicio, 200);
	}

	public function store(Request $request)
	{
		$this->validacion($request);

		Servicio::create($request->all());

		return $this->crearRespuesta('El servicio ha sido creado', 201);
	}

	public function update(Request $request, $servicio_id)
	{
		$servicio = Servicio::find($servicio_id);

		if($servicio)
		{
			$this->validacion($request);

			$nombre = $request->get('nombre');
			$direccion = $request->get('direccion');
			$telefono = $request->get('telefono');
			$carrera = $request->get('carrera');

			$servicio->nombre = $nombre;
			$servicio->direccion = $direccion;
			$servicio->telefono = $telefono;
			$servicio->carrera = $carrera;

			$servicio->save();

			return $this->crearRespuesta("El servicio $servicio->id has sido editado", 200);
		}

		return $this->crearRespuestaError('El id especificado no corresponde a un servicio', 404);
	}

	public function destroy($servicio_id)
	{
		$servicio = Servicio::find($servicio_id);

		if($servicio)
		{
			$servicio->reservas()->sync([]);
			$servicio->delete();

			return $this->crearRespuesta('El servicio ha sido eliminado', 200);
		}

		return $this->crearRespuestaError('No existe servicio con el id especificado', 404);
	}

	public function validacion($request)
	{
		$reglas = 
		[
			'nombre' => 'required',
			'direccion' => 'required',
			'telefono' => 'required',
			'carrera' => 'required|in:ingeniería,matemática,física',
		];

		$this->validate($request, $reglas);
	}
}