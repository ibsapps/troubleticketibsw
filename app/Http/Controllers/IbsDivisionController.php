<?php

namespace App\Http\Controllers;

use App\Models\IbsDivision;
use App\Models\IbsUserPermission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IbsDivisionController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
    $this->permission = new IbsUserPermission();
    $this->division = new IbsDivision();
  }
  public function index(Request $request)
  {
    $permission = $this->permission->check_access('/ibs_division');
    if ($permission->read == 1) {
      if ($request->ajax()) {

        # code...
        // $records = User::all();
        $data = ([
          'title' => 'Master Division',
          'records' => $this->division::all(),
          'permission' => $permission
        ]);
        $result = view('hrd.division.index_ajax', $data)->render();
        return response()->json($result);
      } else {
        return view('hrd.division.index')->with([
          'title' => 'Master Division',
          'records' => $this->division::all(),
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
    return view('hrd.division.add')->with([
      'title' => 'Create Division'
    ]);
  }

  public function show($id)
  {
    //
  }

  public function edit($id)
  {
    //
    return view('hrd.division.edit')->with([
      'title' => 'Edit Division',
      'record' => $this->division::find($id)
    ]);
  }

  public function store(Request $request)
  {
    //
    $validated = $request->validate([
      'name' => 'required|unique:ibs_divisions'
    ]);

    try {
      DB::beginTransaction();

      IbsDivision::create($request->all());

      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }
    // print_r($data);

    return redirect('/hrd/division')->with('success', 'Data created successfully!');
  }

  public function update(Request $request, $id)
  {
    //
    try {
      DB::beginTransaction();

      IbsDivision::find($id)->update($request->all());

      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }
    // print_r($data);

    return redirect('/hrd/division')->with('success', 'Data updated successfully!');
  }


  public function destroy($id)
  {
    //
  }
}
