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
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">NIP <span style="color: red;">*</span></label>
              <div class="col-lg-4">
                <input type="text" id="nik" name="nik" placeholder="Personnel No" class="form-control" maxlength="8" value="{{ $record->nik }}" disabled="true">
              </div>
              <label class="col-lg-2 col-form-label">Join Date <span style="color: red;">*</span></label>
              <div class="col-lg-4">
                <input type="text" id="join_date" name="join_date" class="form-control" value="{{ $record->join_date == null ? '' : $record->join_date->format('d-m-Y') }}" disabled="true">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Name <span style="color: red;">*</span></label>
              <div class="col-lg-10">
                <input type="text" id="name" name="name" placeholder="Employee Name" class="form-control" value="{{ $record->name }}" disabled="true">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Birth Date <span style="color: red;">*</span></label>
              <div class="col-lg-4">
                <input type="text" id="born_date" name="born_date" class="form-control" value="{{ $record->born_date == null ? '' : $record->born_date->format('d-m-Y') }}" disabled="true">
              </div>
              <label class="col-lg-2 col-form-label">Birth Place</label>
              <div class="col-lg-4">
                <input type="text" id="place_of_birth" name="place_of_birth" placeholder="Birth Place" class="form-control" value="{{ $record->place_of_birth }}" disabled="true">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Gender <span style="color: red;">*</span></label>
              <div class="col-lg-3">
                <input type="text" id="gender" name="gender" class="form-control" value="{{ $record->gender }}" disabled="true">
              </div>
              <label class="col-lg-3 col-form-label">Marital Status</label>
              <div class="col-lg-4">
                <input type="text" id="marital_status" name="marital_status" class="form-control" value="{{ $record->marital_status }}" disabled="true">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Cost Center</label>
              <div class="col-lg-3">
                <input type="text" id="cost_center" name="cost_center" class="form-control" value="{{ $record->cost_center }}" disabled="true">
              </div>
              <label class="col-lg-3 col-form-label">Cost Description</label>
              <div class="col-lg-4">
                <input type="text" id="cost_center_description" name="cost_center_description" class="form-control" value="{{ $record->cost_center_description }}" disabled="true">
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Department</label>
              <div class="col-lg-4">
                <input type="text" id="department_name" name="department_name" class="form-control" value="{{ $record->ibs_department->name }}" disabled="true">
              </div>
              <label class="col-lg-2 col-form-label">Division</label>
              <div class="col-lg-4">
                <input type="text" id="division_name" name="division_name" class="form-control" value="{{ $record->ibs_division->name }}" disabled="true">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Position</label>
              <div class="col-lg-4">
                <input type="text" id="position_name" name="position_name" class="form-control" value="{{ $record->ibs_position->name }}" disabled="true">
              </div>
              <label class="col-lg-2 col-form-label">Contract</span></label>
              <div class="col-lg-4">
                <input type="text" id="contract_status" name="contract_status" class="form-control" value="{{ $record->contract_status }}" disabled="true">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Group</label>
              <div class="col-lg-3">
                <input type="text" id="group" name="group" class="form-control" value="{{ $record->group }}" disabled="true">
              </div>
              <label class="col-lg-2 col-form-label">Directorate</label>
              <div class="col-lg-5">
                <input type="text" id="directorate" name="directorate" class="form-control" value="{{ $record->directorate }}" disabled="true">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Area</label>
              <div class="col-lg-4">
                <input type="text" id="area" name="area" class="form-control" value="{{ $record->area }}" disabled="true">
              </div>
              <label class="col-lg-2 col-form-label">Sub Area</label>
              <div class="col-lg-4">
                <input type="text" id="sub_area" name="sub_area" class="form-control" value="{{ $record->sub_area }}" disabled="true">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label">Contract Begin</label>
              <div class="col-lg-3">
                <input type="text" id="contract_begin" name="contract_begin" class="form-control" value="{{ $record->contract_begin == null ? '' : $record->contract_begin->format('d-m-Y') }}" disabled="true">
              </div>
              <label class="col-lg-3 col-form-label">Contract End</label>
              <div class="col-lg-3">
                <input type="text" id="contract_end" name="contract_end" class="form-control" value="{{ $record->contract_end == null ? '' : $record->contract_end->format('d-m-Y') }}" disabled="true">
              </div>
            </div>
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
          <li class="nav-item">
            <a class="nav-link" id="custom-content-below-bank-tab" data-toggle="pill" href="#custom-content-below-bank" role="tab" aria-controls="custom-content-below-bank" aria-selected="false">Bank</a>
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
                      <input type="text" id="ktp_number" name="ktp_number" placeholder="No KTP" class="form-control" value="{{ $record->ktp_number }}" disabled="true">
                    </div>
                    <label class="col-lg-2 col-form-label">NPWP</label>
                    <div class="col-lg-4">
                      <input type="text" id="npwp" name="npwp" placeholder="NPWP" class="form-control" value="{{ $record->npwp }}" disabled="true">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-lg-2 col-form-label">Address</label>
                    <div class="col-lg-10">
                      <textarea name="origin_address" id="origin_address" class="form-control" cols="7" disabled="true">{{ $record->origin_address }}</textarea>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label" class="form-control">Religion</label>
                  <div class="col-lg-3">
                    <input type="text" id="religion" name="religion" class="form-control" value="{{ $record->religion }}" disabled="true">
                  </div>
                  <label class="col-lg-2 col-form-label">Email</label>
                  <div class="col-lg-5">
                    <input type="email" id="email" name="email" placeholder="Email" class="form-control" value="{{ $record->email }}" disabled="true">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label" class="form-control">PTKP</label>
                  <div class="col-lg-2">
                    <input type="text" id="ptkp" name="ptkp" class="form-control" value="{{ $record->ptkp }}" disabled="true">
                  </div> 
                  <label class="col-lg-3 col-form-label">Company Mail</label>
                  <div class="col-lg-5">
                    <input type="email" id="company_email" name="company_email" placeholder="Company Email" class="form-control" value="{{ $record->company_email }}" disabled="true">
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <div class="row">
                    <label class="col-lg-2 col-form-label">BPJS TK</label>
                    <div class="col-lg-4">
                      <input type="text" id="bpjs_tk" name="bpjs_tk" placeholder="No BPJS Ketenagakerjaan" class="form-control" value="{{ $record->bpjs_tk }}" disabled="true">
                    </div>
                    <label class="col-lg-2 col-form-label">BPJS Kes</label>
                    <div class="col-lg-4">
                      <input type="text" id="bpjs_kes" name="bpjs_kes" placeholder="No BPJS Kesehatan" class="form-control" value="{{ $record->bpjs_kes }}" disabled="true">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label">Temporary Address</label>
                  <div class="col-lg-10">
                    <textarea name="temporary_address" id="temporary_address" class="form-control" cols="7" disabled="true">{{ $record->temporary_address }}</textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Phone Number</label>
                  <div class="col-lg-3">
                    <input type="text" id="phone_number" name="phone_number" placeholder="Phone Number" class="form-control" value="{{ $record->phone_number }}" disabled="true">
                  </div>
                  <label class="col-lg-3 col-form-label">Smartfren Number</label>
                  <div class="col-lg-3">
                    <input type="text" id="smartfren_phone_number" name="smartfren_phone_number" placeholder="Phone Number" class="form-control" value="{{ $record->smartfren_phone_number }}" disabled="true">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Passport Number</label>
                  <div class="col-lg-4">
                    <input type="number" id="passport_number" name="passport_number" class="form-control" value="{{ $record->passport_number }}" disabled="true">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="custom-content-below-education" role="tabpanel" aria-labelledby="custom-content-below-education-tab">
            <br>
            <div class="form-group row">
              <label class="col-lg-1 col-form-label">Institute</label>
              <div class="col-lg-4">
                <input type="text" id="education_location" name="education_location" placeholder="Institute / Location" class="form-control" value="{{ $record->education_location }}" disabled="true">
              </div>
              <label class="col-lg-1 col-form-label">Certificate</label>
              <div class="col-lg-1">
                <input type="text" id="education_degree" name="education_degree" placeholder="Certificate" class="form-control" value="{{ $record->education_degree }}" disabled="true">
              </div>
              <label class="col-lg-2 col-form-label">Branch Of Study</label>
              <div class="col-lg-3">
                <input type="text" id="education_major" name="education_major" placeholder="Branch Of Study" class="form-control" value="{{ $record->education_major }}" disabled="true">
              </div>
            </div>
          </div>
          <div class="tab-pane fade show" id="custom-content-below-bank" role="tabpanel" aria-labelledby="custom-content-below-bank-tab">
            <br>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Mandiri Account Number<span style="color: red;">*</span></label>
              <div class="col-lg-5">
                <input type="text" id="mandiri_bank_account" name="mandiri_bank_account" placeholder="Mandiri Account Number" class="form-control" required value="{{ $record->mandiri_bank_account }}" disabled="true">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Sinarmas Account Number<span style="color: red;">*</span></label>
              <div class="col-lg-5">
                <input type="text" id="sinarmas_bank_account" name="sinarmas_bank_account" placeholder="Sinarmas Account Number" class="form-control" required value="{{ $record->sinarmas_bank_account }}" disabled="true">
              </div>  
            </div>
          </div>
        </div>
        <hr>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Status</label>
          <div class="col-lg-3">
            <select id="status" name="status" class="form-control" tbl="employee" disabled="true">
              <option value="1" {{ $record->status == 1 ? 'selected' : '' }}>Active</option>
              <option value="2" {{ $record->status == 2 ? 'selected' : '' }}>Leaving</option>
              <option value="3" {{ $record->status == 3 ? 'selected' : '' }}>End of Contract</option>
              <option value="4" {{ $record->status == 4 ? 'selected' : '' }}>Organizational Reassignment</option>
            </select>
          </div>
          <div class="result">
            @if ($record->status == 2 || $record->status == 4)
              <input type="text" id="reason_of_status" name="reason_of_status" class="form-control" value="{{ $record->reason_of_status }}" disabled="true">
            @endif
          </div>
        </div>
        <hr>
        @include('hrd.employee.validation')
      </form>
    </div>
  </div>
</div>
@endsection