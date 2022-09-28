<?php

namespace App\Http\Controllers;

use App\Models\IbsArea;
use App\Models\IbsUserPermission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IbsAreaController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
    $this->permission = new IbsUserPermission();
    $this->area = new IbsArea();
  }
  public function index(Request $request)
  {
    $permission = $this->permission->check_access('/ibs_area');
    if ($permission->read == 1) {
      if ($request->ajax()) {

        # code...
        // $records = User::all();
        $data = ([
          'title' => 'Master Area',
          'records' => $this->area::all(),
          'permission' => $permission
        ]);
        $result = view('hrd.area.index_ajax', $data)->render();
        return response()->json($result);
      } else {
        return view('hrd.area.index')->with([
          'title' => 'Master Area',
          'records' => $this->area::all(),
          'permission' => $permission
        ]);
      }
      # code...
    } else {
      return redirect('dashboard')->with('error', "You don't have permission!");
    }
  }

  public function create()
  {
    return view('hrd.area.add')->with([
      'title' => 'Create Area'
    ]);
  }

  public function show($id)
  {
    //
  }

  public function edit($id)
  {
    //
    return view('hrd.area.edit')->with([
      'title' => 'Edit Area',
      'record' => $this->area::find($id)
    ]);
  }

  public function store(Request $request)
  {
    //
    $validated = $request->validate([
      'name' => 'required|unique:ibs_areas'
    ]);

    try {
      DB::beginTransaction();

      IbsArea::create($request->all());

      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }
    // print_r($data);

    return redirect('/hrd/area')->with('success', 'Data created successfully!');
  }

  public function update(Request $request, $id)
  {
    //
    try {
      DB::beginTransaction();

      IbsArea::find($id)->update($request->all());

      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }
    // print_r($data);

    return redirect('/hrd/area')->with('success', 'Data updated successfully!');
  }


  public function destroy($id)
  {
    //
  }
}
