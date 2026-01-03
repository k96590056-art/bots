<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsdtFieldsToWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdraws', function (Blueprint $table) {
            // USDT钱包地址
            $table->string('usdt_address', 100)->nullable()->comment('USDT钱包地址');
            // 网络类型(TRC20/ERC20)
            $table->string('usdt_network', 20)->nullable()->comment('网络类型(TRC20/ERC20)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdraws', function (Blueprint $table) {
            $table->dropColumn(['usdt_address', 'usdt_network']);
        });
    }
}
