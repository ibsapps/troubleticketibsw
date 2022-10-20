<?php

namespace App\Http\Controllers\SYS;

use App\Models\IbsUserPermission;
use App\Models\IbsInformation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class IbsInformationController extends Controller
{

  public function __construct()
  {
    $this->middleware(['auth','checkaccess:/ibs_information']);
    $this->permission = new IbsUserPermission();
    $this->information = new IbsInformation();
  }
  public function index(Request $request)
  {
    $permission = $this->permission->check_access('/ibs_information');
    $data = ([
      'title' => 'Master information',
      'records' => $this->information::getData(null, null, null),
      'permission' => $permission
    ]);
    if ($request->ajax()) {
      $result = view('systems.information.index_ajax', $data)->render();
      return response()->json($result);
    } else {
      return view('systems.information.index', $data);
    }
  }

  public function create()
  {
    //
    return view('systems.information.add')->with([
      'title' => 'Create Information'
    ]);
  }

  public function show($id)
  {
    //
    $permission = $this->permission->check_access('/ibs_information');
    return view('systems.information.show')->with([
      'title' => 'Show information',
      'record' => $this->information::find($id),
      'permission' => $permission
    ]);
  }

  public function edit($id)
  {
    return view('systems.information.edit')->with([
      'title' => 'Edit information',
      'record' => $this->information::find($id)
    ]);
  }

  public function store(Request $request)
  {
    //
    $data = $request->all();
    try {
      DB::beginTransaction();

      $information = $this->information->store($data);
      $upload_destination = public_path('images/sys/information');
      if (isset($data['file'])) {
        $data['file']->move($upload_destination, $information->filename);
      }
      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      // var_dump()
      return redirect()->back()->with('error', $th->getMessage());
    }

    return redirect('/sys/information')->with('success', 'Information created successfully!');
  }

  public function update(Request $request, $id)
  {
    //
    $data = $request->all();
    $information = $this->information::find($id);
    // print_r($data);
    try {
      DB::beginTransaction();

      if (isset($data['id'])) {
        if (isset($data['file'])) {
          $upload_destination = public_path('images/sys/information');
          $random_string = Str::random(30);
          deleteFile($information->filename, 'ibs_information', 'images/sys/information', null);
          $record = array(
            'live_until' => $data['live_until'],
            'title' => $data['title'],
            'description' => $data['description'],
            'filename_original' => $data['file']->getClientOriginalName(),
            'filename' => $random_string . "_" . $data['file']->getClientOriginalName(),
            'file_extension' => $data['file']->getClientOriginalExtension(),
            'file_path' => 'images/sys/information/' . $random_string . "_" . $data['file']->getClientOriginalName(),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => auth()->user()->id
          );
          $data['file']->move($upload_destination, $random_string . "_" . $data['file']->getClientOriginalName());
        } else {
          $record = array(
            'live_until' => $data['live_until'],
            'title' => $data['title'],
            'description' => $data['description'],
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => auth()->user()->id
          );
        }
        $this->information::find($id)->update($record);
      }

      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      return redirect()->back()->with('error', $th->getMessage());
    }

    return redirect('/sys/information/'.$information->id)->with('success', 'Data updated successfully!');
  }


  public function destroy($id)
  {
    //
  }
}
