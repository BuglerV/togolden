<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable('comments')){			
			Schema::create('comments', function (Blueprint $table) {
				$table->id();
				$table->string('field')->nullable();
				$table->text('text');
				$table->text('author');
				$table->timestamps();
			});
		}
		
		Schema::table('comments', function (Blueprint $table) {
			$table->foreignId('user_id')->nullable()->constrained();
			$table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('comments');
    }
};
