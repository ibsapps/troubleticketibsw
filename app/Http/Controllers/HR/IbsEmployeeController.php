<?php

namespace App\Http\Controllers\HR;

use App\Models\IbsArea;
use App\Models\IbsDepartment;
use App\Models\IbsDivision;
use App\Models\IbsEmployee;
use App\Models\IbsPosition;
use App\Models\User;
use App\Models\IbsUserPermission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeeImport;

class IbsEmployeeController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth','checkaccess:/ibs_employee']);
    $this->permission = new IbsUserPermission();
    $this->employee = new IbsEmployee();
    $this->division = new IbsDivision();
    $this->department = new IbsDepartment();
    $this->position = new IbsPosition();
    $this->area = new IbsArea();
    $this->account = new User();
  }

  public function index(Request $request)
  {
    $permission = $this->permission->check_access('/ibs_employee');
    if ($request->ajax()) {
      $status = (isset($request->status) ? $request->status : 1);
      $record = $this->employee::where('status', $status)->get();
      $data = ([
        'title' => 'List Employee',
        'list_status' => $status, 
        'records' => $record,
        'permission' => $permission
      ]);
      $result = view('hrd.employee.index_ajax', $data)->render();
      return response()->json($result);
    } else {
      return view('hrd.employee.index')->with([
        'title' => 'List Employee',
        'records' => $this->employee->getData(null, null),
        'permission' => $permission
      ]);
    }
  }

  public function create()
  {
    // Method untuk menampilkan form create post
    $departments = $this->department->getData(null);
    $divisions = $this->division->getData(null);
    $positions = $this->position->getData(null);
    $areas = $this->area->getData(null);
    return view('hrd.employee.add')->with([
      'title' => 'Create Employee',
      'departments' => $departments,
      'divisions' => $divisions,
      'positions' => $positions,
      'areas' => $areas
    ]);
  }

  public function show($id)
  {
    $permission = $this->permission->check_access('/ibs_employee');
    // Method untuk menampilkan single post / detail dari sebuah post
    $departments = $this->department->getData(null);
    $divisions = $this->division->getData(null);
    $positions = $this->position->getData(null);
    $areas = $this->area->getData(null);
    $record = IbsEmployee::find($id);
    return view('hrd.employee.show')->with([
      'title' => 'Show Employee',
      'departments' => $departments,
      'divisions' => $divisions,
      'positions' => $positions,
      'areas' => $areas,
      'record' => $record,
      'permission' => $permission
    ]);
  }
  public function edit($id, Request $request)
  {
    if ($request->ajax()) {
      if ($request->kind) {
        $data = ([
          'kind' => $request->kind
        ]);
        $result = view('hrd.employee.partial', $data)->render();
      } else {
        $record = $this->employee::find($id);
        $departments = $this->department->getData(null);
        $divisions = $this->division->getData(null);
        $positions = $this->position->getData(null);
        $areas = $this->area->getData(null);
        $id = $request->id;
        $detail_status = $request->detail_status;
        $status = $request->status;
        $data = ([
          'title' => 'Edit Employee Reassignment',
          'record' => $record,
          'departments' => $departments,
          'divisions' => $divisions,
          'positions' => $positions,
          'areas' => $areas,
          'last_id' => $id,
          'detail_status' => $detail_status,
          'status' => $status
        ]);
        $result = view('hrd.employee.modal', $data)->render();
      }
      return response()->json($result); 
    } else {
    // Method untuk menampilkan single post / detail dari sebuah post
      $departments = $this->department->getData(null);
      $divisions = $this->division->getData(null);
      $positions = $this->position->getData(null);
      $areas = $this->area->getData(null);
      $record = IbsEmployee::find($id);
      return view('hrd.employee.edit')->with([
        'title' => 'Edit Employee',
        'departments' => $departments,
        'divisions' => $divisions,
        'positions' => $positions,
        'areas' => $areas,
        'record' => $record
      ]);
    }
    // Method untuk menampilkan halaman edit post
  }

  public function store(Request $request)
  {
    $data = $request->all();
    $validated = $request->validate([
      'nik' => 'required|unique:ibs_employees|numeric',
      'name' => 'required',
      'contract_status' => 'required',
      'entry_date' => 'required',
      'gender' => 'required',
      'born_date' => 'required',
      'ktp_number' => 'required|numeric',
      'npwp' => 'numeric',
      'bpjs_tk' => 'numeric',
      'bpjs_kes' => 'numeric',
    ]);

    try {
      DB::beginTransaction();

      IbsEmployee::create($data);

      DB::commit();
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }
    // print_r($data);

    return redirect('/hrd/employee')->with('success', 'Data created successfully!');
    // Method untuk melakukan insert / input data ke dalam database
  }

  public function update(Request $request, $id)
  {
    // $validated = $request->validate([
      //   'nik' => 'required|unique:ibs_employees|max:8|numeric',
      //   'name' => 'required',
      //   'contract_status' => 'required',
      //   'entry_date' => 'required',
      //   'gender' => 'required',
      //   'born_date' => 'required',
      //   'ktp_number' => 'required|numeric',
      //   'npwp' => 'numeric',
      //   'bpjs_tk' => 'numeric',
      //   'bpjs_kes' => 'numeric',
    // ]);
    $data = $request->all();
    try {
      DB::beginTransaction();

      if ($data['new_record']['status']=='renew') {
        // print_r($data);
        $old_record = $this->employee::find($data['id']);
        $record = ([
          'ibs_position_id' => $data['new_record']['ibs_position_id'],
          'ibs_department_id' => $data['new_record']['ibs_department_id'],
          'ibs_division_id' => $data['new_record']['ibs_division_id'],
          'area' => $data['new_record']['area'],
          'sub_area' => $data['new_record']['sub_area'],
          'ptkp' => $data['new_record']['ptkp'],
          'nik' => $old_record->nik,
          'name' => $old_record->name,
          'company_mail' => $old_record->company_email,
          'email' => $old_record->email,
          'group' => $data['new_record']['group'],
          'contract_status' => $data['new_record']['contract_status'],
          'entry_date' => $data['new_record']['entry_date'],
          'gender' => $old_record->gender,
          'born_date' => $old_record->born_date,
          'place_of_birth' => $old_record->place_of_birth,
          'passport_number' => $old_record->passport_number,
          'ktp_number' => $old_record->ktp_number,
          'npwp' => $old_record->npwp,
          'bpjs_tk' => $old_record->bpjs_tk,
          'bpjs_kes' => $old_record->bpjs_kes,
          'origin_address' => $old_record->origin_address,
          'temporary_address' => $old_record->temporary_address,
          'phone_number' => $old_record->phone_number,
          'smartfren_phone_number' => $old_record->smartfren_phone_number,
          'religion' => $old_record->religion,
          'sinarmas_bank_account' => $old_record->sinarmas_bank_account,
          'mandiri_bank_account' => $old_record->mandiri_bank_account,
          'education_location' => $old_record->education_location,
          'education_degree' => $old_record->education_degree,
          'education_major' => $old_record->education_major,
          'cost_center' => $data['new_record']['cost_center'],
          'cost_center_description' => $data['new_record']['cost_center_description'],
          'directorate' => $data['new_record']['directorate'],
          'marital_status' => $data['new_record']['marital_status'],
          'join_date' => $data['new_record']['join_date'],
          'contract_begin' => isset($data['new_record']['contract_begin']) ? $data['new_record']['contract_begin'] : null,
          'contract_end' => isset($data['new_record']['contract_end']) ? $data['new_record']['contract_end'] : null,
          'status' => 1,
          'created_at' => date('Y-m-d'),
          'created_by' => $data['new_record']['created_by']
        ]);
        $new_record = $this->employee::create($record);
      } else {
        $this->employee::find($id)->update($data);
      }

      $user_account = $this->account::where('ibs_employee_id', $id)->first();
      if ($user_account) {
        if ($data['status'] == 2 || $data['status'] == 3 ) {
          $this->account::updatedData($user_account->id, null, null);
          $this->employee::find($id)->update(['resign_date' => date('Y-m-d')]);          
        } elseif ($data['status'] == 4) {
          $this->employee::find($id)->update(['status' => $data['status'], 'reason_of_status' => $data['detail_status']]);          
          $this->account::find($data['id'])->update(['ibs_employee_id' => $new_record->id]);
        }
      }           

      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }
    // print_r($data);

    return redirect('/hrd/employee/'.$id)->with('success', 'Data updated successfully!');
  }

  public function destroy($id)
  {
    // Method untuk menghapus data post
  }

  public function void($approve)
  {
  }

  public function upload(Request $request)
  {
    // print_r($request->file);
    if ($request->file) {
      // $file = $request->file;
      // $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
      // $fileSize = $file->getSize(); //Get size of uploaded file in bytes
      //Checks to see that the valid file types and sizes were uploaded
      // $this->checkUploadedFileProperties($extension, $fileSize);
      $import = new EmployeeImport();
      // $array = Excel::toArray($import, $request->file);
      Excel::import($import, $request->file);
      // print_r($array);

      // $c = 0;
      // foreach ($array as $key => $value) {
      //   foreach ($value as $v) {
      //     // print_r($c);
      //     $record = $this->employee::findData($v['personnel_no'], 'nik');
      //     if (!$record) {

      //     // } else {
      //       // print_r('hihi');
      //     }
      //     // print_r($record);
      //     // print_r($v['personnel_no']);
      //     // print_r($c);

      //     $c ++;
      //     # code...
      //   }
      // }

      //Return a success response with the number if records uploaded
      // return response()->json([
      //   'message' => $import->data->count()." records successfully uploaded"
      // ]);
      if ($import->data->count() >= 1) {
        $data = $import->data->count()." records successfully uploaded";
      } else {
        $data = 'No data was uploaded!';
      }
      
      return redirect("/hrd/employee")->with("success", $data);
    } else {
      throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
    }
  }
}
