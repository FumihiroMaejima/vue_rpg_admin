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
         * game_ablity table
         */
        Schema::create('game_ability', function (Blueprint $table) {
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
         * game_area table
         */
        Schema::create('game_area', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名前');
            $table->text('message')->comment('エリアの説明');
            $table->string('image_name', 255)->unique()->comment('イメージネーム');
            $table->string('image_url', 255)->unique()->comment('イメージパス');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * game_defense_equipment table
         */
        Schema::create('game_defense_equipment', function (Blueprint $table) {
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
         * game_offence_equipment table
         */
        Schema::create('game_offence_equipment', function (Blueprint $table) {
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
         * game_enemies table
         */
        Schema::create('game_enemies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名前');
            $table->integer('level')->default(1)->comment('レベル');
            $table->integer('hp')->default(20)->comment('ヒットポイント');
            $table->integer('mp')->default(0)->comment('マジックポイント');
            $table->integer('offence')->default(18)->comment('攻撃力');
            $table->integer('defense')->default(12)->comment('守備力');
            $table->integer('speed')->default(10)->comment('素早さ');
            $table->integer('magic')->default(0)->comment('魔力');
            $table->foreignId('offence_equipment_id')->constrained('game_offence_equipment')->comment('攻撃用装備');
            $table->foreignId('defense_equipment_id')->constrained('game_defense_equipment')->comment('守備用装備');
            $table->integer('ability1_id')->nullable()->comment('能力1');
            $table->integer('ability2_id')->nullable()->comment('能力2');
            $table->integer('ability3_id')->nullable()->comment('能力3');
            $table->text('item')->nullable()->comment('持ち物');
            $table->tinyInteger('event_only_flg')->default(0)->comment('イベントのみ出現フラグ');
            $table->integer('encount_area_id')->comment('出現エリアID');
            $table->string('image_name', 255)->unique()->comment('イメージネーム');
            $table->string('image_url', 255)->unique()->comment('イメージパス');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * game_character table
         */
        Schema::create('game_character', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名前');
            $table->foreignId('enemy_id')->constrained('game_enemies')->nullable()->comment('敵キャラクターID');
            $table->string('image_name', 255)->unique()->comment('イメージネーム');
            $table->string('image_url', 255)->unique()->comment('イメージパス');
            $table->tinyInteger('dead_flg')->default(0)->comment('死亡済みフラグ');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * game_event table
         */
        Schema::create('game_event', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名前');
            $table->foreignId('area_id')->constrained('game_area')->comment('エリア名ID'); // テーブル名とid名が一致する場合
            $table->tinyInteger('character_id1')->comment('キャラクターID1');
            $table->tinyInteger('character_id2')->comment('キャラクターID2');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * game_item table
         */
        Schema::create('game_item', function (Blueprint $table) {
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
         * game_title table
         */
        Schema::create('game_title', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名前');
            $table->text('message')->comment('タイトルの説明');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * game_player table
         */
        Schema::create('game_player', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名前');
            $table->integer('level')->default(1)->comment('レベル');
            $table->integer('hp')->default(20)->comment('ヒットポイント');
            $table->integer('mp')->default(0)->comment('マジックポイント');
            $table->integer('offence')->default(18)->comment('攻撃力');
            $table->integer('defense')->default(12)->comment('守備力');
            $table->integer('speed')->default(10)->comment('素早さ');
            $table->integer('magic')->default(0)->comment('魔力');
            $table->foreignId('offence_equipment_id')->constrained('game_offence_equipment')->comment('攻撃用装備');
            $table->foreignId('defense_equipment_id')->constrained('game_defense_equipment')->comment('守備用装備');
            $table->integer('ability1_id')->nullable()->comment('能力1');
            $table->integer('ability2_id')->nullable()->comment('能力2');
            $table->integer('ability3_id')->nullable()->comment('能力3');
            $table->foreignId('title_id')->constrained('game_title')->default(1)->comment('肩書き');
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
         * game_player_log table
         */
        Schema::create('game_player_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('game_player')->comment('プレイヤーID');
            $table->string('function', 255)->comment('実行ファンクション');
            $table->string('status', 255)->comment('ステータス');
            $table->timestamp('action_time')->comment('実行日時');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * game_player_item_list table
         */
        Schema::create('game_player_item_list', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('game_player')->comment('プレイヤーID');
            $table->integer('content1')->nullable()->comment('コンテンツ1');
            $table->integer('content2')->nullable()->comment('コンテンツ2');
            $table->integer('content3')->nullable()->comment('コンテンツ3');
            $table->integer('content4')->nullable()->comment('コンテンツ4');
            $table->integer('content5')->nullable()->comment('コンテンツ5');
            $table->integer('content6')->nullable()->comment('コンテンツ6');
            $table->integer('content7')->nullable()->comment('コンテンツ7');
            $table->integer('content8')->nullable()->comment('コンテンツ8');
            $table->integer('content9')->nullable()->comment('コンテンツ9');
            $table->integer('content10')->nullable()->comment('コンテンツ10');
            $table->integer('content11')->nullable()->comment('コンテンツ11');
            $table->integer('content12')->nullable()->comment('コンテンツ12');
            $table->integer('content13')->nullable()->comment('コンテンツ13');
            $table->integer('content14')->nullable()->comment('コンテンツ14');
            $table->integer('content15')->nullable()->comment('コンテンツ15');
            $table->integer('content16')->nullable()->comment('コンテンツ16');
            $table->integer('content17')->nullable()->comment('コンテンツ17');
            $table->integer('content18')->nullable()->comment('コンテンツ18');
            $table->integer('content19')->nullable()->comment('コンテンツ19');
            $table->integer('content20')->nullable()->comment('コンテンツ20');
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
        Schema::dropIfExists('game_ability');
        Schema::dropIfExists('game_area');
        Schema::dropIfExists('game_defense_equipment');
        Schema::dropIfExists('game_offence_equipment');
        Schema::dropIfExists('game_enemies');
        Schema::dropIfExists('game_character');
        Schema::dropIfExists('game_event');
        Schema::dropIfExists('game_item');
        Schema::dropIfExists('game_title');
        Schema::dropIfExists('game_player');
        Schema::dropIfExists('game_player_log');
        Schema::dropIfExists('game_player_item_list');
    }
}
