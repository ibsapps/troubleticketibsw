<form method="POST" action="/hrd/employee/{{ $record->id }}">
  @method('PUT')
  @csrf
  @if (session('error'))
  <div class="alert alert-danger" role="alert">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{ session('error') }}
  </div>
  @endif
  <input type="hidden" id="id" name="id" value="{{ $last_id }}">
  <input type="hidden" id="status" name="status" value="{{ $status }}">
  <input type="hidden" id="detail_status" name="detail_status" value="{{ $detail_status }}">
  <input type="hidden" id="new_record[status]" name="new_record[status]" value="renew">
  <input type="hidden" id="new_record[created_by]" name="new_record[created_by]" value="{{ auth()->user()->id }}">
  <input type="hidden" id="new_record[entry_date]" name="new_record[entry_date]" value="{{ date('Y-m-d')}}">
  <div class="message" style="display: none;"></div>
  <div class="row">
    <div class="col-lg-6">
      <div class="form-group row">
        <label class="col-lg-2 col-form-label">NIP <span style="color: red;">*</span></label>
        <div class="col-lg-4">
          <input type="text" id="new_record[nik]" name="new_record[nik]" placeholder="Personnel No" class="form-control" maxlength="8" value="{{ $record->nik }}" disabled="true">
        </div>
        <label class="col-lg-2 col-form-label">Join Date <span style="color: red;">*</span></label>
        <div class="col-lg-4">
          <input type="date" id="new_record[join_date]" name="new_record[join_date]" class="form-control" required="true">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-lg-2 col-form-label">Name <span style="color: red;">*</span></label>
        <div class="col-lg-10">
          <input type="text" id="new_record[name]" name="new_record[name]" placeholder="Employee Name" class="form-control" value="{{ $record->name }}" disabled="true">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-lg-2 col-form-label">Birth Date <span style="color: red;">*</span></label>
        <div class="col-lg-4">
          <input type="date" id="new_record[born_date]" name="new_record[born_date]" class="form-control" value="{{ $record->born_date }}" disabled="true">
        </div>
        <label class="col-lg-2 col-form-label">Birth Place</label>
        <div class="col-lg-4">
          <input type="text" id="new_record[place_of_birth]" name="new_record[place_of_birth]" placeholder="Birth Place" class="form-control" value="{{ $record->place_of_birth }}" disabled="true">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-lg-2 col-form-label">Gender <span style="color: red;">*</span></label>
        <div class="col-lg-3">
          <input type="text" name="new_record[gender]" id="new_record[gender]" class="form-control" value="{{ $record->gender }}" disabled="true">
        </div>
        <label class="col-lg-3 col-form-label">Marital Status</label>
        <div class="col-lg-4">
          <select name="new_record[marital_status]" id="new_record[marital_status]" class="form-control" required="true">
            <option value="">- Select -</option>
            <option value="Married" {{ $record->marital_status == 'Married' ? 'selected' : '' }}>Married</option>
            <option value="Single" {{ $record->marital_status == 'Single' ? 'selected' : '' }}>Single</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-lg-2 col-form-label">Cost Center</label>
        <div class="col-lg-3">
          <select id="new_record[cost_center]" name="new_record[cost_center]" class="form-control" required="true">
            <option value="">- Select -</option>
            <option value="IBSW - FAD" {{ $record->cost_center == 'IBSW - FAD' ? 'selected' : '' }}>IBSW - FAD</option>
            <option value="IBSW - COM" {{ $record->cost_center == 'IBSW - COM' ? 'selected' : '' }}>IBSW - COM</option>
            <option value="IBSW - PRO" {{ $record->cost_center == 'IBSW - PRO' ? 'selected' : '' }}>IBSW - PRO</option>
          </select>
        </div>
        <label class="col-lg-3 col-form-label">Cost Description</label>
        <div class="col-lg-4">
          <select id="new_record[cost_center_description]" name="new_record[cost_center_description]" class="form-control" required="true">
            <option value="">- Select -</option>
            <option value="IBSW Financial & Accounting" {{ $record->cost_center_description == 'IBSW Financial & Accounting' ? 'selected' : '' }}>IBSW Financial & Accounting</option>
            <option value="IBSW Commercial" {{ $record->cost_center_description == 'IBSW Commercial' ? 'selected' : '' }}>IBSW Commercial</option>
            <option value="IBSW Procurement" {{ $record->cost_center_description == 'IBSW Procurement' ? 'selected' : '' }}>IBSW Procurement</option>
          </select>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="form-group row">
        <label class="col-lg-2 col-form-label">Department</label>
        <div class="col-lg-4">
          <select name="new_record[ibs_department_id]" id="new_record[ibs_department_id]" class="form-control" required="true">
            <option value="">--Select--</option>
            @foreach ($departments as $key => $value)
            <option value="<?= $value->id ?>" {{ $record->ibs_department_id == $value->id ? 'selected' : '' }}><?= $value->name ?></option>
            @endforeach
          </select>
        </div>
        <label class="col-lg-2 col-form-label">Division</label>
        <div class="col-lg-4">
          <select name="new_record[ibs_division_id]" id="new_record[ibs_division_id]" class="form-control" required="true">
            <option value="">- Select -</option>
            @foreach ($divisions as $key => $value)
            <option value="<?= $value->id ?>" {{ $record->ibs_division_id == $value->id ? 'selected' : '' }}><?= $value->name ?></option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-lg-2 col-form-label">Position</label>
        <div class="col-lg-4">
          <select name="new_record[ibs_position_id]" id="new_record[ibs_position_id]" class="form-control" required="true">
            <option value="">-Select-</option>
            @foreach ($positions as $key => $value)
            <option value="<?= $value->id ?>" {{ $record->ibs_position_id == $value->id ? 'selected' : '' }}><?= $value->name ?></option>
            @endforeach
          </select>
        </div>
        <label class="col-lg-2 col-form-label">Contract</span></label>
        <div class="col-lg-4">
          @if ($detail_status == 'Appointment Permanent Employee')
            <input type="new_record[contract_status]" name="new_record[contract_status]" class="form-control" readonly="true" value="Permanent">
          @else
            <select id="new_record[contract_status]" name="new_record[contract_status]" class="form-control" required="true">
              <option value="">- Select -</option>
              <option value="Contract" {{ $record->contract_status == 'Contract' ? 'selected' : '' }}>Contract</option>
              <option value="Permanent" {{ $record->contract_status == 'Permanent' ? 'selected' : '' }}>Permanent</option>
            </select>
          @endif
        </div>
      </div>
      <div class="form-group row">
        <label class="col-lg-2 col-form-label">Group</label>
        <div class="col-lg-3">
          <select id="new_record[group]" name="new_record[group]" class="form-control" required="true">
            <option value="">- Select -</option>
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
          <select id="new_record[directorate]" name="new_record[directorate]" class="form-control" required="true">
            <option value="">- Select -</option>
            <option value="Financial" {{ $record->directorate == 'Financial' ? 'selected' : '' }}>Financial</option>
            <option value="Marketing" {{ $record->directorate == 'Marketing' ? 'selected' : '' }}>Marketing</option>
            <option value="Operational" {{ $record->directorate == 'Operational' ? 'selected' : '' }}>Operational</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-lg-2 col-form-label">Area</label>
        <div class="col-lg-4">
          <select name="new_record[area]" id="new_record[area]" class="form-control" required="true">
            <option value="">- Select -</option>
            <option value="IBSW - JAKARTA" {{ $record->area == 'IBSW - JAKARTA' ? 'selected' : '' }}>IBSW - JAKARTA</option>
            <option value="IBSW - PAPUA" {{ $record->area == 'IBSW - PAPUA' ? 'selected' : '' }}>IBSW - PAPUA</option>
          </select>
        </div>
        <label class="col-lg-2 col-form-label">Sub Area</label>
        <div class="col-lg-4">
          <select id="new_record[sub_area]" name="new_record[sub_area]" class="form-control" required="true">
            <option value="">- Select -</option>
            <option value="Head Office" {{ $record->sub_area == 'Head Office' ? 'selected' : '' }}>Head Office</option>
            <option value="Non HO" {{ $record->sub_area == 'Non HO' ? 'selected' : '' }}>Non HO</option>
          </select>
        </div>
      </div>
      @if ($detail_status != 'Appointment Permanent Employee')
        <div class="form-group row">
          <label class="col-lg-3 col-form-label">Contract Begin</label>
          <div class="col-lg-3">
            <input type="date" id="new_record[contract_begin]" name="new_record[contract_begin]" class="form-control" value="{{ $record->contract_begin}}" required="true">
          </div>
          <label class="col-lg-3 col-form-label">Contract End</label>
          <div class="col-lg-3">
            <input type="date" id="new_record[contract_end]" name="new_record[contract_end]" class="form-control" value="{{ $record->contract_end }}" required="true">
          </div>
        </div>
      @endif
    </div>
  </div>
  <hr>
  <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="custom-content-below-general_modal-tab" data-toggle="pill" href="#custom-content-below-general_modal" role="tab" aria-controls="custom-content-below-general_modal" aria-selected="true">General</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-education_modal-tab" data-toggle="pill" href="#custom-content-below-education_modal" role="tab" aria-controls="custom-content-below-education_modal" aria-selected="false">Education</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-bank_modal-tab" data-toggle="pill" href="#custom-content-below-bank_modal" role="tab" aria-controls="custom-content-below-bank_modal" aria-selected="false">Bank</a>
    </li>
  </ul>
  <div class="tab-content" id="custom-content-below-tabContent">
    <div class="tab-pane fade show active" id="custom-content-below-general_modal" role="tabpanel" aria-labelledby="custom-content-below-general_modal-tab">
      <br>
      <div class="row">
        <div class="col-lg-6">
          <div class="form-group">
            <div class="row">
              <label class="col-lg-2 col-form-label">KTP No. <span style="color: red;">*</span></label>
              <div class="col-lg-4">
                <input type="text" id="new_record[ktp_number]" name="new_record[ktp_number]" placeholder="No KTP" class="form-control" value="{{ $record->ktp_number }}" disabled="true">
              </div>
              <label class="col-lg-2 col-form-label">NPWP</label>
              <div class="col-lg-4">
                <input type="text" id="new_record[npwp]" name="new_record[npwp]" placeholder="NPWP" class="form-control" value="{{ $record->npwp }}" disabled="true">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-lg-2 col-form-label">Address</label>
              <div class="col-lg-10">
                <textarea name="new_record[origin_address]" id="new_record[origin_address]" class="form-control" cols="7" disabled="true">{{ $record->origin_address }}</textarea>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-form-label" class="form-control">Religion</label>
            <div class="col-lg-3">
              <select name="new_record[religion]" id="new_record[religion]" class="form-control" disabled="true">
                <option value="">- Select -</option>
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
              <input type="email" id="new_record[email]" name="new_record[email]" placeholder="Email" class="form-control" value="{{ $record->email }}" disabled="true">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-form-label" class="form-control">PTKP</label>
            <div class="col-lg-2">
              <select name="new_record[ptkp]" id="new_record[ptkp]" class="form-control" required="true">
                <option value="">Select</option>
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
              <input type="email" id="new_record[company_email]" name="new_record[company_email]" placeholder="Company Email" class="form-control" value="{{ $record->company_email }}" disabled="true">
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <div class="row">
              <label class="col-lg-2 col-form-label">BPJS TK</label>
              <div class="col-lg-4">
                <input type="text" id="new_record[bpjs_tk]" name="new_record[bpjs_tk]" placeholder="No BPJS Ketenagakerjaan" class="form-control" value="{{ $record->bpjs_tk }}" disabled="true">
              </div>
              <label class="col-lg-2 col-form-label">BPJS Kes</label>
              <div class="col-lg-4">
                <input type="text" id="new_record[bpjs_kes]" name="new_record[bpjs_kes]" placeholder="No BPJS Kesehatan" class="form-control" value="{{ $record->bpjs_kes }}" disabled="true">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-form-label">Temporary Address</label>
            <div class="col-lg-10">
              <textarea name="new_record[temporary_address]" id="new_record[temporary_address]" class="form-control" cols="7" disabled="true">{{ $record->temporary_address }}</textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label">Phone Number</label>
            <div class="col-lg-3">
              <input type="text" id="new_record[phone_number]" name="new_record[phone_number]" placeholder="Phone Number" class="form-control" value="{{ $record->phone_number }}" disabled="true">
            </div>
            <label class="col-lg-3 col-form-label">Smartfren Number</label>
            <div class="col-lg-3">
              <input type="text" id="new_record[smartfren_phone_number]" name="new_record[smartfren_phone_number]" placeholder="Phone Number" class="form-control" value="{{ $record->phone_number }}" disabled="true">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label">Passport Number</label>
            <div class="col-lg-4">
              <input type="number" id="new_record[passport_number]" name="new_record[passport_number]" class="form-control" value="{{ $record->passport_number }}" disabled="true">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane fade" id="custom-content-below-education_modal" role="tabpanel" aria-labelledby="custom-content-below-education_modal-tab">
      <br>
      <div class="form-group row">
        <label class="col-lg-1 col-form-label">Institute</label>
        <div class="col-lg-4">
          <input type="text" id="new_record[education_location]" name="new_record[education_location]" placeholder="Institute / Location" class="form-control" value="{{ $record->education_location }}" disabled="true">
        </div>
        <label class="col-lg-1 col-form-label">Certificate</label>
        <div class="col-lg-1">
          <input type="text" id="new_record[education_degree]" name="new_record[education_degree]" placeholder="Certificate" class="form-control" value="{{ $record->education_degree }}" disabled="true">
        </div>
        <label class="col-lg-2 col-form-label">Branch Of Study</label>
        <div class="col-lg-3">
          <input type="text" id="new_record[education_major]" name="new_record[education_major]" placeholder="Branch Of Study" class="form-control" value="{{ $record->education_major }}" disabled="true">
        </div>
      </div>
    </div>
    <div class="tab-pane fade show" id="custom-content-below-bank_modal" role="tabpanel" aria-labelledby="custom-content-below-bank_modal-tab">
      <br>
      <div class="form-group row">
        <label class="col-lg-2 col-form-label">Mandiri Account Number<span style="color: red;">*</span></label>
        <div class="col-lg-5">
          <input type="text" id="new_record[mandiri_bank_account]" name="new_record[mandiri_bank_account]" placeholder="Mandiri Account Number" class="form-control" required="true" value="{{ $record->mandiri_bank_account }}" disabled="true">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-lg-2 col-form-label">Sinarmas Account Number<span style="color: red;">*</span></label>
        <div class="col-lg-5">
          <input type="text" id="new_record[sinarmas_bank_account]" name="new_record[sinarmas_bank_account]" placeholder="Sinarmas Account Number" class="form-control" required="true" value="{{ $record->sinarmas_bank_account }}" disabled="true">
        </div>  
      </div>
    </div>
  </div>
  <hr>
  <button type="submit" class="btn btn-primary">Save</button>
  <button type="button" class="btn btn-secondary" data-dismiss="modal">back</button>
</form>