<?php

namespace App\Repositories\GameEnemies;

use Illuminate\Support\Collection;

interface GameEnemiesRepositoryInterface
{
    public function getGameEnemies(): Collection;

    public function getGameEnemiesList(): Collection;

    public function getLatestGameEnemies(): object;

    public function createGameEnemies(array $resource): int;

    public function updateGameEnemiesData(array $resource, int $id): int;

    public function deleteGameEnemiesData(array $resource, array $ids): int;
}
