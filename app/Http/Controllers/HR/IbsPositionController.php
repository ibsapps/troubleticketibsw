<?php

namespace App\Http\Controllers\HR;

use App\Models\IbsPosition;
use App\Models\IbsUserPermission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IbsPositionController extends Controller
{

  public function __construct()
  {
    $this->middleware(['auth','checkaccess:/ibs_position']);
    $this->permission = new IbsUserPermission();
    $this->position = new IbsPosition();
  }
  public function index(Request $request)
  {
    $permission = $this->permission->check_access('/ibs_position');
    if ($request->ajax()) {

      # code...
      // $records = User::all();
      $data = ([
        'title' => 'Master Position',
        'records' => $this->position::all(),
        'permission' => $permission
      ]);
      $result = view('hrd.position.index_ajax', $data)->render();
      return response()->json($result);
    } else {
      return view('hrd.position.index')->with([
        'title' => 'Master Position',
        'records' => $this->position::all(),
        'permission' => $permission
      ]);
    }
  }

  public function create()
  {
    return view('hrd.position.add')->with([
      'title' => 'Create Position'
    ]);
  }

  public function show($id)
  {
    //
  }

  public function edit($id)
  {
    //
    return view('hrd.position.edit')->with([
      'title' => 'Edit Position',
      'record' => $this->position::find($id)
    ]);
  }

  public function store(Request $request)
  {
    //
    $validated = $request->validate([
      'name' => 'required|unique:ibs_positions'
    ]);

    try {
      DB::beginTransaction();

      IbsPosition::create($request->all());

      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }
    // print_r($data);

    return redirect('/hrd/position')->with('success', 'Data created successfully!');
  }

  public function update(Request $request, $id)
  {
    //
    try {
      DB::beginTransaction();

      IbsPosition::find($id)->update($request->all());

      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }
    // print_r($data);

    return redirect('/hrd/position')->with('success', 'Data updated successfully!');
  }


  public function destroy($id)
  {
    //
  }
}
