<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Servicio;
use App\Cliente;
use App\Reserva;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Servicio::truncate();
		Cliente::truncate();
		Reserva::truncate();
		DB::table('reserva_servicio')->truncate();
		DB::table('oauth_clients')->truncate();		

		factory(Cliente::class, 50)->create();

		factory(Servicio::class, 500)->create();

		factory(Reserva::class, 40)->create()
		->each(function($reserva)
			{
				$reserva->servicios()->attach(array_rand(range(1, 500),40));
			});

		$this->call('OAuthClientSeeder');
	}

}
