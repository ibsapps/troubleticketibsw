<?php

namespace App\Http\Controllers\HR;

use Illuminate\Http\Request;
use App\Models\IbsDepartment;

use App\Models\IbsUserPermission;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class IbsDepartmentController extends Controller
{

  public function __construct()
  {
    $this->middleware(['auth','checkaccess:/ibs_department']);
    $this->permission = new IbsUserPermission();
    $this->department = new IbsDepartment();
  }
  public function index(Request $request)
  {
    $permission = $this->permission->check_access('/ibs_department');
    if ($request->ajax()) {
      $data = ([
        'title' => 'Master Department',
        'records' => $this->department::all(),
        'permission' => $permission
      ]);
      $result = view('hrd.department.index_ajax', $data)->render();
      return response()->json($result);
    } else {
      return view('hrd.department.index')->with([
        'title' => 'Master Department',
        'records' => $this->department::all(),
        'permission' => $permission
      ]);
    }
  }

  public function create()
  {
    return view('hrd.department.add')->with([
      'title' => 'Create Department'
    ]);
  }

  public function show($id)
  {
    //
  }

  public function edit($id)
  {
    //
    return view('hrd.department.edit')->with([
      'title' => 'Edit Department',
      'record' => $this->department::find($id)
    ]);
  }

  public function store(Request $request)
  {
    //
    $validated = $request->validate([
      'name' => 'required|unique:ibs_departments'
    ]);

    try {
      DB::beginTransaction();

      IbsDepartment::create($request->all());

      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }
    // print_r($data);

    return redirect('/hrd/department')->with('success', 'Data created successfully!');
  }

  public function update(Request $request, $id)
  {
    //
    try {
      DB::beginTransaction();

      IbsDepartment::find($id)->update($request->all());

      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }
    // print_r($data);

    return redirect('/hrd/department')->with('success', 'Data updated successfully!');
  }


  public function destroy($id)
  {
    //
  }
}
