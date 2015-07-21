<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignDiaHorario extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::table('horarios', function (Blueprint $table) {

    	$table->integer('dia_id')->nullable();

    	$table->foreign('dia_id')->references('id')->on('dias')->onUpdate('cascade')->onDelete('cascade');

		});
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$table->dropForeign('horarios_dia_id_foreign');
	}

}
