<?php

namespace App\Http\Controllers\HR;

use App\Models\IbsUserPermission;
use App\Models\IbsSuperior;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class IbsSuperiorController extends Controller
{

  public function __construct()
  {
    $this->middleware(['auth','checkaccess:/ibs_superior']);
    $this->permission = new IbsUserPermission();
    $this->superior = new IbsSuperior();
    $this->user = new User();
  }
  public function index(Request $request)
  {
    $permission = $this->permission->check_access('/ibs_superior');
    $data = ([
      'title' => 'Data Superior',
      'records' => $this->superior::getData('list'),
      'permission' => $permission
    ]);
    if ($request->ajax()) {
      $result = view('hrd.superior.index_ajax', $data)->render();
      return response()->json($result);
    } else {
      return view('hrd.superior.index', $data);
    }
  }

  public function create()
  {
    $data = ([
      'title' => 'Create Superior',
      'users' => $this->user->getData(null, 'list')
    ]);
    return view('hrd.superior.add', $data);
  }

  public function show($id)
  {
    //
  }

  public function edit($id)
  {
    //
    return view('hrd.superior.edit')->with([
      'title' => 'Edit superior',
      'users' => $this->user->getData(null, 'list'),
      'record' => $this->superior::find($id)
    ]);
  }

  public function store(Request $request)
  {
    $data = $request->all();
    //
    // $validated = $request->validate([
    //   'name' => 'required|unique:ibs_vendors'
    // ]);

    if ($data['superior_user_id'] == $data['user_id']) {
      return redirect()->back()->with('error', 'Superior and user data cannot be the same');
    } else {
      try {
        DB::beginTransaction();

        $this->superior::create($request->all());

        DB::commit();
        //-- done --
      } catch (\Throwable $th) {
        DB::rollBack();
        return redirect()->back()->with('error', $th->getMessage());
      }

      return redirect('/hrd/superior')->with('success', 'Data created successfully!');
    }
  }

  public function update(Request $request, $id)
  {
    $data = $request->all();
    if ($data['superior_user_id'] == $data['user_id']) {
      return redirect()->back()->with('error', 'Superior and user data cannot be the same');
    } else {
      try {
        DB::beginTransaction();

        $this->superior::find($id)->update($request->all());

        DB::commit();
        //-- done --
      } catch (\Throwable $th) {
        DB::rollBack();
        return redirect()->back()->with('error', $th->getMessage());
      }

      return redirect('/hrd/superior')->with('success', 'Data updated successfully!');
    }
  }


  public function destroy($id)
  {
    //
  }
}
