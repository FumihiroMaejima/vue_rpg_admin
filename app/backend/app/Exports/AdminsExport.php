<?php

namespace App\Exports;

use App\Models\Admins;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Collection;

class AdminsExport implements FromCollection, WithHeadings, WithTitle
{
    use Exportable;
    private $resource;

    /**
     * @param \Illuminate\Support\Collection $resource
     * @return void
     */
    public function __construct(Collection $resource)
    {
        $this->resource = $resource;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->resource;
        // return Admins::all();
    }

    /**
     * setting file headers
     * @return array
     */
    public function headings(): array
    {
        return [
            'id',
            '氏名',
            'メールアドレス',
            '権限'
        ];
    }

    /**
     * setting sheet title (Excel only)
     * @return string
     */
    public function title(): string
    {
        return 'メンバー検索結果';
    }


}
