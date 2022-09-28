<?php

namespace App\Http\Controllers;

use App\Models\IbsUserPermission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NameController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
    $this->permission = new IbsUserPermission();
  }
  public function index(Request $request)
  {
    //
  }

  public function create()
  {
    //
  }

  public function show($id)
  {
    //
  }

  public function edit($id)
  {
    //
  }

  public function store(Request $request)
  {
    //
  }

  public function update(Request $request, $id)
  {
    //
    try {
      DB::beginTransaction();

      // IbsDepartment::find($id)->update($request->all());

      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }
    // print_r($data);

    // return redirect('/hrd/employee')->with('success', 'Data updated successfully!');
  }


  public function destroy($id)
  {
    //
  }
}
