<?php

namespace App\Http\Controllers;

use App\Models\IbsArea;
use App\Models\IbsDepartment;
use App\Models\IbsDivision;
use App\Models\IbsEmployee;
use App\Models\IbsPosition;
use App\Models\IbsUserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IbsEmployeeController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->permission = new IbsUserPermission();
    $this->employee = new IbsEmployee();
    $this->division = new IbsDivision();
    $this->department = new IbsDepartment();
    $this->position = new IbsPosition();
    $this->area = new IbsArea();
  }

  public function index(Request $request)
  {
    $permission = $this->permission->check_access('/ibs_employee');
    if ($permission->read == 1) {
      if ($request->ajax()) {

        # code...
        // $records = User::all();
        $data = ([
          'title' => 'List Employee',
          'records' => $this->employee->getData(null, null),
          'permission' => $permission
        ]);
        $result = view('hrd.employee.index_ajax', $data)->render();
        return response()->json($result);

        // return json_encode($result);
        // return response()->json($data)->view('systems.user_permission.index', $data);
        //   ->view('systems.user_permission.index', $data, 200);
      } else {
        return view('hrd.employee.index')->with([
          'title' => 'List Employee',
          'records' => $this->employee->getData(null, null),
          'permission' => $permission
        ]);
      }
    } else {
      return redirect('dashboard')->with('message', "You don't have permission!");
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
  public function edit($id)
  {
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
    // Method untuk menampilkan halaman edit post
  }

  public function store(Request $request)
  {
    // $data = $request->all();
    $validated = $request->validate([
      'nik' => 'required|unique:ibs_employees|max:8|numeric',
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

      IbsEmployee::create($validated);

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
    // Method untuk melakukan update data post ke database
    try {
      DB::beginTransaction();

      IbsEmployee::find($id)->update($request->all());

      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }
    // print_r($data);

    return redirect('/hrd/employee')->with('success', 'Data updated successfully!');
  }

  public function destroy($id)
  {
    // Method untuk menghapus data post
  }

  public function void($approve)
  {
  }
}
