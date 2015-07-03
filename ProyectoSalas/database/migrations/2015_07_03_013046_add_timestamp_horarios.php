<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampHorarios extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('horarios', function (Blueprint $table) {
		$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('horarios', function (Blueprint $table) {

    	$table->dropColumn('created_at');
    	$table->dropColumn('updated_at');

		});
	}

}
