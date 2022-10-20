@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-header">
    <h4>{{ $title }}</h4>
  </div>
  <div class="form-horizontal">
    <div class="card-body">
      <form method="Post" action="/sys/user_permission/{{ $record->id }}">
        @method('PUT')
        @csrf
        <input type="hidden" id="user_id" name="user_id" value="{{ $record->id }}">
        <input type="hidden" id="updated_by" name="updated_by" value="{{ auth()->user()->id }}">
        <div class="message" style="display: none;"></div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Username<span style="color: red;">*</span></label>
          <div class="col-lg-1">
            <input type="text" id="username" name="username" class="form-control" value="{{ old('username', $record->username) }}" readonly>
          </div>
        </div>
        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
          @foreach ($prefix as $key => $value)
          <li class="nav-item">
            <a class="nav-link {{ $key == 0 ? 'active' : '' }}" id="custom-content-below-{{ $value->prefix }}-tab" data-toggle="pill" href="#custom-content-below-{{ $value->prefix }}" role="tab" aria-controls="custom-content-below-{{ $value->prefix }}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">{{ $value->prefix }}</a>
          </li>
          @endforeach
        </ul>
        <div class="tab-content" id="custom-content-below-tabContent">
          @foreach ($prefix as $key => $value)
          <div class="tab-pane fade {{ $key == 0 ? 'active show' : '' }}" id="custom-content-below-{{ $value->prefix }}" role="tabpanel" aria-labelledby="custom-content-below-{{ $value->prefix }}-tab">
            <br>
            <div class="row">
              <table class="table table-bordered">
                <thead>
                  <tr style="font: small-caption;">
                    <th>Modul</th>
                    <th>Read</th>
                    <th>Create</th>
                    <th>Modify</th>
                    <th>Void</th>
                    <th>Cancel Void</th>
                    <th>Print</th>
                    <th>Import</th>
                    <th>Export</th>
                    <th>Approve 1</th>
                    <th>Cancel Approve 1</th>
                    <th>Approve 2</th>
                    <th>Cancel Approve 2</th>
                    <th>Approve 3</th>
                    <th>Cancel Approve 3</th>
                    <th>Confidential</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($master_menu as $mm)
                  @if ($mm->prefix == $value->prefix)
                  <?php
                  $permission = new \App\Models\IbsUserPermission();
                  $cek_id = ($permission::getData($mm->id, $record->id));
                  ?>
                  <tr>
                    <td>
                      @if ($cek_id != null)
                      <input type="hidden" name="id[]" id="id[]" value="{{ $cek_id->id }}">
                      @endif
                      <input type="hidden" name="ibs_menu_id[]" id="ibs_menu_id[]" value="{{ $mm->id }}">
                      {{ $mm->name }}
                    </td>
                    <td><input type="checkbox" name="read[{{ $mm->id }}]" value="1" {{ $cek_id != null && $cek_id->read == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="create[{{ $mm->id }}]" value="1" {{ $cek_id != null && $cek_id->create == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="modify[{{ $mm->id }}]" value="1" {{ $cek_id != null && $cek_id->modify == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="void[{{ $mm->id }}]" value="1" {{ $cek_id != null && $cek_id->void == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="cancel_void[{{ $mm->id }}]" value="1" {{ $cek_id != null && $cek_id->cancel_void == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="print[{{ $mm->id }}]" value="1" {{ $cek_id != null && $cek_id->print == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="import[{{ $mm->id }}]" value="1" {{ $cek_id != null && $cek_id->import == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="export[{{ $mm->id }}]" value="1" {{ $cek_id != null && $cek_id->export == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="approve_1[{{ $mm->id }}]" value="1" {{ $cek_id != null && $cek_id->approve_1 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="cancel_approve_1[{{ $mm->id }}]" value="1" {{ $cek_id != null && $cek_id->cancel_approve_1 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="approve_2[{{ $mm->id }}]" value="1" {{ $cek_id != null && $cek_id->approve_2 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="cancel_approve_2[{{ $mm->id }}]" value="1" {{ $cek_id != null && $cek_id->cancel_approve_2 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="approve_3[{{ $mm->id }}]" value="1" {{ $cek_id != null && $cek_id->approve_3 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="cancel_approve_3[{{ $mm->id }}]" value="1" {{ $cek_id != null && $cek_id->cancel_approve_3 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="confidential[{{ $mm->id }}]" value="1" {{ $cek_id != null && $cek_id->confidential == 1 ? 'checked' : '' }}></td>
                  </tr>
                  @foreach ($sub_menu as $sm)
                  @if ($sm->master_menu == $mm->id && $sm->prefix == $value->prefix)
                  <?php
                  $permission = new \App\Models\IbsUserPermission();
                  $cek_id = ($permission::getData($sm->id, $record->id));
                  ?>
                  <tr>
                    <td>
                      @if ($cek_id != null)
                      <input type="hidden" name="id[]" id="id[]" value="{{ $cek_id->id }}">
                      @endif
                      <input type="hidden" name="ibs_menu_id[]" id="ibs_menu_id[]" value="{{ $sm->id }}">
                      ==> {{ $sm->name }}
                    </td>
                    <td><input type="checkbox" name="read[{{ $sm->id }}]" value="1" {{ $cek_id != null && $cek_id->read == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="create[{{ $sm->id }}]" value="1" {{ $cek_id != null && $cek_id->create == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="modify[{{ $sm->id }}]" value="1" {{ $cek_id != null && $cek_id->modify == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="void[{{ $sm->id }}]" value="1" {{ $cek_id != null && $cek_id->void == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="cancel_void[{{ $sm->id }}]" value="1" {{ $cek_id != null && $cek_id->cancel_void == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="print[{{ $sm->id }}]" value="1" {{ $cek_id != null && $cek_id->print == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="import[{{ $sm->id }}]" value="1" {{ $cek_id != null && $cek_id->import == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="export[{{ $sm->id }}]" value="1" {{ $cek_id != null && $cek_id->export == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="approve_1[{{ $sm->id }}]" value="1" {{ $cek_id != null && $cek_id->approve_1 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="cancel_approve_1[{{ $sm->id }}]" value="1" {{ $cek_id != null && $cek_id->cancel_approve_1 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="approve_2[{{ $sm->id }}]" value="1" {{ $cek_id != null && $cek_id->approve_2 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="cancel_approve_2[{{ $sm->id }}]" value="1" {{ $cek_id != null && $cek_id->cancel_approve_2 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="approve_3[{{ $sm->id }}]" value="1" {{ $cek_id != null && $cek_id->approve_3 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="cancel_approve_3[{{ $sm->id }}]" value="1" {{ $cek_id != null && $cek_id->cancel_approve_3 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="confidential[{{ $sm->id }}]" value="1" {{ $cek_id != null && $cek_id->confidential == 1 ? 'checked' : '' }}></td>
                  </tr>
                  @foreach ($parent_sub_menu as $pm)
                  @if ($pm->main_sub_menu == $sm->id && $pm->prefix == $value->prefix)
                  <?php
                  $permission = new \App\Models\IbsUserPermission();
                  $cek_id = ($permission::getData($pm->id, $record->id));
                  ?>
                  <tr>
                    <td>
                      @if ($cek_id != null)
                      <input type="hidden" name="id[]" id="id[]" value="{{ $cek_id->id }}">
                      @endif
                      <input type="hidden" name="ibs_menu_id[]" id="ibs_menu_id[]" value="{{ $pm->id }}">
                      =====> {{ $pm->name }}
                    </td>
                    <td><input type="checkbox" name="read[{{ $pm->id }}]" value="1" {{ $cek_id != null && $cek_id->read == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="create[{{ $pm->id }}]" value="1" {{ $cek_id != null && $cek_id->create == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="modify[{{ $pm->id }}]" value="1" {{ $cek_id != null && $cek_id->modify == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="void[{{ $pm->id }}]" value="1" {{ $cek_id != null && $cek_id->void == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="cancel_void[{{ $pm->id }}]" value="1" {{ $cek_id != null && $cek_id->cancel_void == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="print[{{ $pm->id }}]" value="1" {{ $cek_id != null && $cek_id->print == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="import[{{ $pm->id }}]" value="1" {{ $cek_id != null && $cek_id->import == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="export[{{ $pm->id }}]" value="1" {{ $cek_id != null && $cek_id->export == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="approve_1[{{ $pm->id }}]" value="1" {{ $cek_id != null && $cek_id->approve_1 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="cancel_approve_1[{{ $pm->id }}]" value="1" {{ $cek_id != null && $cek_id->cancel_approve_1 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="approve_2[{{ $pm->id }}]" value="1" {{ $cek_id != null && $cek_id->approve_2 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="cancel_approve_2[{{ $pm->id }}]" value="1" {{ $cek_id != null && $cek_id->cancel_approve_2 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="approve_3[{{ $pm->id }}]" value="1" {{ $cek_id != null && $cek_id->approve_3 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="cancel_approve_3[{{ $pm->id }}]" value="1" {{ $cek_id != null && $cek_id->cancel_approve_3 == 1 ? 'checked' : '' }}></td>
                    <td><input type="checkbox" name="confidential[{{ $pm->id }}]" value="1" {{ $cek_id != null && $cek_id->confidential == 1 ? 'checked' : '' }}></td>
                  </tr>
                  @endif
                  @endforeach
                  @endif
                  @endforeach
                  @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @endforeach
        </div>
        <hr>
        <button type=" submit" class="save btn btn-primary">Save</button>
        <a href="/sys/user_permission" class="back btn btn-secondary">Back</a>
      </form>
    </div>
  </div>
</div>
@endsection