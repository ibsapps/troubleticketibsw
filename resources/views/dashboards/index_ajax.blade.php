@php
$user_position = auth()->user()->ibs_employee->ibs_position_id;
@endphp
<br>
<div class="card">
  <div class="card-header">
    <h4>IT Trouble Ticket Logs</h4>
  </div>
  <div class="card-body">
    @if (session('error'))
    <div class="alert alert-danger" role="alert">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      {{ session('error') }}
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success" role="alert">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      {{ session('success') }}
    </div>
    @endif
    <!-- <div class="message" style="display: none;"></div> -->
    @if (auth()->user()->ibs_employee->ibs_department_id == 2)
    <div class="row">
      <!-- ./col -->
      <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ $close_tickets->count() }}</h3>
            <p>Close Ticket</p>
          </div>
          <div class="icon">
            <i class="fas fa-fw fa-code"></i>
          </div>
          <a href="#" link="dashboard" kind="close" class="view_menu small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{ $reject_tickets->count() }}</h3>

            <p>Reject Ticket</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" kind="reject" class="view_menu small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
    @else
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ $open_tickets->count() }}</h3>
            <p>Open Ticket</p>
          </div>
          <div class="icon">
            <i class="fas fa-fw fa-ethernet"></i>
          </div>
          <a href="#" link="dashboard" kind="open" class="view_menu small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ $progress_tickets->count() }}</h3>
            <p>Progress Ticket</p>
          </div>
          <div class="icon">
            <i class="fas fa-fw fa-users"></i>
          </div>
          <a href="#" link="dashboard" kind="on progress" class="view_menu small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ $close_tickets->count() }}</h3>
            <p>Close Ticket</p>
          </div>
          <div class="icon">
            <i class="fas fa-fw fa-code"></i>
          </div>
          <a href="#" link="dashboard" kind="close" class="view_menu small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{ $reject_tickets->count() }}</h3>

            <p>Reject Ticket</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" link="dashboard" kind="reject" class="view_menu small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
@if (auth()->user()->ibs_employee->ibs_department_id == 2)
<div class="row">
  @if ($user_position == 2 || $user_position == 3)
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">TICKET : <b style="color: red;">Open ({{ $open_tickets->count() }})</b></h3>
      </div>
      <div class="card-body p-2">
        @if ($open_tickets->count() == 0)
        <div>
          <h4 style="text-align: center;"><b>No Tickets Available</b></h4>
        </div>
        @else
        @foreach ($open_tickets as $ot )
        <div>
          <button type="button" class="btn btn-default view_modal col-lg-12" style="text-align: left;" id="{{ $ot->id  }}" number="{{ $ot->number }}" tbl="trouble_ticket">
            <b>
              <span>{{ $loop->iteration }}. {{ $ot->number }} | {{ Illuminate\Support\Str::limit($ot->user->fullname, 10) }}</span>
            </b>
            <p>Problem : {{ Illuminate\Support\Str::limit($ot->request, 25) }}</p>
          </button>
        </div>
        <hr>
        @endforeach
        @endif
      </div>
    </div>
  </div>
  @endif
  <div class="col-lg-{!! $user_position == 2 || $user_position == 3 ? 6 : 12 !!}">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">TICKET : <b style="color: blue;">On Progress ({{ $progress_tickets->count() }})</b></h3>
      </div>

      <div class="card-body p-2">
        @if ($progress_tickets->count() == 0)
        <div>
          <h4 style=" text-align: center;"><b>No Tickets Available</b></h4>
        </div>
        @else
        @foreach ($progress_tickets as $pt )
        <div>
          <button type="button" class="btn btn-default view_modal col-lg-12" style="text-align: left;" id="{{ $pt->id  }}" number="{{ $pt->number }}" tbl="trouble_ticket">
            <b>
              <span>{{ $loop->iteration }}. {{ $pt->number }} | {{ Illuminate\Support\Str::limit($pt->user->fullname, 10) }}</span>
              @if ($pt->actioned_by_id != null)
              <span style="background-color: crimson; color: white;">&nbsp;&nbsp; PIC : {{ $pt->actioned_by->fullname }} &nbsp;&nbsp;</span>
              @endif
            </b>
            <p>Problem : {{ Illuminate\Support\Str::limit($pt->request, 25) }}</p>
          </button>
        </div>
        <hr>
        @endforeach
        @endif
      </div>
    </div>
  </div>
</div>
@endif
<!-- MODAL -->
<div class="modal fade" id="modal-ticket" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div> -->
    </div>
  </div>
</div>

@include('layouts.jsscript')