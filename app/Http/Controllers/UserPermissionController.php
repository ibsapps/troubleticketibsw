<?php

namespace App\Http\Controllers;

use App\Models\IbsUserPermission;
use App\Models\User;
use App\Models\IbsMenu;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPermissionController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    // $this->middleware('cek_access');
    $this->permission = new IbsUserPermission();
    $this->user = new User();
    $this->menu = new IbsMenu();
    // $this->check_access('/sys_user_permission', session('id');
    // $this->UserAccess::access_read('/ibs_user_permission');
  }

  public function index(Request $request)
  {
    $permission = $this->permission->check_access('/ibs_user_permission');
    if ($permission->read == 1) {
      if ($request->ajax()) {

        # code...
        // $records = User::all();
        $data = ([
          'title' => 'User Permission',
          'records' => $this->user->listUser(),
          'permission' => $permission
        ]);
        $result = view('systems.user_permission.index_ajax', $data)->render();
        return response()->json($result);

        // return json_encode($result);
        // return response()->json($data)->view('systems.user_permission.index', $data);
        //   ->view('systems.user_permission.index', $data, 200);
      } else {
        return view('systems.user_permission.index')->with([
          'title' => 'User Permission',
          'records' => $this->user->listUser(),
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
    $master_menus = $this->menu->master_menu();
    $sub_menus = $this->menu->sub_menu();
    $parent_sub_menus = $this->menu->parent_sub_menu();
    $prefix = $this->menu->getPrefix();
    $record = $this->user->getData(null);
    return view('systems.user_permission.add')->with([
      'title' => 'Add User Permission',
      'master_menu' => $master_menus,
      'sub_menu' => $sub_menus,
      'parent_sub_menu' => $parent_sub_menus,
      'prefix' => $prefix,
      'record' => $record
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
    $data = $request->all();
    // $result = array();
    // if ($request->ibs_menu_id) {
    foreach ($data['ibs_menu_id'] as $k => $v) {
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
    }
    return redirect()->intended('/sys/user_permission');
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
