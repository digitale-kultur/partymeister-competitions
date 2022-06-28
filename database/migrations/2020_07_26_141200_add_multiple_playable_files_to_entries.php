<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AddPlayableFileToEntries
 */
class AddMultiplePlayableFilesToEntries extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('entries', function (Blueprint $table) {
			if (Schema::hasColumn('entries', 'playable_file_name')) {
				$table->dropColumn('playable_file_name');
			}
			$table->integer('playable_file_id_1')->after('final_file_media_id')->nullable();
			$table->integer('playable_file_id_2')->after('playable_file_id_1')->nullable();
			$table->integer('playable_file_id_3')->after('playable_file_id_2')->nullable();
			$table->integer('playable_file_id_4')->after('playable_file_id_3')->nullable();

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
			$table->dropColumn('playable_file_id_1');
			$table->dropColumn('playable_file_id_2');
			$table->dropColumn('playable_file_id_3');
			$table->dropColumn('playable_file_id_4');
		});
	}
}
