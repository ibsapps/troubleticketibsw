<?php

namespace App\Http\Controllers;

use App\Models\IbsEmployee;
use App\Models\IbsUserPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->permission = new IbsUserPermission();
    $this->user = new User();
    $this->employee = new IbsEmployee();
  }

  public function index(Request $request)
  {
    $permission = $this->permission->check_access('/user');
    if ($permission->read == 1) {
      if ($request->ajax()) {

        # code...
        // $records = User::all();
        $data = ([
          'title' => 'User Account',
          'records' => $this->user::all(),
          'permission' => $permission
        ]);
        $result = view('systems.user_account.index_ajax', $data)->render();
        return response()->json($result);

        // return json_encode($result);
        // return response()->json($data)->view('systems.user_permission.index', $data);
        //   ->view('systems.user_permission.index', $data, 200);
      } else {
        return view('systems.user_account.index')->with([
          'title' => 'User Account',
          'records' => $this->user::all(),
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
    // Method untuk menampilkan form create post
    $record = $this->user->getData(null);
    $employees = $this->employee->getData(null, 'users');
    return view('systems.user_account.add')->with([
      'title' => 'Add User Account',
      'record' => $record,
      'employees' => $employees
    ]);
  }

  public function show($id)
  {
    // Method untuk menampilkan single post / detail dari sebuah post
  }
  public function edit($id)
  {
    // $accessMasterMenus = $this->permission->accessMasterMenu(auth()->user()->id);
    // $accessSubMenus = $this->permission->accessSubMenu(auth()->user()->id);
    // $accessParentSubMenus = $this->permission->accessParentSubMenu(auth()->user()->id);
    $master_menus = $this->menu->master_menu();
    $sub_menus = $this->menu->sub_menu();
    $parent_sub_menus = $this->menu->parent_sub_menu();
    $prefix = $this->menu->getPrefix();
    $record = User::find($id);
    return view('systems.user_permission.edit')->with([
      'title' => 'Edit User Permission  ',
      // 'accessMasterMenu' => $accessMasterMenus,
      // 'accessSubMenu' => $accessSubMenus,
      // 'accessParentSubMenu' => $accessParentSubMenus,
      'master_menu' => $master_menus,
      'sub_menu' => $sub_menus,
      'parent_sub_menu' => $parent_sub_menus,
      'prefix' => $prefix,
      'record' => $record
    ]);
    // Method untuk menampilkan halaman edit post
  }

  public function store(Request $request)
  {
    // Method untuk melakukan insert / input data ke dalam database
    // $data = $request->all();
    $validated = $request->validate([
      'ibs_employee_id' => 'required',
      'password' => 'required',
    ]);

    try {
      DB::beginTransaction();
      $data = [
        'ibs_employee_id' => $request->ibs_employee_id,
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'fullname' => $request->fullname,
        'email' => $request->email,
        'created_by' => auth()->user()->id,
        'created_at' => date('Y-m-d H:i:s')
      ];
      User::create($data);

      DB::commit();
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }
    // print_r($data);

    return redirect('/sys/user_account')->with('success', 'Data created successfully!');
  }

  public function update(Request $request)
  {
    // Method untuk melakukan update data post ke database
    $data = $request->all();
    // print_r($data);

    // $result = array();
    // if ($request->ibs_menu_id) {
    foreach ($data['ibs_menu_id'] as $k => $v) {
      $record = $this->permission->getData($v, $request->user_id);
      if ($record) {
        $value = [
          'read' => (isset($data['read'][$v]) ? $data['read'][$v] : 0),
          'create' => (isset($data['create'][$v]) ? $data['create'][$v] : 0),
          'modify' => (isset($data['modify'][$v]) ? $data['modify'][$v] : 0),
          'void' => (isset($data['void'][$v]) ? $data['void'][$v] : 0),
          'cancel_void' => (isset($data['cancel_void'][$v]) ? $data['cancel_void'][$v] : 0),
          'print' => (isset($data['print'][$v]) ? $data['print'][$v] : 0),
          'export' => (isset($data['export'][$v]) ? $data['export'][$v] : 0),
          'approve_1' => (isset($data['approve_1'][$v]) ? $data['approve_1'][$v] : 0),
          'cancel_approve_1' => (isset($data['cancel_approve_1'][$v]) ? $data['cancel_approve_1'][$v] : 0),
          'approve_2' => (isset($data['approve_2'][$v]) ? $data['approve_2'][$v] : 0),
          'cancel_approve_2' => (isset($data['cancel_approve_2'][$v]) ? $data['cancel_approve_2'][$v] : 0),
          'approve_3' => (isset($data['approve_3'][$v]) ? $data['approve_3'][$v] : 0),
          'cancel_approve_3' => (isset($data['cancel_approve_3'][$v]) ? $data['cancel_approve_3'][$v] : 0),
          'updated_by' => $data['updated_by'],
          'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->permission->updateData($v, $data['user_id'], $value);
        // print_r("update");
      } else {
        $value = [
          'user_id' => $request->user_id,
          'ibs_menu_id' => $v,
          'read' => (isset($data['read'][$v]) ? $data['read'][$v] : 0),
          'create' => (isset($data['create'][$v]) ? $data['create'][$v] : 0),
          'modify' => (isset($data['modify'][$v]) ? $data['modify'][$v] : 0),
          'void' => (isset($data['void'][$v]) ? $data['void'][$v] : 0),
          'cancel_void' => (isset($data['cancel_void'][$v]) ? $data['cancel_void'][$v] : 0),
          'print' => (isset($data['print'][$v]) ? $data['print'][$v] : 0),
          'export' => (isset($data['export'][$v]) ? $data['export'][$v] : 0),
          'approve_1' => (isset($data['approve_1'][$v]) ? $data['approve_1'][$v] : 0),
          'cancel_approve_1' => (isset($data['cancel_approve_1'][$v]) ? $data['cancel_approve_1'][$v] : 0),
          'approve_2' => (isset($data['approve_2'][$v]) ? $data['approve_2'][$v] : 0),
          'cancel_approve_2' => (isset($data['cancel_approve_2'][$v]) ? $data['cancel_approve_2'][$v] : 0),
          'approve_3' => (isset($data['approve_3'][$v]) ? $data['approve_3'][$v] : 0),
          'cancel_approve_3' => (isset($data['cancel_approve_3'][$v]) ? $data['cancel_approve_3'][$v] : 0),
          'created_by' => auth()->user()->id,
          'created_at' => date('Y-m-d H:i:s')
        ];
        $this->permission::create($value);
        // print_r($value);
      }
    }

    return redirect()->intended('/sys/user_permission');
  }

  public function destroy($id)
  {
    // Method untuk menghapus data post
  }
}
