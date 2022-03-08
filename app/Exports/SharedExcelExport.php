<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SharedExcelExport implements FromCollection, WithHeadings
{
	public $collection = [];
	public $columns = [];

	function __construct($collection = [], $columns = [])
	{
		$this->collection = $collection;
		$this->columns = $columns;
	}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	return collect($this->collection);
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return $this->columns;
    }
}