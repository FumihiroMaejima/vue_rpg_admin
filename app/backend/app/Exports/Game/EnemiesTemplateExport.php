<?php

namespace App\Exports\Game;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class EnemiesTemplateExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    use Exportable;

    private $resource;

    /**
     * @param \Illuminate\Support\Collection $resource
     * @return void
     */
    public function __construct(Collection $collection)
    {
        $this->resource = $collection;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->resource;
    }

    /**
     * setting file headers
     * @return array
     */
    public function headings(): array
    {
        return [
            '敵キャラクター名',
            'レベル',
            'HP',
            'MP',
            '攻撃力',
            '守備力',
            '素早さ',
            '魔力'
        ];
    }

    /**
     * setting sheet title (Excel only)
     * @return string
     */
    public function title(): string
    {
        return '敵キャラクター作成テンプレート';
    }

    /**
     * 1行あたりのデータの設定を行う
     * @return string
     */
    public function map($item): array
    {
        // return $data;
        return [
            'name'    => $item->name,
            'level'   => $item->level,
            'hp'      => $item->hp,
            'mp'      => $item->mp,
            'offence' => $item->offence,
            'defense' => $item->defense,
            'speed'   => $item->speed,
            'magic'   => $item->magic
        ];
    }
}
