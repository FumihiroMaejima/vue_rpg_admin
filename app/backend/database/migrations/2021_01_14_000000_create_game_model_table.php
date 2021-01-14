<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * ablity table
         */
        Schema::create('ability', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名前');
            $table->string('target_column1', 255)->comment('対象カラム1');
            $table->tinyInteger('target_effect1')->comment('対象に対する効果1');
            $table->string('target_column2', 255)->nullable()->comment('対象カラム2');
            $table->tinyInteger('target_effect2')->nullable()->comment('対象に対する効果2');
            $table->text('message')->comment('メッセージ');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * area table
         */
        Schema::create('area', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名前');
            $table->text('message')->comment('エリアの説明');
            $table->string('image_name', 255)->unique()->comment('イメージネーム');
            $table->string('image_url', 255)->unique()->comment('イメージパス');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * diffense_equipment table
         */
        Schema::create('diffense_equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名前');
            $table->text('message')->comment('装備品の説明');
            $table->string('target_column1', 255)->comment('対象カラム1');
            $table->tinyInteger('target_effect1')->comment('対象に対する効果1');
            $table->string('target_column2', 255)->nullable()->comment('対象カラム2');
            $table->tinyInteger('target_effect2')->nullable()->comment('対象に対する効果2');
            $table->string('image_name', 255)->unique()->comment('イメージネーム');
            $table->string('image_url', 255)->unique()->comment('イメージパス');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * enemy table
         */
        Schema::create('enemy', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名前');
            $table->integer('level')->default(1)->comment('レベル');
            $table->integer('hp')->default(20)->comment('ヒットポイント');
            $table->integer('mp')->default(0)->comment('マジックポイント');
            $table->integer('offence')->default(18)->comment('攻撃力');
            $table->integer('diffense')->default(12)->comment('守備力');
            $table->integer('speed')->default(10)->comment('素早さ');
            $table->integer('magic')->default(0)->comment('魔力');
            $table->integer('offence_equipment')->nullable()->comment('攻撃用装備');
            $table->integer('diffense_equipment')->nullable()->comment('守備用装備');
            // $table->integer('ability1')->nullable()->comment('能力1');
            // $table->integer('ability2')->nullable()->comment('能力2');
            // $table->integer('ability3')->nullable()->comment('能力3');
            $table->foreignId('ability1')->constrained('ability')->nullable()->comment('能力1');
            $table->foreignId('ability2')->constrained('ability')->nullable()->comment('能力2');
            $table->foreignId('ability3')->constrained('ability')->nullable()->comment('能力3');
            $table->text('item')->nullable()->comment('持ち物');
            $table->tinyInteger('event_only_flg')->default(0)->comment('イベントのみ出現フラグ');
            $table->integer('emcount_area_id')->comment('出現エリアID');
            $table->string('image_name', 255)->unique()->comment('イメージネーム');
            $table->string('image_url', 255)->unique()->comment('イメージパス');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * character table
         */
        Schema::create('character', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名前');
            // $table->integer('enemy_id')->nullable()->comment('敵キャラクターID');
            $table->foreignId('enemy_id')->constrained('enemy')->nullable()->comment('敵キャラクターID');
            $table->string('image_name', 255)->unique()->comment('イメージネーム');
            $table->string('image_url', 255)->unique()->comment('イメージパス');
            $table->tinyInteger('dead_flg')->default(0)->comment('死亡済みフラグ');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * event table
         */
        Schema::create('event', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名前');
            // $table->integer('area_id')->comment('エリア名ID');
            $table->foreignId('area_id')->constrained('area')->comment('エリア名ID'); // テーブル名とid名が一致する場合
            $table->tinyInteger('character_id1')->comment('キャラクターID1');
            $table->tinyInteger('character_id2')->comment('キャラクターID2');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * item table
         */
        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名前');
            $table->text('message')->comment('アイテムの説明');
            $table->string('target_column1', 255)->comment('対象カラム1');
            $table->tinyInteger('target_effect1')->comment('対象に対する効果1');
            $table->string('target_column2', 255)->nullable()->comment('対象カラム2');
            $table->tinyInteger('target_effect2')->nullable()->comment('対象に対する効果2');
            $table->string('image_name', 255)->unique()->comment('イメージネーム');
            $table->string('image_url', 255)->unique()->comment('イメージパス');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * offence_equipment table
         */
        Schema::create('offence_equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名前');
            $table->text('message')->comment('装備品の説明');
            $table->string('target_column1', 255)->comment('対象カラム1');
            $table->tinyInteger('target_effect1')->comment('対象に対する効果1');
            $table->string('target_column2', 255)->nullable()->comment('対象カラム2');
            $table->tinyInteger('target_effect2')->nullable()->comment('対象に対する効果2');
            $table->string('image_name', 255)->unique()->comment('イメージネーム');
            $table->string('image_url', 255)->unique()->comment('イメージパス');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * title table
         */
        Schema::create('title', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名前');
            $table->text('message')->comment('タイトルの説明');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * player table
         */
        Schema::create('player', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名前');
            $table->integer('level')->default(1)->comment('レベル');
            $table->integer('hp')->default(20)->comment('ヒットポイント');
            $table->integer('mp')->default(0)->comment('マジックポイント');
            $table->integer('offence')->default(18)->comment('攻撃力');
            $table->integer('diffense')->default(12)->comment('守備力');
            $table->integer('speed')->default(10)->comment('素早さ');
            $table->integer('magic')->default(0)->comment('魔力');
            $table->integer('offence_equipment')->nullable()->comment('攻撃用装備');
            $table->integer('diffense_equipment')->nullable()->comment('守備用装備');
            // $table->integer('ability1')->nullable()->comment('能力1');
            // $table->integer('ability2')->nullable()->comment('能力2');
            // $table->integer('ability3')->nullable()->comment('能力3');
            $table->foreignId('ability1')->constrained('ability')->nullable()->comment('能力1');
            $table->foreignId('ability2')->constrained('ability')->nullable()->comment('能力2');
            $table->foreignId('ability3')->constrained('ability')->nullable()->comment('能力3');
            // $table->integer('title_id')->default(1)->comment('肩書き');
            $table->foreignId('title_id')->constrained('title')->default(1)->comment('肩書き');
            $table->text('item')->nullable()->comment('持ち物');
            $table->tinyInteger('special_item_flg1')->default(0)->comment('keyアイテム取得フラグ1');
            $table->tinyInteger('special_item_flg2')->default(0)->comment('keyアイテム取得フラグ2');
            $table->tinyInteger('special_item_flg3')->default(0)->comment('keyアイテム取得フラグ3');
            $table->string('revival_password', 255)->nullable()->comment('再開用パスワード');
            $table->tinyInteger('save_flg')->default(0)->comment('セーブ実行フラグ');
            $table->integer('unsaved_count')->nullable()->comment('セーブ未実行カウント');
            $table->tinyInteger('lost_flg')->default(0)->comment('敗北フラグ');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * player_log table
         */
        Schema::create('player_log', function (Blueprint $table) {
            $table->id();
            // $table->integer('player_id')->comment('プレイヤーID');
            $table->foreignId('player_id')->constrained('player')->comment('プレイヤーID');
            $table->string('function', 255)->comment('実行ファンクション');
            $table->string('status', 255)->comment('ステータス');
            $table->timestamp('action_time')->comment('実行日時');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ability');
        Schema::dropIfExists('area');
        Schema::dropIfExists('diffense_equipment');
        Schema::dropIfExists('enemy');
        Schema::dropIfExists('character');
        Schema::dropIfExists('event');
        Schema::dropIfExists('item');
        Schema::dropIfExists('offence_equipment');
        Schema::dropIfExists('title');
        Schema::dropIfExists('player');
        Schema::dropIfExists('player_log');
    }
}
