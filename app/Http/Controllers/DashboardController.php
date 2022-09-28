<?php

namespace App\Http\Controllers;

use App\Models\IbsUserPermission;
use App\Models\IbsTroubleTicket;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
    $this->permission = new IbsUserPermission();
    $this->trouble_ticket = new IbsTroubleTicket();
  }

  public function index(Request $request)
  {
    list($open_tickets, $progress_tickets, $close_tickets, $reject_tickets) = $this->cekTicket();
    if ($request->ajax()) {
      $permission = $this->permission->check_access('/ibs_trouble_ticket');
      if ($request->get('kind') == 'menu') {
        $data = [
          'title' => 'Dashboard',
          'open_tickets' => $open_tickets,
          'progress_tickets' => $progress_tickets,
          'close_tickets' => $close_tickets,
          'reject_tickets' => $reject_tickets,
          'permission' => $permission
        ];
        $result = view('dashboards.index_ajax', $data)->render();
      } else {
        $status = $request->get('kind');
        if (auth()->user()->ibs_employee->ibs_department_id == 2) {
          if (auth()->user()->ibs_employee->ibs_position_id == 4) {
            $id = auth()->user()->id;
          } else {
            $id = 'all';
          }
        } else {
          $id = null;
        }
        $data = [
          'title' => 'List Trouble Ticket',
          'records' => $this->trouble_ticket->getData($status, $id),
          'permission' => $permission
        ];
        $result = view('it.trouble_ticket.index_ajax', $data)->render();
      }
      return response()->json($result);
    } else {
      if (auth()->user()->ibs_employee->ibs_department_id == 2 || auth()->user()->ibs_employee_id == 0) {
        $data = [
          'title' => 'IBS',
          'open_tickets' => $open_tickets,
          'progress_tickets' => $progress_tickets,
          'close_tickets' => $close_tickets,
          'reject_tickets' => $reject_tickets,
        ];
      } else {
        $data = [
          'title' => 'IBS',
          'open_tickets' => $open_tickets,
          'progress_tickets' => $progress_tickets,
          'close_tickets' => $close_tickets,
          'reject_tickets' => $reject_tickets,
        ];
      }
      return view('dashboards.index')->with($data);
    }
  }
  public function create()
  {
    // Method untuk menampilkan form create post
  }

  public function show($id)
  {
    // Method untuk menampilkan single post / detail dari sebuah post
  }
  public function edit($id)
  {
    // Method untuk menampilkan halaman edit post
  }

  public function store(Request $request)
  {
    // Method untuk melakukan insert / input data ke dalam database
  }

  public function update(Request $request, $id)
  {
    // Method untuk melakukan update data post ke database
  }

  public function destroy($id)
  {
    // Method untuk menghapus data post
  }

  private function cekTicket()
  {
    if (auth()->user()->ibs_employee->ibs_department_id == 2) {
      if (auth()->user()->ibs_employee->ibs_position_id == 2) {
        $category_id = null;
        $session_id = null;
      } elseif (auth()->user()->ibs_employee->ibs_position_id == 3) {
        switch (auth()->user()->ibs_employee->ibs_division_id) {
          case '2': //Programmer
            $category_id = 3;
            $session_id = null;
            break;
          case '3': //It Support
            $category_id = 2;
            $session_id = null;
            break;
          default:
            $category_id = 1;
            $session_id = null;
            break;
        }
      } elseif (auth()->user()->ibs_employee->ibs_position_id == 4) {
        $category_id = null;
        $session_id = auth()->user()->id;
      }
      # code...
    } else {
      $category_id = 'user';
      $session_id = auth()->user()->id;
    }
    $open_tickets = $this->trouble_ticket->getTicket('open', $category_id, $session_id);
    $progress_tickets = $this->trouble_ticket->getTicket('on progress', $category_id, $session_id);
    $close_tickets = $this->trouble_ticket->getTicket('close', $category_id, $session_id);
    $reject_tickets = $this->trouble_ticket->getTicket('reject', $category_id, $session_id);
    return [$open_tickets, $progress_tickets, $close_tickets, $reject_tickets];
  }
}
