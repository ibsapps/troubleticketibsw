<?php

namespace App\Imports;

use App\Models\IbsEmployee;
use App\Models\IbsPosition;
use App\Models\IbsDepartment;
use App\Models\IbsDivision;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Str;

class EmployeeImport implements ToCollection, WithHeadingRow
{
  public $data;

  public function __construct()
  {
    $this->data = collect();
    $this->employee = new IbsEmployee();
    $this->position = new IbsPosition();
    $this->department = new IbsDepartment();
    $this->division = new IbsDivision();
  }
  /**
  * @param array $row
  *
  * @return \Illuminate\Database\Eloquent\Model|null
  */
  // public function model(array $row)
  // {
  //   //return an eloquent object
  //   $model = new IbsEmployee([
  //     'nik' => $row['personnel_no'],
  //     'name' => $row['complete_name'],
  //     'contract_status' => $row['contract_status'],
  //     'entry_date' => $this->transformDate($row['start_date']),
  //     'gender' => $row['gender'],
      // 'born_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['birthdate']),
  //     'place_of_birth' => $row['birthplace'],
  //     'ktp_number' => intval($row['ktp_number']),
  //     'created_at' => date('Y-m-d H:i:s'),
  //     'created_by' => auth()->user()->id
  //   ]);

  //   $this->data->push($model);

  //   return $model;
  // }

  public function collection(Collection $rows)
  {
    //return an eloquent object
    $model = null;
    foreach ($rows as $row) {
      if (isset($row['personnel_no']) && isset($row['division']) && isset($row['department']) && isset($row['position'])) {
        # code...     
        $employee = $this->employee::findData($row['personnel_no'], 'nik');
        $division = $this->division::findData($row['division'], 'name');
        $department = $this->department::findData($row['department'], 'name');
        $position = $this->position::findData($row['position'], 'name');

        if (!$employee) { 
          $model = IbsEmployee::create([
            'ibs_division_id' => ($division != null ? $division->id : null),
            'ibs_department_id' => ($department != null ? $department->id : null),
            'ibs_position_id' => ($position != null ? $position->id : null),
            'nik' => $row['personnel_no'],
            'name' => $row['employee_name'],
            'born_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int)$row['borndate'])->format('d-m-y'),
            'place_of_birth' => $row['birthplace'],
            'gender' => $row['gender'],
            'religion' => $row['religion'],
            'marital_status' => $row['marital_status'],
            'ptkp' => $row['ptkp'],
            'origin_address' => $row['permanent_address'],
            'temporary_address' => $row['temporary_address'],
            'phone_number' => $row['personal_phone_number'],
            'smartfren_phone_number' => $row['smartfren_phone_number'],
            'email' => $row['personal_email'],
            'company_email' => $row['company_email'],
            'ktp_number' => $row['ktp'],
            'npwp' => $row['npwp'],
            'bpjs_tk' => $row['bpjs_ketenagakerjaan'],
            'bpjs_kes' => $row['bpjs_kesehatan'],
            'group' => $row['employee_group'],
            'contract_status' => $row['contract_status'],
            'cost_center' => $row['cost_center'],
            'cost_center_description' => $row['cost_center_description'],
            'sinarmas_account_number' => $row['sinarmas_account_number'],
            'mandiri_account_number' => $row['mandiri_account_number'],
            'directorate' => $row['directorate'],
            'join_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int)$row['join_date'])->format('d-m-y'),
            'contract_begin' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int)$row['contract_begin'])->format('d-m-y'),
            'contract_end' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int)$row['contract_end'])->format('d-m-y'),
            'status' => 1,
            'entry_date' => date('Y-m-d'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => auth()->user()->id
          ]);
        } 
        $this->data->push($model);
      } 
    }

    return $model;
  }

  // public function transformDate($value, $format = 'Y-m-d')
  // {
  //   try {
  //     return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
  //   } catch (\ErrorException $e) {
  //     return \Carbon\Carbon::createFromFormat($format, $value);
  //   }
  // } 
}
