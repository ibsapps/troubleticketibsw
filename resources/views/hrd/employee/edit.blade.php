@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-header">
    <h4>{{ $title }}</h4>
  </div>
  <div class="form-horizontal">
    <div class="card-body">
      {{-- menampilkan error validasi --}}
      @if (count($errors)> 0)
      <div class="alert alert-danger" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <form method="Post" action="/hrd/employee/{{ $record->id }}">
        @method('PUT')
        @csrf
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {{ session('error') }}
        </div>
        @endif
        <input type="hidden" id="id" name="id" value="{{ $record->id }}">
        <input type="hidden" id="updated_by" name="updated_by" value="{{ auth()->user()->id }}">
        <div class="message" style="display: none;"></div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Personnel No. <span style="color: red;">*</span></label>
          <div class="col-lg-1">
            <input type="text" id="nik" name="nik" class="form-control" maxlength="8" value="{{ ($record->nik) }}" required>
          </div>
          <label class="col-lg-1 col-form-label">Name <span style="color: red;">*</span></label>
          <div class="col-lg-3">
            <input type="text" id="name" name="name" class="form-control" value="{{ ($record->name) }}" required>
          </div>
          <label class="col-lg-1 col-form-label">Group</label>
          <div class="col-lg-1">
            <input type="text" id="group" name="group" class="form-control" value="{{ ($record->group) }}">
          </div>
          <label class="col-lg-1 col-form-label">Division</label>
          <div class="col-lg-3">
            <select name="ibs_division_id" id="ibs_division_id" class="form-control">
              <option value="">- Select -</option>
              @foreach ($divisions as $key => $value)
              <option value="<?= $value->id ?>" {{ $value->id == $record->ibs_division_id ? 'selected' : '' }}><?= $value->name ?></option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Position</label>
          <div class="col-lg-2">
            <select name="ibs_position_id" id="ibs_position_id" class="form-control">
              <option value="">-Select-</option>
              @foreach ($positions as $key => $value)
              <option value="<?= $value->id ?>" {{ $value->id == $record->ibs_position_id ? 'selected' : '' }}><?= $value->name ?></option>
              @endforeach
            </select>
          </div>
          <label class="col-lg-1 col-form-label">Department</label>
          <div class="col-lg-2">
            <select name="ibs_department_id" id="ibs_department_id" class="form-control">
              <option value="">--Select--</option>
              @foreach ($departments as $key => $value)
              <option value="<?= $value->id ?>" {{ $value->id == $record->ibs_department_id ? 'selected' : '' }}><?= $value->name ?></option>
              @endforeach
            </select>
          </div>
          <label class="col-lg-1 col-form-label">Contract <span style="color: red;">*</span></label>
          <div class="col-lg-2">
            <select name="contract_status" id="contract_status" class="form-control" required>
              <option value="">- Select -</option>
              <option value="Contract" {{ $record->contract_status == 'Contract' ? 'selected' : '' }}>Contract</option>
              <option value="Permanent" {{ $record->contract_status == 'Permanent' ? 'selected' : '' }}>Permanent</option>
            </select>
          </div>
          <label class="col-lg-1 col-form-label">Entry Date <span style="color: red;">*</span></label>
          <div class="col-lg-2">
            <input type="date" id="entry_date" name="entry_date" class="form-control" value="{{ $record->entry_date }}" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Gender <span style="color: red;">*</span></label>
          <div class="col-lg-2">
            <select name="gender" id="gender" class="form-control" required>
              <option value="">- Select -</option>
              <option value="Male" {{ $record->gender == "Male" ? 'selected' : '' }}>Male</option>
              <option value="Female" {{ $record->gender == "Female" ? 'selected' : '' }}>Female</option>
            </select>
          </div>
          <label class="col-lg-1 col-form-label">Birth Date <span style="color: red;">*</span></label>
          <div class="col-lg-2">
            <input type="date" id="born_date" name="born_date" class="form-control" value="{{ $record->born_date }}" required>
          </div>
          <label class="col-lg-1 col-form-label">Birth Place</label>
          <div class="col-lg-2">
            <input type="text" id="place_of_birth" name="place_of_birth" class="form-control" value="{{ $record->place_of_birth }}">
          </div>
          <label class="col-lg-1 col-form-label">Email</label>
          <div class="col-lg-2">
            <input type="email" id="email" name="email" class="form-control" value="{{ $record->email }}">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Area</label>
          <div class="col-lg-2">
            <select name="ibs_area_id" id="ibs_area_id" class="form-control">
              <option value="">- Select -</option>
              @foreach ($areas as $key => $value)
              <option value="<?= $value->id ?>" {{ $value->id == $record->ibs_area_id ? 'selected' : '' }}><?= $value->name ?></option>
              @endforeach
            </select>
          </div>
          <label class="col-lg-1 col-form-label">Phone</label>
          <div class="col-lg-2">
            <input type="number" id="phone_number" name="phone_number" class="form-control" value="{{ $record->phone_number }}">
          </div>
          <label class="col-lg-1 col-form-label">Phone 2</label>
          <div class="col-lg-2">
            <input type="number" id="phone_number_2" name="phone_number_2" class="form-control" value="{{ $record->phone_number_2 }}">
          </div>
          <label class="col-lg-1 col-form-label" class="form-control">Religion</label>
          <div class="col-lg-2">
            <select name="religion" id="religion" class="form-control">
              <option value="">- Select -</option>
              <option value="Buddha" {{ $record->religion == 'Buddha' ? 'selected' : '' }}>Buddha</option>
              <option value="Hindu" {{ $record->religion == 'Hindu' ? 'selected' : '' }}>Hindu</option>
              <option value="Islam" {{ $record->religion == 'Islam' ? 'selected' : '' }}>Islam</option>
              <option value="Katolik" {{ $record->religion == 'Katolik' ? 'selected' : '' }}>Katolik</option>
              <option value="Kristen Protestan" {{ $record->religion == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
              <option value="Konghucu" {{ $record->religion == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Directorate</label>
          <div class="col-lg-2">
            <input type="text" id="directorate" name="directorate" class="form-control" value="{{ $record->directorate }}">
          </div>
          <label class="col-lg-1 col-form-label">Cost Center</label>
          <div class="col-lg-2">
            <input type="text" id="cost_center" name="cost_center" class="form-control" value="{{ $record->cost_center }}">
          </div>
          <label class="col-lg-2 col-form-label">Cost Center Description</label>
          <div class="col-lg-3">
            <input type="text" id="cost_center_description" name="cost_center_description" class="form-control" value="{{ $record->cost_center_description }}">
          </div>
        </div>
        <hr>
        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="custom-content-below-general-tab" data-toggle="pill" href="#custom-content-below-general" role="tab" aria-controls="custom-content-below-general" aria-selected="true">General</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-content-below-education-tab" data-toggle="pill" href="#custom-content-below-education" role="tab" aria-controls="custom-content-below-education" aria-selected="false">Education</a>
          </li>
        </ul>
        <div class="tab-content" id="custom-content-below-tabContent">
          <div class="tab-pane fade show active" id="custom-content-below-general" role="tabpanel" aria-labelledby="custom-content-below-general-tab">
            <br>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <div class="row">
                    <label class="col-lg-2 col-form-label">KTP No. <span style="color: red;">*</span></label>
                    <div class="col-lg-4">
                      <input type="number" id="ktp_number" name="ktp_number" placeholder="No KTP" class="form-control" value="{{ $record->ktp_number }}" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-lg-2 col-form-label">Address</label>
                    <div class="col-lg-6">
                      <textarea name="origin_address" id="origin_address" class="form-control">{{ $record->origin_address }}</textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <div class="row">
                    <label class="col-lg-2 col-form-label">NPWP</label>
                    <div class="col-lg-4">
                      <input type="text" id="npwp" name="npwp" class="form-control" value="{{ $record->npwp }}">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-lg-2 col-form-label">BPJS TK</label>
                    <div class="col-lg-4">
                      <input type="number" id="bpjs_tk" name="bpjs_tk" class="form-control" value="{{ $record->bpjs_tk }}">
                    </div>
                    <label class="col-lg-2 col-form-label">BPJS Kes</label>
                    <div class="col-lg-4">
                      <input type="number" id="bpjs_kes" name="bpjs_kes" class="form-control" value="{{ $record->bpjs_kes }}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="custom-content-below-education" role="tabpanel" aria-labelledby="custom-content-below-education-tab">
            <br>
            <div class="form-group row">
              <label class="col-lg-1 col-form-label">Institute</label>
              <div class="col-lg-2">
                <input type="text" id="education_location" name="education_location" lass="form-control" value="{{ $record->education_location }}">
              </div>
              <label class="col-lg-1 col-form-label">Certificate</label>
              <div class="col-lg-2">
                <input type="text" id="education_degree" name="education_degree" class="form-control" value="{{ $record->education_degree }}">
              </div>
              <label class="col-lg-2 col-form-label">Branch Of Study</label>
              <div class="col-lg-2">
                <input type="text" id="education_major" name="education_major" class="form-control" value="{{ $record->education_major }}">
              </div>
            </div>
          </div>
        </div>
        <hr>
        <button type=" submit" class="save btn btn-primary">Save</button>
        <a href="/hrd/employee" class="back btn btn-secondary">Back</a>
      </form>
    </div>
  </div>
</div>
@endsection