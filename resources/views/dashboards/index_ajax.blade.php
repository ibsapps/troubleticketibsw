@php
$user_position = auth()->user()->ibs_employee->ibs_position_id;
@endphp
<br>
<div class="row">
  <div class="message" style="display: none;"></div>
  <section class="col-lg-8">
    <!-- dashboard informations -->
    <div class="card">
      <div class="card-header">
        <h4>Dashboard Informations</h4>
      </div>
      <div class="card-body" style="background-color: #f4f6f9;">
        <div class="px-0">
          @if (count($informations) == 0 )
            <div class="card text-center" style="height: 300px;">
              <div class="card-body row align-items-center">
                <div class="col-lg-12">
                  <h2>
                    <b>
                      NO INFORMATION AVAILABLE YET!
                    </b>
                  </h2>
                </div>
              </div>
            </div>           
          @else          
            <div id="carouselControls" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner" role="listbox">
                @foreach ($informations as $information)
                  <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : ''}}">
                    <a href="{{ ('/') }}">
                      <div class="d-flex align-items-center justify-content-center">
                        <img src="{!! url($information->file_path) !!}" alt="{{ $information->filename_original}}" width="300" height="300" class="d-block w-100">
                      </div>
                      <div class="carousel-caption">
                        <h3>{{ $information->title }}</h5>
                        <p>{{ $information->description }}</p>
                      </div>
                    </a>
                  </div>`                
                @endforeach
                <!-- <div class="carousel-item active">
                  <div class="d-flex align-items-center justify-content-center min-vh-100">
                    <h1 class="display-1">ONE</h1>
                  </div>
                </div> -->
              </div>
              <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
    <!-- shortcut apps -->
    <div class="row">
      <div class="col-lg-3">
        <a href="/it/trouble_ticket">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1">
              <i class="fas fa-cog">
              </i>
            </span>
            <div class="info-box-content">
              <span class="info-box-number">TROUBLE TICKET</span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3">
        <a href="/it/trouble_ticket">
          <div class="info-box">
            <span class="info-box-icon bg-danger elevation-1">
              <i class="fas fa-ticket-alt">
              </i>
            </span>
            <div class="info-box-content">
              <span class="info-box-number">VOUCHER</span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3">
        <a href="/it/trouble_ticket">
          <div class="info-box">
            <span class="info-box-icon bg-success elevation-1">
              <i class="fas fa-book">
              </i>
            </span>
            <div class="info-box-content">
              <span class="info-box-number">ATK</span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3">
        <a href="/it/trouble_ticket">
          <div class="info-box">
            <span class="info-box-icon bg-warning elevation-1">
              <i class="fas fa-file">
              </i>
            </span>
            <div class="info-box-content">
              <span class="info-box-number">AM</span>
            </div>
          </div>
        </a>
      </div>
    </div>
  </section>
  @if (auth()->user()->ibs_employee->ibs_department_id == 2)
    <section class="col-lg-4">
      <div class="card" style="height: 600px;">
        <div class="card-header">
          <h4>Trouble Ticket</h4>
        </div>
        <div class="card-body">
          @if (auth()->user()->ibs_employee->ibs_position_id == 2)
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
            <div class="tab-content" id="custom-content-below-tabContent" style="overflow: auto; height: 500px;">
              @foreach ($trouble_ticket_categories as $category)
              <?php $c = 0; ?>
                <div class="tab-pane fade show {{$category->id == 1 ? 'active' : ''}}" id="custom-content-below-{{ $category->id }}" role="tabpanel" aria-labelledby="custom-content-below-{{ $category->id }}-tab">
                  <br>
                  @foreach ($list_tickets->take(5) as $ticket)
                    @if ($ticket->ibs_trouble_ticket_category_id == $category->id)
                      <?php $c++; ?>
                      <div class="row">
                        <div class="col-lg-12">
                          <button type="button" class="view_modal btn btn-default col-lg-12" style="text-align: left;" id="{{ $ticket->id  }}" number="{{ $ticket->number }}" tbl="trouble_ticket">
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
          @else
            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-content-below-open-tab" data-toggle="pill" href="#custom-content-below-open" role="tab" aria-controls="custom-content-below-open" aria-selected="true">Open</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-progress-tab" data-toggle="pill" href="#custom-content-below-progress" role="tab" aria-controls="custom-content-below-progress" aria-selected="false">On Progress</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-close-tab" data-toggle="pill" href="#custom-content-below-close" role="tab" aria-controls="custom-content-below-close" aria-selected="false">Close</a>
              </li>
            </ul>
            <div class="tab-content" id="custom-content-below-tabContent" style="overflow: auto; height: 450px;">
              @foreach ($kind_tickets as $kind)
              <?php $c = 0; ?>
                <div class="tab-pane fade show {{$kind == 'open' ? 'active' : ''}}" id="custom-content-below-{{ $kind }}" role="tabpanel" aria-labelledby="custom-content-below-{{ $kind }}-tab">
                  <br>
                  @foreach ($list_tickets->take(10) as $ticket)
                    @switch($kind)
                    @case('progress')
                      @if ($ticket->status == 'on progress')
                        <?php $c++; ?>
                        <div class="row">
                          <div class="col-lg-12">
                            <button type="button" class="view_modal btn btn-default col-lg-12" style="text-align: left;" id="{{ $ticket->id  }}" number="{{ $ticket->number }}" tbl="trouble_ticket">
                              <b>
                                <span>{{ $c }}. {{ $ticket->number }} | {{ Illuminate\Support\Str::limit($ticket->user->fullname, 10) }}</span>
                              </b>
                              <p>Created at : {{ $ticket->request_date->format('Y-m-d') }}</p>
                            </button>
                          </div>
                        </div>
                        <hr>
                      @endif
                      @break
                    @default
                      @if ($ticket->status == $kind)
                        <?php $c++; ?>
                        <div class="row">
                          <div class="col-lg-12">
                            <button type="button" class="view_modal btn btn-default col-lg-12" style="text-align: left;" id="{{ $ticket->id  }}" number="{{ $ticket->number }}" tbl="trouble_ticket">
                              <b>
                                <span>{{ $c }}. {{ $ticket->number }} | {{ Illuminate\Support\Str::limit($ticket->user->fullname, 10) }}</span>
                              </b>
                              <p>Created at : {{ $ticket->request_date->format('Y-m-d') }}</p>
                            </button>
                          </div>
                        </div>
                        <hr>
                      @endif
                      @break
                    @endswitch
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
          @endif
        </div>
      </div>
    </section>
  @else
    <section class="col-lg-4">
      <div class="card" style="height: 600px;">
        <div class="card-header">
          <h4>
            <i class="ion ion-clipboard mr-1">
            </i>
            To Do List
          </h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <button type="button" class="btn btn-default col-lg-12" style="text-align: left;">
                <b>
                  <span>Pembuatan dokumen perhitungan jumlah asset</span>
                </b>
                <p>Due Date : 10-11-2022</p>
              </button>
              <hr>
              <button type="button" class="btn btn-default col-lg-12" style="text-align: left;">
                <b>
                  <span>Penyelesaian report asset bulanan</span>
                </b>
                <p>Due Date : 15-11-2022</p>
              </button>
            </div>
          </div>
          <hr>
        </div>
      </div>
    </section>
  @endif
</div>

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