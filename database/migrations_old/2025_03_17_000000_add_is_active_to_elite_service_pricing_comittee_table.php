<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		Schema::table('elite_service_pricing_comittee', function (Blueprint $table) {
			
            if (!Schema::hasColumn('elite_service_pricing_comittee', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('account_id');
            }
      
		});
	}

	public function down()
	{
		Schema::table('elite_service_pricing_comittee', function (Blueprint $table) {
			$table->dropColumn('is_active');
		});
	}
};