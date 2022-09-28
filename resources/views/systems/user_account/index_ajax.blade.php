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
    <div class="row">
      <div class="col-lg-12">
        <table id="dtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No.</th>
              @if ($permission->modify == 1)
              <th>Action</th>
              @endif
              <th>Username</th>
              <th>Fullname</th>
              <th>Email</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($records as $record)
            <tr>
              <td>{{ $loop->iteration }}</td>
              @if ($permission->modify == 1)
              <td><a href="/sys/user/{{ $record->id}}/edit" class="btn btn-info">Edit</a></td>
              @endif
              <td>{{ $record->username }}</td>
              <td>{{ $record->fullname }}</td>
              <td>{{ $record->email }}</td>
              <td>{{ $record->status == 1 ? 'Active' : 'Suspend' }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@include('layouts.jsscript')