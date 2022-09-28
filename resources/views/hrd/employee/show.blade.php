@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-header">
    <h4>{{ $title }}</h4>
  </div>
  <div class="form-horizontal">
    <div class="card-body">
      <form>
        <div class="message" style="display: none;"></div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Personnel No. <span style="color: red;">*</span></label>
          <div class="col-lg-1">
            <input type="text" id="nik" name="nik" class="form-control" maxlength="8" value="{{ ($record->nik) }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label">Name <span style="color: red;">*</span></label>
          <div class="col-lg-3">
            <input type="text" id="name" name="name" class="form-control" value="{{ ($record->name) }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label">Group</label>
          <div class="col-lg-1">
            <input type="text" id="group" name="group" class="form-control" value="{{ ($record->group) }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label">Division</label>
          <div class="col-lg-3">
            <input type="text" class="form-control" name="ibs_division_id" id="ibs_division_id" value="{{ $record->ibs_division->name }}" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Position</label>
          <div class="col-lg-2">
            <input type="text" class="form-control" name="ibs_position_id" id="ibs_position_id" value="{{ $record->ibs_position->name }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label">Department</label>
          <div class="col-lg-2">
            <input type="text" class="form-control" name="ibs_department_id" id="ibs_department_id" value="{{ $record->ibs_position->name }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label">Contract <span style="color: red;">*</span></label>
          <div class="col-lg-2">
            <input type="text" class="form-control" name="contract_status" id="contract_status" value="{{ $record->contract_status }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label">Entry Date <span style="color: red;">*</span></label>
          <div class="col-lg-2">
            <input type="date" id="entry_date" name="entry_date" class="form-control" value="{{ $record->entry_date }}" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Gender <span style="color: red;">*</span></label>
          <div class="col-lg-2">
            <input type="text" class="form-control" name="gender" id="gender" value="{{ $record->gender }}" disabled>

          </div>
          <label class="col-lg-1 col-form-label">Birth Date <span style="color: red;">*</span></label>
          <div class="col-lg-2">
            <input type="date" id="born_date" name="born_date" class="form-control" value="{{ $record->born_date }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label">Birth Place</label>
          <div class="col-lg-2">
            <input type="text" id="place_of_birth" name="place_of_birth" class="form-control" value="{{ $record->place_of_birth }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label">Email</label>
          <div class="col-lg-2">
            <input type="email" id="email" name="email" class="form-control" value="{{ $record->email }}" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Area</label>
          <div class="col-lg-2">
            <input type="text" class="form-control" name="ibs_area_id" id="ibs_area_id" value="{{ $record->ibs_area->name }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label">Phone</label>
          <div class="col-lg-2">
            <input type="number" id="phone_number" name="phone_number" class="form-control" value="{{ $record->phone_number }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label">Phone 2</label>
          <div class="col-lg-2">
            <input type="number" id="phone_number_2" name="phone_number_2" class="form-control" value="{{ $record->phone_number_2 }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label" class="form-control">Religion</label>
          <div class="col-lg-2">
            <input type="text" class="form-control" name="religion" id="religion" value="{{ $record->religion }}" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Directorate</label>
          <div class="col-lg-2">
            <input type="text" id="directorate" name="directorate" class="form-control" value="{{ $record->directorate }}" disabled>
          </div>
          <label class="col-lg-1 col-form-label">Cost Center</label>
          <div class="col-lg-2">
            <input type="text" id="cost_center" name="cost_center" class="form-control" value="{{ $record->cost_center }}" disabled>
          </div>
          <label class="col-lg-2 col-form-label">Cost Center Description</label>
          <div class="col-lg-3">
            <input type="text" id="cost_center_description" name="cost_center_description" class="form-control" value="{{ $record->cost_center_description }}" disabled>
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
                      <input type="number" id="ktp_number" name="ktp_number" placeholder="No KTP" class="form-control" value="{{ $record->ktp_number }}" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-lg-2 col-form-label">Address</label>
                    <div class="col-lg-6">
                      <textarea name="origin_address" id="origin_address" class="form-control" disabled>{{ $record->origin_address }}</textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <div class="row">
                    <label class="col-lg-2 col-form-label">NPWP</label>
                    <div class="col-lg-4">
                      <input type="text" id="npwp" name="npwp" class="form-control" value="{{ $record->npwp }}" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-lg-2 col-form-label">BPJS TK</label>
                    <div class="col-lg-4">
                      <input type="number" id="bpjs_tk" name="bpjs_tk" class="form-control" value="{{ $record->bpjs_tk }}" disabled>
                    </div>
                    <label class="col-lg-2 col-form-label">BPJS Kes</label>
                    <div class="col-lg-4">
                      <input type="number" id="bpjs_kes" name="bpjs_kes" class="form-control" value="{{ $record->bpjs_kes }}" disabled>
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
                <input type="text" id="education_location" name="education_location" lass="form-control" value="{{ $record->education_location }}" disabled>
              </div>
              <label class="col-lg-1 col-form-label">Certificate</label>
              <div class="col-lg-2">
                <input type="text" id="education_degree" name="education_degree" class="form-control" value="{{ $record->education_degree }}" disabled>
              </div>
              <label class="col-lg-2 col-form-label">Branch Of Study</label>
              <div class="col-lg-2">
                <input type="text" id="education_major" name="education_major" class="form-control" value="{{ $record->education_major }}" disabled>
              </div>
            </div>
          </div>
        </div>
        <hr>
        @include('hrd.employee.validation')
      </form>
    </div>
  </div>
</div>
@endsection