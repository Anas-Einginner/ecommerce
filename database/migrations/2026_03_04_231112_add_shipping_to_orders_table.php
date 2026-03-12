<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            
$table->string('first_name')->after('user_id');
$table->string('last_name')->after('first_name');

$table->string('address1')->after('last_name');
$table->string('address2')->nullable()->after('address1');

$table->string('city')->after('address2');
$table->string('state')->after('city');
$table->string('zip')->after('state');
$table->string('country')->after('zip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
'first_name',
'last_name',
'address1',
'address2',
'city',
'state',
'zip',
'country'
]);
        });
    }
};
