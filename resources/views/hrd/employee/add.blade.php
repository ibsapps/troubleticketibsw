@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-header">
    <h4>{{ $title }}</h4>
  </div>
  <div class="form-horizontal">
    <div class="card-body">
      {{-- menampilkan error validasi --}}
      @if (count($errors) > 0)
      <div class="alert alert-danger" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <form method="POST" action="/hrd/employee">
        @csrf
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {{ session('error') }}
        </div>
        @endif
        <input type="hidden" id="created_by" name="created_by" value="{{ auth()->user()->id }}">
        <div class="message" style="display: none;"></div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Personnel No. <span style="color: red;">*</span></label>
          <div class="col-lg-1">
            <input type="text" id="nik" name="nik" placeholder="Personnel No" class="form-control" maxlength="8" value="{{ old('nik') }}" required>
          </div>
          <label class="col-lg-1 col-form-label">Name <span style="color: red;">*</span></label>
          <div class="col-lg-3">
            <input type="text" id="name" name="name" placeholder="Employee Name" class="form-control" value="{{ old('name') }}" required>
          </div>
          <label class="col-lg-1 col-form-label">Group</label>
          <div class="col-lg-1">
            <input type="text" id="group" name="group" placeholder="Group" class="form-control" value="{{ old('group') }}">
          </div>
          <label class="col-lg-1 col-form-label">Division</label>
          <div class="col-lg-3">
            <select name="ibs_division_id" id="ibs_division_id" class="form-control">
              <option value="">- Select -</option>
              @foreach ($divisions as $key => $value)
              <option value="<?= $value->id ?>" {{ old('nik') }}><?= $value->name ?></option>
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
              <option value="<?= $value->id ?>"><?= $value->name ?></option>
              @endforeach
            </select>
          </div>
          <label class="col-lg-1 col-form-label">Department</label>
          <div class="col-lg-2">
            <select name="ibs_department_id" id="ibs_department_id" class="form-control">
              <option value="">--Select--</option>
              @foreach ($departments as $key => $value)
              <option value="<?= $value->id ?>"><?= $value->name ?></option>
              @endforeach
            </select>
          </div>
          <label class="col-lg-1 col-form-label">Contract <span style="color: red;">*</span></label>
          <div class="col-lg-2">
            <select name="contract_status" id="contract_status" class="form-control" required>
              <option value="">- Select -</option>
              <option value="Contract">Contract</option>
              <option value="Permanent">Permanent</option>
            </select>
          </div>
          <label class="col-lg-1 col-form-label">Entry Date <span style="color: red;">*</span></label>
          <div class="col-lg-2">
            <input type="date" id="entry_date" name="entry_date" class="form-control" value="{{ old('entry_date') }}" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Gender <span style="color: red;">*</span></label>
          <div class="col-lg-2">
            <select name="gender" id="gender" class="form-control" required>
              <option value="">- Select -</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
          <label class="col-lg-1 col-form-label">Birth Date <span style="color: red;">*</span></label>
          <div class="col-lg-2">
            <input type="date" id="born_date" name="born_date" class="form-control" required value="{{ old('born_date') }}">
          </div>
          <label class="col-lg-1 col-form-label">Birth Place</label>
          <div class="col-lg-2">
            <input type="text" id="place_of_birth" name="place_of_birth" placeholder="Birth Place" class="form-control" value="{{ old('place_of_birth') }}">
          </div>
          <label class="col-lg-1 col-form-label">Email</label>
          <div class="col-lg-2">
            <input type="email" id="email" name="email" placeholder="Email" class="form-control" value="{{ old('email') }}">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Area</label>
          <div class="col-lg-2">
            <select name="ibs_area_id" id="ibs_area_id" class="form-control">
              <option value="">- Select -</option>
              @foreach ($areas as $key => $value)
              <option value="<?= $value->id ?>"><?= $value->name ?></option>
              @endforeach
            </select>
          </div>
          <label class="col-lg-1 col-form-label">Phone</label>
          <div class="col-lg-2">
            <input type="text" id="phone_number" name="phone_number" placeholder="Phone Number" class="form-control" value="{{ old('phone_number') }}">
          </div>
          <label class="col-lg-1 col-form-label">Phone 2</label>
          <div class="col-lg-2">
            <input type="text" id="phone_number_2" name="phone_number_2" placeholder="Phone Number 2" class="form-control" value="{{ old('phone_number_2') }}">
          </div>
          <label class="col-lg-1 col-form-label" class="form-control">Religion</label>
          <div class="col-lg-2">
            <select name="religion" id="religion" class="form-control">
              <option value="">- Select -</option>
              <option value="Buddha">Buddha</option>
              <option value="Hindu">Hindu</option>
              <option value="Islam">Islam</option>
              <option value="Katolik">Katolik</option>
              <option value="Kristen Protestan">Kristen Protestan</option>
              <option value="Konghucu">Konghucu</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Directorate</label>
          <div class="col-lg-2">
            <input type="text" id="directorate" name="directorate" placeholder="Directorate" class="form-control" value="{{ old('directorate') }}">
          </div>
          <label class="col-lg-1 col-form-label">Cost Center</label>
          <div class="col-lg-2">
            <input type="text" id="cost_center" name="cost_center" placeholder="Cost Center" class="form-control" value="{{ old('cost_center') }}">
          </div>
          <label class="col-lg-2 col-form-label">Cost Center Description</label>
          <div class="col-lg-3">
            <input type="text" id="cost_center_description" name="cost_center_description" placeholder="Cost Center Description" class="form-control" value="{{ old('cost_center_description') }}">
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
                      <input type="text" id="ktp_number" name="ktp_number" placeholder="No KTP" class="form-control" required value="{{ old('ktp_number') }}">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-lg-2 col-form-label">Address</label>
                    <div class="col-lg-6">
                      <textarea name="origin_address" id="origin_address" class="form-control">{{ old('origin_address') }}</textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <div class="row">
                    <label class="col-lg-2 col-form-label">NPWP</label>
                    <div class="col-lg-4">
                      <input type="text" id="npwp" name="npwp" placeholder="NPWP" class="form-control" value="{{ old('npwp') }}">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-lg-2 col-form-label">BPJS TK</label>
                    <div class="col-lg-4">
                      <input type="text" id="bpjs_tk" name="bpjs_tk" placeholder="No BPJS Ketenagakerjaan" class="form-control" value="{{ old('bpjs_tk') }}">
                    </div>
                    <label class="col-lg-2 col-form-label">BPJS Kes</label>
                    <div class="col-lg-4">
                      <input type="text" id="bpjs_kes" name="bpjs_kes" placeholder="No BPJS Kesehatan" class="form-control" value="{{ old('bpjs_kes') }}">
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
                <input type="text" id="education_location" name="education_location" placeholder="Institute / Location" class="form-control" value="{{ old('education_location') }}">
              </div>
              <label class="col-lg-1 col-form-label">Certificate</label>
              <div class="col-lg-2">
                <input type="text" id="education_degree" name="education_degree" placeholder="Certificate" class="form-control" value="{{ old('education_degree') }}">
              </div>
              <label class="col-lg-2 col-form-label">Branch Of Study</label>
              <div class="col-lg-2">
                <input type="text" id="education_major" name="education_major" placeholder="Branch Of Study" class="form-control" value="{{ old('education_major') }}">
              </div>
            </div>
          </div>
        </div>
        <hr>
        <button type="submit" class="save btn btn-primary">Save</button>
        <a href="/hrd/employee" class="back btn btn-secondary">Back</a>
      </form>
    </div>
  </div>
</div>
@endsection