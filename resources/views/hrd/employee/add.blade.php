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
        <input type="hidden" id="entry_date" name="entry_date" value="{{ date('Y-m-d')}}">
        <div class="message" style="display: none;"></div>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">NIP <span style="color: red;">*</span></label>
              <div class="col-lg-4">
                <input type="text" id="nik" name="nik" placeholder="Personnel No" class="form-control" maxlength="8" value="{{ old('nik') }}" required="true">
              </div>
              <label class="col-lg-2 col-form-label">Join Date <span style="color: red;">*</span></label>
              <div class="col-lg-4">
                <input type="date" id="join_date" name="join_date" class="form-control" value="{{ old('join_date') }}" required="true">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Name <span style="color: red;">*</span></label>
              <div class="col-lg-10">
                <input type="text" id="name" name="name" placeholder="Employee Name" class="form-control" value="{{ old('name') }}" required="true">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Birth Date <span style="color: red;">*</span></label>
              <div class="col-lg-4">
                <input type="date" id="born_date" name="born_date" class="form-control" value="{{ old('born_date') }}" required="true">
              </div>
              <label class="col-lg-2 col-form-label">Birth Place</label>
              <div class="col-lg-4">
                <input type="text" id="place_of_birth" name="place_of_birth" placeholder="Birth Place" class="form-control" value="{{ old('place_of_birth') }}" required="true">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Gender <span style="color: red;">*</span></label>
              <div class="col-lg-3">
                <select name="gender" id="gender" class="form-control" required="true">
                  <option value="">- Select -</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
              <label class="col-lg-3 col-form-label">Marital Status</label>
              <div class="col-lg-4">
                <select name="marital_status" id="marital_status" class="form-control" required="true">
                  <option value="">- Select -</option>
                  <option value="Married">Married</option>
                  <option value="Single">Single</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Cost Center</label>
              <div class="col-lg-3">
                <select id="cost_center" name="cost_center" class="form-control" required="true">
                  <option value="">- Select -</option>
                  <option value="IBSW - FAD">IBSW - FAD</option>
                  <option value="IBSW - COM">IBSW - COM</option>
                  <option value="IBSW - PRO">IBSW - PRO</option>
                </select>
              </div>
              <label class="col-lg-3 col-form-label">Cost Description</label>
              <div class="col-lg-4">
                <select id="cost_center_description" name="cost_center_description" class="form-control" required="true">
                  <option value="">- Select -</option>
                  <option value="IBSW Financial & Accounting">IBSW Financial & Accounting</option>
                  <option value="IBSW Commercial">IBSW Commercial</option>
                  <option value="IBSW Procurement">IBSW Procurement</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Department</label>
              <div class="col-lg-4">
                <select name="ibs_department_id" id="ibs_department_id" class="form-control">
                  <option value="">--Select--</option>
                  @foreach ($departments as $key => $value)
                  <option value="<?= $value->id ?>"><?= $value->name ?></option>
                  @endforeach
                </select>
              </div>
              <label class="col-lg-2 col-form-label">Division</label>
              <div class="col-lg-4">
                <select name="ibs_division_id" id="ibs_division_id" class="form-control">
                  <option value="">- Select -</option>
                  @foreach ($divisions as $key => $value)
                  <option value="<?= $value->id ?>" {{ old('nik') }}><?= $value->name ?></option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Position</label>
              <div class="col-lg-4">
                <select name="ibs_position_id" id="ibs_position_id" class="form-control">
                  <option value="">-Select-</option>
                  @foreach ($positions as $key => $value)
                  <option value="<?= $value->id ?>"><?= $value->name ?></option>
                  @endforeach
                </select>
              </div>
              <label class="col-lg-2 col-form-label">Contract</span></label>
              <div class="col-lg-4">
                <select id="contract_status" name="contract_status" class="form-control" required="true">
                  <option value="">- Select -</option>
                  <option value="Contract">Contract</option>
                  <option value="Permanent">Permanent</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Group</label>
              <div class="col-lg-3">
                <select id="group" name="group" class="form-control" required="true">
                  <option value="">- Select -</option>
                  <option value="GOL A">GOL A</option>
                  <option value="GOL B">GOL B</option>
                  <option value="GOL C">GOL C</option>
                  <option value="GOL D">GOL D</option>
                  <option value="GOL E">GOL E</option>
                  <option value="GOL F">GOL F</option>
                  <option value="GOL G">GOL G</option>
                  <option value="GOL H">GOL H</option>
                  <option value="GOL I">GOL I</option>
                  <option value="GOL J">GOL J</option>
                  <option value="GOL K">GOL K</option>
                </select>
              </div>
              <label class="col-lg-2 col-form-label">Directorate</label>
              <div class="col-lg-5">
                <select id="directorate" name="directorate" class="form-control" required="true">
                  <option value="">- Select -</option>
                  <option value="Financial">Financial</option>
                  <option value="Marketing">Marketing</option>
                  <option value="Operational">Operational</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Area</label>
              <div class="col-lg-4">
                <select name="area" id="area" class="form-control" required="true">
                  <option value="">- Select -</option>
                  <option value="IBSW - JAKARTA">IBSW - JAKARTA</option>
                  <option value="IBSW - PAPUA">IBSW - PAPUA</option>
                </select>
              </div>
              <label class="col-lg-2 col-form-label">Sub Area</label>
              <div class="col-lg-4">
                <select id="sub_area" name="sub_area" class="form-control" required="true">
                  <option value="">- Select -</option>
                  <option value="Head Office">Head Office</option>
                  <option value="Non HO">Non HO</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label">Contract Begin</label>
              <div class="col-lg-3">
                <input type="date" id="contract_begin" name="contract_begin" class="form-control" value="{{ old('contract_begin') }}" required="true">
              </div>
              <label class="col-lg-3 col-form-label">Contract End</label>
              <div class="col-lg-3">
                <input type="date" id="contract_end" name="contract_end" class="form-control" value="{{ old('contract_end') }}" required="true">
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
                      <input type="text" id="ktp_number" name="ktp_number" placeholder="No KTP" class="form-control" required value="{{ old('ktp_number') }}">
                    </div>
                    <label class="col-lg-2 col-form-label">NPWP</label>
                    <div class="col-lg-4">
                      <input type="text" id="npwp" name="npwp" placeholder="NPWP" class="form-control" value="{{ old('npwp') }}">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-lg-2 col-form-label">Address</label>
                    <div class="col-lg-10">
                      <textarea name="origin_address" id="origin_address" class="form-control" cols="7">{{ old('origin_address') }}</textarea>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label" class="form-control">Religion</label>
                  <div class="col-lg-3">
                    <select name="religion" id="religion" class="form-control" required="true">
                      <option value="">- Select -</option>
                      <option value="Buddha">Buddha</option>
                      <option value="Hindu">Hindu</option>
                      <option value="Islam">Islam</option>
                      <option value="Katolik">Katolik</option>
                      <option value="Kristen Protestan">Kristen Protestan</option>
                      <option value="Konghucu">Konghucu</option>
                    </select>
                  </div>
                  <label class="col-lg-2 col-form-label">Email</label>
                  <div class="col-lg-5">
                    <input type="email" id="email" name="email" placeholder="Email" class="form-control" value="{{ old('email') }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label" class="form-control">PTKP</label>
                  <div class="col-lg-2">
                    <select name="ptkp" id="ptkp" class="form-control" required="true">
                      <option value="">Select</option>
                      <option value="TK/0">TK/0</option>
                      <option value="TK/1">TK/1</option>
                      <option value="TK/2">TK/2</option>
                      <option value="TK/3">TK/3</option>
                      <option value="K/0">K/0</option>
                      <option value="K/1">K/1</option>
                      <option value="K/2">K/2</option>
                      <option value="K/3">K/3</option>
                      <option value="K/I/0">K/I/0</option>
                      <option value="K/I/1">K/I/1</option>
                      <option value="K/I/2">K/I/2</option>
                      <option value="K/I/3">K/I/3</option>
                    </select>
                  </div> 
                  <label class="col-lg-3 col-form-label">Company Mail</label>
                  <div class="col-lg-5">
                    <input type="email" id="company_email" name="company_email" placeholder="Company Email" class="form-control" value="{{ old('company_email') }}">
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
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
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label">Temporary Address</label>
                  <div class="col-lg-10">
                    <textarea name="temporary_address" id="temporary_address" class="form-control" cols="7">{{ old('temporary_address') }}</textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Phone Number</label>
                  <div class="col-lg-3">
                    <input type="text" id="phone_number" name="phone_number" placeholder="Phone Number" class="form-control" value="{{ old('phone_number') }}">
                  </div>
                  <label class="col-lg-3 col-form-label">Smartfren Number</label>
                  <div class="col-lg-3">
                    <input type="text" id="smartfren_phone_number" name="smartfren_phone_number" placeholder="Phone Number" class="form-control" value="{{ old('phone_number') }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Passport Number</label>
                  <div class="col-lg-4">
                    <input type="number" id="passport_number" name="passport_number" class="form-control" value="{{ old('passport_number') }}">
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
                <input type="text" id="education_location" name="education_location" placeholder="Institute / Location" class="form-control" value="{{ old('education_location') }}">
              </div>
              <label class="col-lg-1 col-form-label">Certificate</label>
              <div class="col-lg-1">
                <input type="text" id="education_degree" name="education_degree" placeholder="Certificate" class="form-control" value="{{ old('education_degree') }}">
              </div>
              <label class="col-lg-2 col-form-label">Branch Of Study</label>
              <div class="col-lg-3">
                <input type="text" id="education_major" name="education_major" placeholder="Branch Of Study" class="form-control" value="{{ old('education_major') }}">
              </div>
            </div>
          </div>
          <div class="tab-pane fade show" id="custom-content-below-bank" role="tabpanel" aria-labelledby="custom-content-below-bank-tab">
            <br>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Mandiri Account Number<span style="color: red;">*</span></label>
              <div class="col-lg-5">
                <input type="text" id="mandiri_bank_account" name="mandiri_bank_account" placeholder="Mandiri Account Number" class="form-control" required="true" value="{{ old('mandiri_bank_account') }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Sinarmas Account Number<span style="color: red;">*</span></label>
              <div class="col-lg-5">
                <input type="text" id="sinarmas_bank_account" name="sinarmas_bank_account" placeholder="Sinarmas Account Number" class="form-control" required="true" value="{{ old('sinarmas_bank_account') }}">
              </div>  
            </div>
          </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="/hrd/employee" class="back btn btn-secondary">Back</a>
      </form>
    </div>
  </div>
</div>
@endsection