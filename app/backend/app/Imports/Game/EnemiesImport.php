<?php

namespace App\Imports\Game;

use App\Models\GameEnemies;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Http\UploadedFile;

class EnemiesImport implements ToModel
{
    use Importable;
    private $resource;

    /**
     * create constructer.
     * @param \Illuminate\Http\UploadedFile $file
     * @return void
     */
    public function __construct(UploadedFile $file)
    {
        $this->resource = $this->toArray($file, null, \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return $this->resource;
        /* return new GameEnemies([
            //
        ]); */
    }
}
