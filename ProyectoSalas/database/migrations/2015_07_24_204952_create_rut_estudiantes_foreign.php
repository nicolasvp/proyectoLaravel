<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRutEstudiantesForeign extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('estudiantes', function ($table) {

		    $table->integer('rut')->unsigned()->unique();

		    $table->foreign('rut')->references('rut')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$table->dropForeign('estudiantes_rut_foreign');
	}

}
