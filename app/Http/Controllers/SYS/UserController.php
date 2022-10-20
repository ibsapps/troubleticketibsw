<?php

namespace App\Http\Controllers\SYS;

use App\Models\IbsEmployee;
use App\Models\IbsUserPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Validator;

class UserController extends Controller
{
  public function __construct()
  {
    // $this->middleware(['auth','checkaccess:/user']);
    $this->permission = new IbsUserPermission();
    $this->user = new User();
    $this->employee = new IbsEmployee();
  }

  public function index(Request $request)
  {
    $permission = $this->permission->check_access('/user');
    if ($permission->read == 1) {
      if ($request->ajax()) {
        $data = ([
          'title' => 'User Account',
          'records' => $this->user::all(),
          'permission' => $permission
        ]);
        $result = view('systems.user_account.index_ajax', $data)->render();
        return response()->json($result);
      } else {
        return view('systems.user_account.index')->with([
          'title' => 'User Account',
          'records' => $this->user::all(),
          'permission' => $permission
        ]);
      }
    } else {
      return redirect()->back()->with('error', "You don't have permission!");
    }
  }
  public function create()
  {
    // Method untuk menampilkan form create post
    $record = $this->user->getData(null, null);
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
    $record = User::find($id);
    if (auth()->user()->ibs_employee->ibs_department_id != 0 || auth()->user()->ibs_employee->ibs_department_id != 2) {
      if (auth()->user()->id == $id) {
        return view('systems.user_account.edit')->with([
          'title' => 'Edit user account  ',
          'record' => $record
        ]);
      } else {
        return redirect()->back()->with('error', "You don't have permission!");
      }    
    } else {
      return view('systems.user_account.edit')->with([
        'title' => 'Edit user account  ',
        'record' => $record
      ]);
    }
    
  }

  public function store(Request $request)
  {
    // Method untuk melakukan insert / input data ke dalam database
    // $data = $request->all();
    $validated = $request->validate([
      'ibs_employee_id' => 'required'
    ]);

    try {
      DB::beginTransaction();
      $data = [
        'ibs_employee_id' => $request->ibs_employee_id,
        'username' => $request->username,
        'password' => Hash::make($request->username),
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

  public function update(Request $request, $id)
  {
    // Method untuk melakukan update data post ke database
    $data = $request->all();
    $user = $this->user::find($id);
    $validated = $request->validate([
      'email' => 'required'
    ]);

    try {
      DB::beginTransaction();

      $record = [
        'email' => $data['email'],
        'password' => (isset($data['password']) ? Hash::make($data['password']) : $user->password),
        'updated_by' => $data['updated_by'],
        'updated_at' => date('Y-m-d H:i:s')
      ];

      $this->user::find($id)->update($record);

      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }

    return redirect('/sys/user_account')->with('success', 'Data updated successfully!');
  }

  public function destroy($id)
  {
    // Method untuk menghapus data post
  }
}
