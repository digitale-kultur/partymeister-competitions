<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AddPlayableFileToEntries
 */
class AddPlayableFileToEntries extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('entries', function (Blueprint $table) {
			$table->string('playable_file_name')->after('final_file_media_id')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('entries', function (Blueprint $table) {
			$table->dropColumn('playable_file_name');
		});
	}
}
