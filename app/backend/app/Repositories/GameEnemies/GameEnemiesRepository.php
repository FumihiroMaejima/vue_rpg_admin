<?php

namespace App\Repositories\GameEnemies;

use App\Models\Role;
use App\Models\GameEnemies;
use App\Models\GameOffenceEquipment;
use App\Models\GameDefenseEquipment;
use App\Models\RolePermissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class GameEnemiesRepository implements GameEnemiesRepositoryInterface
{
    protected $model;
    protected $offenceEquipmentModel;
    protected $defenseEquipmentModel;

    /**
     * Create a new GameEnemiesRepository instance.
     * @param \App\Models\GameEnemies $model
     * @param \App\Models\GameOffenceEquipment $offenceEquipmentModel
     * @param \App\Models\RolePermissions $defenseEquipmentModel
     * @return void
     */
    public function __construct(GameEnemies $model, GameOffenceEquipment $offenceEquipmentModel, GameDefenseEquipment $defenseEquipmentModel)
    {
        $this->model = $model;
        $this->offenceEquipmentModel = $offenceEquipmentModel;
        $this->defenseEquipmentModel = $defenseEquipmentModel;
    }

    /**
     * Get All Role Data.
     *
     * @return Collection
     */
    public function getGameEnemies(): Collection
    {
        // game_enemies
        $enemies = $this->model->getTable();
        // game_offence_equipment
        $offenceEquipment = $this->offenceEquipmentModel->getTable();
        // game_defense_equipment
        $defenseEquipment = $this->defenseEquipmentModel->getTable();

        $row = [
            $enemies . '.id',
            $enemies . '.name',
            $enemies . '.level',
            $enemies . '.hp',
            $enemies . '.mp',
            $enemies . '.offence',
            $enemies . '.defense',
            $enemies . '.speed',
            $enemies . '.magic'
        ];

        // collection
        return DB::table($enemies)
            ->select($row)
            ->leftJoin($offenceEquipment, $enemies . '.offence_equipment_id', '=', $offenceEquipment . '.id')
            ->leftJoin($defenseEquipment, $enemies . '.defense_equipment_id', '=', $defenseEquipment . '.id')
            ->where($enemies . '.deleted_at', '=', null)
            ->where($offenceEquipment . '.deleted_at', '=', null)
            ->where($defenseEquipment . '.deleted_at', '=', null)
            ->get();
    }

    /**
     * Get GameEnemies as List.
     *
     * @return Collection
     */
    public function getGameEnemiesList(): Collection
    {
        // game_enemies
        $enemies = $this->model->getTable();

        // collection
        return DB::table($enemies)
            ->select([$enemies . '.id', $enemies . '.name'])
            ->get();
    }

    /**
     * get Latest Role data.
     *
     * @return \Illuminate\Database\Eloquent\Model|object|static|null
     */
    public function getLatestGameEnemies(): object
    {
        return DB::table($this->model->getTable())
            ->latest()
            ->first();
    }

    /**
     * create Admin data.
     *
     * @return int
     */
    public function createGameEnemies(array $resource): int
    {
        return DB::table($this->model->getTable())->insert($resource);
    }

    /**
     * update Role data.
     *
     * @return int
     */
    public function updateGameEnemiesData(array $resource, int $id): int
    {
        // game_enemies
        $enemies = $this->model->getTable();

        // Query Builderのupdate
        return DB::table($enemies)
            // ->whereIn('id', [$id])
            ->where('id', '=', [$id])
            ->where('deleted_at', '=', null)
            ->update($resource);
    }

    /**
     * delete Enemies data.
     * @param array $resource
     * @param array $ids
     * @return int
     */
    public function deleteGameEnemiesData(array $resource, array $ids): int
    {
        // game_enemies
        $enemies = $this->model->getTable();

        return DB::table($enemies)
            ->whereIn('id', $ids)
            // ->where('id', '=', $id)
            ->where('deleted_at', '=', null)
            ->update($resource);
    }
}
