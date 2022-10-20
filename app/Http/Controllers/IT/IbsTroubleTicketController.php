<?php

namespace App\Http\Controllers\IT;

use App\Models\IbsVendor;
use App\Models\IbsDepartment;
use App\Models\IbsTroubleTicket;
use App\Models\IbsUserPermission;
use App\Models\IbsTroubleTicketLog;
use App\Models\IbsTroubleTicketItem;
use App\Models\IbsTroubleTicketCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\IbsSuperior;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class IbsTroubleTicketController extends Controller
{

  public function __construct()
  {
    $this->middleware(['auth','checkaccess:/ibs_trouble_ticket']);
    $this->permission = new IbsUserPermission();
    $this->trouble_ticket = new IbsTroubleTicket();
    $this->trouble_ticket_item = new IbsTroubleTicketItem();
    $this->trouble_ticket_log = new IbsTroubleTicketLog();
    $this->ticket_category = new IbsTroubleTicketCategory();
    $this->vendor = new IbsVendor();
    $this->superior = new IbsSuperior();
  }
  public function index(Request $request)
  {
    $permission = $this->permission->check_access('/ibs_trouble_ticket');
    if (auth()->user()->ibs_employee->ibs_department_id == 2) {
      if (auth()->user()->ibs_employee->ibs_position_id == 2) {
        $tickets = $this->trouble_ticket->getData(null, 'all');
      } else {
        if (auth()->user()->ibs_employee->ibs_division_id == 2) {
          $tickets = $this->trouble_ticket->getTicket('list', 3, null);
        } elseif (auth()->user()->ibs_employee->ibs_division_id == 3) {
          $tickets = $this->trouble_ticket->getTicket('list', 2, null);
        } else {
          $tickets = $this->trouble_ticket->getTicket('list', 1, null);
        }
      }
    } else {
      $tickets = $this->trouble_ticket->getData('user', null);
    }
    $data = ([
      'title' => 'List Trouble Ticket',
      'records' => $tickets,
      'permission' => $permission,
      'trouble_ticket_categories' => $this->ticket_category::all(),
      'list_tickets' => $this->trouble_ticket::getData('open', null)
    ]);
    if ($request->ajax()) {
      $result = view('it.trouble_ticket.index_ajax', $data)->render();
      return response()->json($result);
    } else {
      return view('it.trouble_ticket.index', $data);
    }
  }

  public function create()
  {
    $ticket_categories = $this->ticket_category->getData(null);
    $vendors = $this->vendor->getData(null);
    return view('it.trouble_ticket.add')->with([
      'title' => 'Create Trouble Ticket',
      'categories' => $ticket_categories,
      'vendors' => $vendors
    ]);
  }

  public function show($id)
  {
    $permission = $this->permission->check_access('/ibs_trouble_ticket');
    $record = IbsTroubleTicket::find($id);
    return view('it.trouble_ticket.show')->with([
      'title' => 'Show Trouble Ticket',
      'record' => $record,
      'permission' => $permission
    ]);
  }

  public function edit(Request $request, $id)
  {
    $record = IbsTroubleTicket::find($id);
    $superiors = $this->superior->getData();
    $vendors = $this->vendor::all();
    if ($request->ajax()) {
      $data = ([
        'title' => 'Edit Trouble Ticket',
        'record' => $record,
        'superiors' => $superiors,
        'vendors' => $vendors
      ]);
      $result = view('it.trouble_ticket.modal', $data)->render();
      return response()->json($result);
    } else {
      return view('it.trouble_ticket.edit')->with([
        'title' => 'Edit Trouble Ticket',
        'record' => $record,
        'superiors' => $superiors,
        'vendors' => $vendors
      ]);
    }
  }

  public function store(Request $request)
  {
    //
    $data = $request->all();
    try {
      DB::beginTransaction();
      $upload_destination = public_path('images/it/trouble_ticket');

      $ticket = $this->trouble_ticket->store($data);

      if (isset($data['file'])) {
        $data['file']->move($upload_destination, $ticket->file_path);
      }

      $ticket_log = array(
        'ibs_trouble_ticket_id' => $ticket->id,
        'user' => $data['user_name'],
        'status' => 'open',
        'category' => $ticket->ibs_trouble_ticket_category->name,
        'created_ticket_at' => $ticket->created_at,
        'created_at' => $ticket->created_at,
        'created_by' => $ticket->created_by
      );

      $this->trouble_ticket_log::create($ticket_log);

      DB::commit();
      //-- done --
    } catch (\Throwable $th) {
      DB::rollBack();
      // var_dump()
      return redirect()->back()->with('error', $th->getMessage());
    }

    return redirect('/it/trouble_ticket')->with('success', 'Ticket created successfully!');
  }

  public function update(Request $request, $id)
  {
    $data = $request->all();
    $ticket = $this->trouble_ticket::find($id);

    // print_r($data);
    if ($data['status'] == 'on progress' && $data['due_date'] == null) {
      return redirect()->back()->with('error', 'Due date cannot be empty!');
    } else {
      try {
        DB::beginTransaction();
        $upload_destination = public_path('images/it/trouble_ticket');

        if ($data['status'] == 'open' && $data['due_date'] != null) {
          $data['status'] = 'on progress';
          $data['actioned_by_id'] = auth()->user()->id;
          $data['actioned_at'] = date('Y-m-d H:i:s');
        }
        // $this->trouble_ticket::find($id)->update($data);
        $this->trouble_ticket->updateData($id, $data, $ticket);

        // if (isset($data['file'])) {
        //   $data['file']->move($upload_destination, $record_update['file_path']);
        // }

        // if (isset($data['description'])) {
        //   foreach ($data['description'] as $key => $value) {
        //     $upload_destination = public_path('images/it/trouble_ticket');
        //     $random_string = Str::random(30);
        //     if (isset($data['item_id'][$key])) {
        //       $record_item = $this->trouble_ticket_item->getData($data['item_id'][$key]);
        //       if (isset($data['file'][$key])) {
        //         $ticket_item = array(
        //           'description' => $data['description'][$key],
        //           'filename_original' => $data['file'][$key]->getClientOriginalName(),
        //           'filename' => $random_string . "_" . $data['file'][$key]->getClientOriginalName(),
        //           'file_extension' => $data['file'][$key]->getClientOriginalExtension(),
        //           'file_path' => 'images/it/trouble_ticket/' . $random_string . "_" . $data['file'][$key]->getClientOriginalName(),
        //           'status' => $data['status_item'][$key],
        //           'updated_at' => date('Y-m-d H:i:s'),
        //           'updated_by' => $data['created_by']
        //         );
        //         $data['file'][$key]->move($upload_destination, $random_string . "_" . $data['file'][$key]->getClientOriginalName());
        //       } else {
        //         if ($data['status_item'][$key] == 0) {
        //           deleteFile($record_item->filename, 'trouble_ticket_item', 'images/it/trouble_ticket', null);
        //           $ticket_item = array(
        //             'description' => $data['description'][$key],
        //             'filename_original' => null,
        //             'filename' => null,
        //             'file_extension' => null,
        //             'file_path' => null,
        //             'status' => 0,
        //             'updated_at' => date('Y-m-d H:i:s'),
        //             'updated_by' => $data['created_by']
        //           );
        //         } else {
        //           $ticket_item = array(
        //             'description' => $data['description'][$key],
        //             'filename_original' => $record_item->filename_original,
        //             'filename' => $record_item->filename,
        //             'file_extension' => $record_item->file_extension,
        //             'file_path' => $record_item->file_path,
        //             'status' => $data['status_item'][$key],
        //             'updated_at' => date('Y-m-d H:i:s'),
        //             'updated_by' => $data['created_by']
        //           );
        //         }
        //       }
        //       $this->trouble_ticket_item::find($record_item->id)->update($ticket_item);
        //     } else {
        //       $ticket_item = array(
        //         'ibs_trouble_ticket_id' => $id,
        //         'description' => $data['description'][$key],
        //         'filename_original' => (isset($data['file'][$key]) ? $data['file'][$key]->getClientOriginalName() : null),
        //         'filename' => (isset($data['file'][$key]) ? $random_string . "_" . $data['file'][$key]->getClientOriginalName() : null),
        //         'file_extension' => (isset($data['file'][$key]) ? $data['file'][$key]->getClientOriginalExtension() : null),
        //         'file_path' => (isset($data['file'][$key]) ? 'images/it/trouble_ticket/' . $random_string . "_" . $data['file'][$key]->getClientOriginalName() : null),
        //         'status' => 1,
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'created_by' => auth()->user()->id
        //       );
        //       $this->trouble_ticket_item::create($ticket_item);
        //       if (isset($data['file'][$key])) {
        //         $data['file'][$key]->move($upload_destination, $random_string . "_" . $data['file'][$key]->getClientOriginalName());
        //       }
        //     }
        //   }
        // }
        $new_record = $this->trouble_ticket::find($id);
        if (isset($data['file'])) {
          deleteFile($ticket->filename, 'trouble_ticket_item', 'images/it/trouble_ticket', null);
          $data['file']->move($upload_destination, $new_record->file_path);
        }
        $ticket_log = array(
          'ibs_trouble_ticket_id' => $ticket->id,
          'pic' => $ticket->actioned_by_id != null ? $ticket->actioned_by->fullname : null,
          'user' => $data['user_name'],
          'status' => $data['status'],
          'trouble_repair' => isset($data['trouble_repair']) ? $data['trouble_repair'] : null,
          'category' => $data['category_name'],
          'created_ticket_at' => $ticket->created_at,
          'due_date_ticket_at' => $ticket->due_date != null ? $ticket->due_date : null,
          'closed_ticket_at' => $data['status'] == 'close' ? date('Y-m-d') : null,
          'created_at' => date('Y-m-d H:i:s'),
          'created_by' => auth()->user()->id
        );

        $cek_log = $this->trouble_ticket_log->checkLog($id, $data['status']);

        if ($cek_log == null) {
          $this->trouble_ticket_log::create($ticket_log);
          sendMailNotification($ticket, 'trouble_tickets', auth()->user()->fullname, $data['status']);
        }

        DB::commit();
      } catch (\Throwable $th) {
        DB::rollBack();
        return redirect()->back()->with('error', $th->getMessage());
      }

      if (isset($data['process'])) {
        $index_dashboard = app('App\Http\Controllers\DashboardController')->index($request);
        return $index_dashboard;
      } else {
        return redirect('/it/trouble_ticket')->with('success', 'Ticket updated successfully!');
      }
    }
  }


  public function destroy($id)
  {
    //
  }

  private function accessModule($url, $id)
  {
  }
}
