<br>
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
    <!-- <hr> -->
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
@include('layouts.jsscript')