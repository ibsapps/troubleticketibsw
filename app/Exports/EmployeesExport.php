<?php

namespace App\Exports;

use App\Models\IbsEmployee;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return IbsEmployee::all();
    }
}
