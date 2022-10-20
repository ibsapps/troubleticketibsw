@extends('layouts.main')

@section('content')
<div class="row">
  <section class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h4>{{ $title }}</h4>
      </div>
      <div class="card-body">
        <div class="row mb-2">
          <div class="col-lg-6">
            @if ($permission->create == 1)
            <a type="button" href="/{{ $permission->url }}/create" class="btn btn-primary">ADD</a>
            @endif
          </div>
          <div class="col-lg-6">
            <div class=" col-lg-2 float-right">
            </div>
          </div>
        </div>
        <hr>
        <div class="table-responsive">
          <div class="row">
            <div class="col-lg-12">
              <table id="dtable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    @if ($permission->read == 1)
                    <th>Action</th>
                    @endif
                    <th>Number</th>
                    <th>Category</th>
                    <th>Request</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($records as $record)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    @if ($permission->read == 1)
                    <td><a href="/{{ $permission->url }}/{{ $record->id}}" class="btn btn-info">View</a></td>
                    @endif
                    <td>{{ $record->number }}</td>
                    <td>{{ $record->ibs_trouble_ticket_category->name }}</td>
                    <td>{{ $record->request }}</td>
                    <td>{{ $record->status }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="col-lg-4">
    <div class="card" style="height: 600px;">
      <div class="card-header">
        <h4>Trouble Ticket</h4>
      </div>
      <div class="card-body">
        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="custom-content-below-1-tab" data-toggle="pill" href="#custom-content-below-1" role="tab" aria-controls="custom-content-below-1" aria-selected="true">Network</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-content-below-2-tab" data-toggle="pill" href="#custom-content-below-2" role="tab" aria-controls="custom-content-below-2" aria-selected="false">Support</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-content-below-3-tab" data-toggle="pill" href="#custom-content-below-3" role="tab" aria-controls="custom-content-below-3" aria-selected="false">Application</a>
          </li>
        </ul>
        <div class="tab-content" id="custom-content-below-tabContent" style="overflow: auto; height: 450px;">
          @foreach ($trouble_ticket_categories as $category)
          <?php $c = 0; ?>
            <div class="tab-pane fade show {{$category->id == 1 ? 'active' : ''}}" id="custom-content-below-{{ $category->id }}" role="tabpanel" aria-labelledby="custom-content-below-{{ $category->id }}-tab">
              <br>
              @foreach ($list_tickets as $ticket)
                @if ($ticket->ibs_trouble_ticket_category_id == $category->id)
                  <?php $c++; ?>
                  <div class="row">
                    <div class="col-lg-12">
                      <button type="button" class="btn btn-default col-lg-12" style="text-align: left;" id="{{ $ticket->id  }}" number="{{ $ticket->number }}" tbl="trouble_ticket">
                        <b>
                          <span>{{ $c }}. {{ $ticket->number }} | {{ Illuminate\Support\Str::limit($ticket->user->fullname, 10) }}</span>
                        </b>
                        <p>Created at : {{ $ticket->request_date->format('Y-m-d') }}</p>
                      </button>
                    </div>
                  </div>
                  <hr>
                @endif
              @endforeach
              @if ($c == 0)
                <div class="row">
                  <div class="col-lg-12">
                    <button type="button" class="btn btn-default col-lg-12" style="text-align: left;" tbl="trouble_ticket">
                      <h4 style=" text-align: center;"><b>No Tickets Available</b></h4>
                    </button>
                  </div>
                </div>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>
</div>
@endsection