<br>
<div class="card">
  <div class="card-header">
    <h4>{{ $title }}</h4>
  </div>
  <div class="card-body">
    <div class="row mb-2">
      <div class="col-lg-6">
        @if ($permission->create == 1)
        <a type="button" href="/{{ $permission->ibs_menu->url }}/create" class="btn btn-primary add">ADD</a>
        <br>
        @endif
      </div>
      <div class="col-lg-6">
        <div class=" col-lg-2 float-right">
        </div>
      </div>
    </div>
    <!-- <hr> -->
    <!-- <br> -->
    <div class="table-responsive">
      <div class="row">
        <div class="col-lg-12">
          <table id="dtable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No.</th>
                @if ($permission->modify == 1)
                <th>Action</th>
                @endif
                <th>Creator</th>
                <th>Department</th>
                <th>Live Until</th>
                <th>Title</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($records as $record)
              <tr>
                <td>{{ $loop->iteration }}</td>
                @if ($permission->modify == 1)
                <td><a href="/{{ $permission->ibs_menu->url }}/{{ $record->id}}" class="btn btn-info">View</a></td>
                @endif
                <td>{{ $record->user->fullname }}</td>
                <td>{{ $record->ibs_department->name }}</td>
                <td>{{ $record->live_until }}</td>
                <td>{{ $record->title }}</td>
                <td>{{ $record->status == 1 ? 'Active' : 'Suspend' }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@include('layouts.jsscript')