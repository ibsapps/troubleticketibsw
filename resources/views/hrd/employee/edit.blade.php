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
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">NIP <span style="color: red;">*</span></label>
              <div class="col-lg-4">
                <input type="text" id="nik" name="nik" placeholder="Personnel No" class="form-control" maxlength="8" value="{{ $record->nik }}" required="true">
              </div>
              <label class="col-lg-2 col-form-label">Join Date <span style="color: red;">*</span></label>
              <div class="col-lg-4">
                <input type="date" id="join_date" name="join_date" class="form-control" value="{{ $record->join_date == null ? '' : $record->join_date->format('Y-m-d') }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Name <span style="color: red;">*</span></label>
              <div class="col-lg-10">
                <input type="text" id="name" name="name" placeholder="Employee Name" class="form-control" value="{{ $record->name }}" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Birth Date <span style="color: red;">*</span></label>
              <div class="col-lg-4">
                <input type="date" id="born_date" name="born_date" class="form-control" value="{{ $record->born_date == null ? '' : $record->born_date->format('Y-m-d') }}" required="true">
              </div>
              <label class="col-lg-2 col-form-label">Birth Place</label>
              <div class="col-lg-4">
                <input type="text" id="place_of_birth" name="place_of_birth" placeholder="Birth Place" class="form-control" value="{{ $record->place_of_birth }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Gender <span style="color: red;">*</span></label>
              <div class="col-lg-3">
                <select name="gender" id="gender" class="form-control" required="true">
                  <option value="Male" {{ $record->gender == "Male" ? 'selected' : '' }}>Male</option>
                  <option value="Female" {{ $record->gender == "Female" ? 'selected' : '' }}>Female</option>
                </select>
              </div>
              <label class="col-lg-3 col-form-label">Marital Status</label>
              <div class="col-lg-4">
                <select name="marital_status" id="marital_status" class="form-control" required="true">
                  <option value="">- Select -</option>
                  <option value="Married" {{ $record->marital_status == "Married" ? 'selected' : '' }}>Married</option>
                  <option value="Single" {{ $record->marital_status == "Single" ? 'selected' : '' }}>Single</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Cost Center</label>
              <div class="col-lg-3">
                <select id="cost_center" name="cost_center" class="form-control" required="true">
                  <option value="">- Select -</option>
                  <option value="IBSW - FAD" {{ $record->cost_center == "IBSW - FAD" ? 'selected' : '' }}>IBSW - FAD</option>
                  <option value="IBSW - COM" {{ $record->cost_center == "IBSW - COM" ? 'selected' : '' }}>IBSW - COM</option>
                  <option value="IBSW - PRO" {{ $record->cost_center == "IBSW - PRO" ? 'selected' : '' }}>IBSW - PRO</option>
                </select>
              </div>
              <label class="col-lg-3 col-form-label">Cost Description</label>
              <div class="col-lg-4">
                <select id="cost_center_description" name="cost_center_description" class="form-control" required="true">
                  <option value="">- Select -</option>
                  <option value="IBSW Financial & Accounting" {{ $record->cost_center_description == "IBSW Financial & Accounting" ? 'selected' : '' }}>IBSW Financial & Accounting</option>
                  <option value="IBSW Commercial" {{ $record->cost_center_description == "IBSW Commercial" ? 'selected' : '' }}>IBSW Commercial</option>
                  <option value="IBSW Procurement" {{ $record->cost_center_description == "IBSW Procurement" ? 'selected' : '' }}>IBSW Procurement</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Department</label>
              <div class="col-lg-4">
                <select name="ibs_department_id" id="ibs_department_id" class="form-control" required="true">
                  @foreach ($departments as $key => $department)
                    <option value="<?= $department->id ?>" {{ $department->id == $record->ibs_department_id ? 'selected' : '' }}><?= $department->name ?></option>
                  @endforeach
                </select>
              </div>
              <label class="col-lg-2 col-form-label">Division</label>
              <div class="col-lg-4">
                <select name="ibs_division_id" id="ibs_division_id" class="form-control" required="true">
                @foreach ($divisions as $key => $division)
                  <option value="<?= $division->id ?>" {{ $division->id == $record->ibs_division_id ? 'selected' : '' }}><?= $division->name ?></option>
                @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Position</label>
              <div class="col-lg-4">
                <select name="ibs_position_id" id="ibs_position_id" class="form-control" required="true">
                  @foreach ($positions as $key => $position)
                    <option value="<?= $position->id ?>" {{ $position->id == $record->ibs_position_id ? 'selected' : '' }}><?= $position->name ?></option>
                  @endforeach
                </select>
              </div>
              <label class="col-lg-2 col-form-label">Contract</span></label>
              <div class="col-lg-4">
                <select id="contract_status" name="contract_status" class="form-control" required="true">
                  <option value="Contract" {{ $record->contract_status == 'Contract' ? 'selected' : '' }}>Contract</option>
                  <option value="Permanent" {{ $record->contract_status == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Group</label>
              <div class="col-lg-3">
                <select id="group" name="group" class="form-control" required="true">
                  <option value="GOL A" {{ $record->group == 'GOL A' ? 'selected' : '' }}>GOL A</option>
                  <option value="GOL B" {{ $record->group == 'GOL B' ? 'selected' : '' }}>GOL B</option>
                  <option value="GOL C" {{ $record->group == 'GOL C' ? 'selected' : '' }}>GOL C</option>
                  <option value="GOL D" {{ $record->group == 'GOL D' ? 'selected' : '' }}>GOL D</option>
                  <option value="GOL E" {{ $record->group == 'GOL E' ? 'selected' : '' }}>GOL E</option>
                  <option value="GOL F" {{ $record->group == 'GOL F' ? 'selected' : '' }}>GOL F</option>
                  <option value="GOL G" {{ $record->group == 'GOL G' ? 'selected' : '' }}>GOL G</option>
                  <option value="GOL H" {{ $record->group == 'GOL H' ? 'selected' : '' }}>GOL H</option>
                  <option value="GOL I" {{ $record->group == 'GOL I' ? 'selected' : '' }}>GOL I</option>
                  <option value="GOL J" {{ $record->group == 'GOL J' ? 'selected' : '' }}>GOL J</option>
                  <option value="GOL K" {{ $record->group == 'GOL K' ? 'selected' : '' }}>GOL K</option>
                </select>
              </div>
              <label class="col-lg-2 col-form-label">Directorate</label>
              <div class="col-lg-5">
                <select id="directorate" name="directorate" class="form-control" required="true">
                  <option value="Financial" {{ $record->directorate == 'Financial' ? 'selected' : '' }}>Financial</option>
                  <option value="Marketing" {{ $record->directorate == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                  <option value="Operational" {{ $record->directorate == 'Operational' ? 'selected' : '' }}>Operational</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Area</label>
              <div class="col-lg-4">
                <select name="area" id="area" class="form-control" required="true">
                  <option value="">- Select -</option>
                  <option value="IBSW - JAKARTA" {{ $record->area == 'IBSW - JAKARTA' ? 'selected' : '' }}>IBSW - JAKARTA</option>
                  <option value="IBSW - PAPUA" {{ $record->area == 'IBSW - PAPUA' ? 'selected' : '' }}>IBSW - PAPUA</option>
                </select>
              </div>
              <label class="col-lg-2 col-form-label">Sub Area</label>
              <div class="col-lg-4">
                <select id="sub_area" name="sub_area" class="form-control" required="true">
                  <option value="">- Select -</option>
                  <option value="Head Office" {{ $record->sub_area == 'Head Office' ? 'selected' : '' }}>Head Office</option>
                  <option value="Non HO" {{ $record->sub_area == 'Non HO' ? 'selected' : '' }}>Non HO</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label">Contract Begin</label>
              <div class="col-lg-3">
                <input type="date" id="contract_begin" name="contract_begin" class="form-control" value="{{ $record->contract_begin == null ? '' : $record->contract_begin->format('Y-m-d') }}" required="true">
              </div>
              <label class="col-lg-3 col-form-label">Contract End</label>
              <div class="col-lg-3">
                <input type="date" id="contract_end" name="contract_end" class="form-control" value="{{ $record->contract_end == null ? '' : $record->contract_end->format('Y-m-d') }}" required="true">
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
                      <input type="text" id="ktp_number" name="ktp_number" placeholder="No KTP" class="form-control" required value="{{ $record->ktp_number }}">
                    </div>
                    <label class="col-lg-2 col-form-label">NPWP</label>
                    <div class="col-lg-4">
                      <input type="text" id="npwp" name="npwp" placeholder="NPWP" class="form-control" value="{{ $record->npwp }}">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-lg-2 col-form-label">Address</label>
                    <div class="col-lg-10">
                      <textarea name="origin_address" id="origin_address" class="form-control" cols="7">{{ $record->origin_address }}</textarea>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label" class="form-control">Religion</label>
                  <div class="col-lg-3">
                    <select name="religion" id="religion" class="form-control" required="true">
                      <option value="" >- Select -</option>
                      <option value="Buddha" {{ $record->religion == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                      <option value="Hindu" {{ $record->religion == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                      <option value="Islam" {{ $record->religion == 'Islam' ? 'selected' : '' }}>Islam</option>
                      <option value="Katolik" {{ $record->religion == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                      <option value="Kristen Protestan" {{ $record->religion == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                      <option value="Konghucu" {{ $record->religion == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                  </div>
                  <label class="col-lg-2 col-form-label">Email</label>
                  <div class="col-lg-5">
                    <input type="email" id="email" name="email" placeholder="Email" class="form-control" value="{{ $record->email }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label" class="form-control">PTKP</label>
                  <div class="col-lg-2">
                    <select name="ptkp" id="ptkp" class="form-control" required="true">
                      <option value="TK/0" {{ $record->ptkp == 'TK/0' ? 'selected' : '' }}>TK/0</option>
                      <option value="TK/1" {{ $record->ptkp == 'TK/1' ? 'selected' : '' }}>TK/1</option>
                      <option value="TK/2" {{ $record->ptkp == 'TK/2' ? 'selected' : '' }}>TK/2</option>
                      <option value="TK/3" {{ $record->ptkp == 'TK/3' ? 'selected' : '' }}>TK/3</option>
                      <option value="K/0" {{ $record->ptkp == 'K/0' ? 'selected' : '' }}>K/0</option>
                      <option value="K/1" {{ $record->ptkp == 'K/1' ? 'selected' : '' }}>K/1</option>
                      <option value="K/2" {{ $record->ptkp == 'K/2' ? 'selected' : '' }}>K/2</option>
                      <option value="K/3" {{ $record->ptkp == 'K/3' ? 'selected' : '' }}>K/3</option>
                      <option value="K/I/0" {{ $record->ptkp == 'K/I/0' ? 'selected' : '' }}>K/I/0</option>
                      <option value="K/I/1" {{ $record->ptkp == 'K/I/1' ? 'selected' : '' }}>K/I/1</option>
                      <option value="K/I/2" {{ $record->ptkp == 'K/I/2' ? 'selected' : '' }}>K/I/2</option>
                      <option value="K/I/3" {{ $record->ptkp == 'K/I/3' ? 'selected' : '' }}>K/I/3</option>
                    </select>
                  </div> 
                  <label class="col-lg-3 col-form-label">Company Mail</label>
                  <div class="col-lg-5">
                    <input type="email" id="company_email" name="company_email" placeholder="Company Email" class="form-control" value="{{ $record->company_email }}">
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <div class="row">
                    <label class="col-lg-2 col-form-label">BPJS TK</label>
                    <div class="col-lg-4">
                      <input type="text" id="bpjs_tk" name="bpjs_tk" placeholder="No BPJS Ketenagakerjaan" class="form-control" value="{{ $record->bpjs_tk }}">
                    </div>
                    <label class="col-lg-2 col-form-label">BPJS Kes</label>
                    <div class="col-lg-4">
                      <input type="text" id="bpjs_kes" name="bpjs_kes" placeholder="No BPJS Kesehatan" class="form-control" value="{{ $record->bpjs_kes }}">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label">Temporary Address</label>
                  <div class="col-lg-10">
                    <textarea name="temporary_address" id="temporary_address" class="form-control" cols="7">{{ $record->temporary_address }}</textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Phone Number</label>
                  <div class="col-lg-3">
                    <input type="text" id="phone_number" name="phone_number" placeholder="Phone Number" class="form-control" value="{{ $record->phone_number }}">
                  </div>
                  <label class="col-lg-3 col-form-label">Smartfren Number</label>
                  <div class="col-lg-3">
                    <input type="text" id="smartfren_phone_number" name="smartfren_phone_number" placeholder="Phone Number" class="form-control" value="{{ $record->smartfren_phone_number }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Passport Number</label>
                  <div class="col-lg-4">
                    <input type="number" id="passport_number" name="passport_number" class="form-control" value="{{ $record->passport_number }}">
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
                <input type="text" id="education_location" name="education_location" placeholder="Institute / Location" class="form-control" value="{{ $record->education_location }}">
              </div>
              <label class="col-lg-1 col-form-label">Certificate</label>
              <div class="col-lg-1">
                <input type="text" id="education_degree" name="education_degree" placeholder="Certificate" class="form-control" value="{{ $record->education_degree }}">
              </div>
              <label class="col-lg-2 col-form-label">Branch Of Study</label>
              <div class="col-lg-3">
                <input type="text" id="education_major" name="education_major" placeholder="Branch Of Study" class="form-control" value="{{ $record->education_major }}">
              </div>
            </div>
          </div>
          <div class="tab-pane fade show" id="custom-content-below-bank" role="tabpanel" aria-labelledby="custom-content-below-bank-tab">
            <br>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Mandiri Account Number<span style="color: red;">*</span></label>
              <div class="col-lg-5">
                <input type="text" id="mandiri_bank_account" name="mandiri_bank_account" placeholder="Mandiri Account Number" class="form-control" required value="{{ $record->mandiri_bank_account }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Sinarmas Account Number<span style="color: red;">*</span></label>
              <div class="col-lg-5">
                <input type="text" id="sinarmas_bank_account" name="sinarmas_bank_account" placeholder="Sinarmas Account Number" class="form-control" required value="{{ $record->sinarmas_bank_account }}">
              </div>  
            </div>
          </div>
        </div>
        <hr>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Status</label>
          <div class="col-lg-3">
            <select id="status" name="status" class="form-control" tbl="employee">
              <option value="1">Active</option>
              <option value="2">Leaving</option>
              <option value="3">End of Contract</option>
              <option value="4">Organizational Reassignment</option>
            </select>
          </div>
          <div class="result">
            
          </div>
        </div>
        <hr>
        <div class="d-flex justify-content-end">
          <div class="col-sm-1">
            <button type=" submit" class="save btn btn-primary" tbl="employee">Save</button>
          </div>
          <div>
            <a href="/hrd/employee" class="back btn btn-secondary">Back</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modal-employee" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
    </div>
  </div>
</div>

@endsection