<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_add_signature_to_devis_table.php

public function up()
{
    Schema::table('devis', function (Blueprint $table) {
        $table->text('signature')->nullable(); // Champ pour stocker la signature en base64
    });
}

public function down()
{
    Schema::table('devis', function (Blueprint $table) {
        $table->dropColumn('signature');
    });
}
};
