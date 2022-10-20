<?php

namespace App\Http\Controllers\SYS;

use App\Models\IbsUserPermission;
use App\Models\IbsVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class IbsVendorController extends Controller
{

  public function __construct()
  {
    $this->middleware(['auth','checkaccess:/ibs_vendor']);
    $this->permission = new IbsUserPermission();
    $this->vendor = new IbsVendor();
  }
  public function index(Request $request)
  {
    $permission = $this->permission->check_access('/ibs_vendor');
    $data = ([
      'title' => 'Master Vendor',
      'records' => $this->vendor::all(),
      'permission' => $permission
    ]);
    if ($request->ajax()) {
      $result = view('systems.vendor.index_ajax', $data)->render();
      return response()->json($result);
    } else {
      return view('systems.vendor.index', $data);
    }
  }

  public function create()
  {
    return view('systems.vendor.add')->with([
      'title' => 'Create Vendor'
    ]);
  }

  public function show($id)
  {
    //
  }

  public function edit($id)
  {
    //
    return view('systems.vendor.edit')->with([
      'title' => 'Edit vendor',
      'record' => $this->vendor::find($id)
    ]);
  }

  public function store(Request $request)
  {
    //
    $validated = $request->validate([
      'name' => 'required|unique:ibs_vendors'
    ]);

    try {
      DB::beginTransaction();

      $this->vendor::create($request->all());

      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }

    return redirect('/sys/vendor')->with('success', 'Data created successfully!');
  }

  public function update(Request $request, $id)
  {
    //
    $validated = $request->validate([
      'name' => 'required|unique:ibs_vendors'
    ]);

    try {
      DB::beginTransaction();

      $this->vendor::find($id)->update($request->all());

      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }

    return redirect('/sys/vendor')->with('success', 'Data updated successfully!');
  }


  public function destroy($id)
  {
    //
  }
}
