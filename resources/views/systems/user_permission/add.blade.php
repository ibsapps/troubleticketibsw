@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-header">
    <h4>{{ $title }}</h4>
  </div>
  <div class="form-horizontal">
    <div class="card-body">
      <form method="POST" action="/sys/user_permission">
        @csrf
        <input type="hidden" id="created_by" name="created_by" value="{{ auth()->user()->id }}">
        <div class="message" style="display: none;"></div>
        <div class="form-group row">
          <label class="col-lg-1 col-form-label">Username<span style="color: red;">*</span></label>
          <div class="col-lg-3">
            <select name="user_id" id="user_id" class="form-control" required>
              <option value="">- Select -</option>
              @foreach ($record as $key => $value)
              <option value="{{ $value->id }}">{{ $value->username }}</option>
              @endforeach
            </select>
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
                    <th>Export</th>
                    <th>Approve 1</th>
                    <th>Cancel Approve 1</th>
                    <th>Approve 2</th>
                    <th>Cancel Approve 2</th>
                    <th>Approve 3</th>
                    <th>Cancel Approve 3</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($master_menu as $mm)
                  @if ($mm->prefix == $value->prefix)
                  <tr>
                    <td>
                      <input type="hidden" name="ibs_menu_id[]" id="ibs_menu_id[]" value="{{ $mm->id }}">
                      {{ $mm->name }}
                    </td>
                    <td><input type="checkbox" name="read[{{ $mm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="create[{{ $mm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="modify[{{ $mm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="void[{{ $mm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="cancel_void[{{ $mm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="print[{{ $mm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="export[{{ $mm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="approve_1[{{ $mm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="cancel_approve_1[{{ $mm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="approve_2[{{ $mm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="cancel_approve_2[{{ $mm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="approve_3[{{ $mm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="cancel_approve_3[{{ $mm->id }}]" value="1"></td>
                  </tr>
                  @foreach ($sub_menu as $sm)
                  @if ($sm->master_menu == $mm->id && $sm->prefix == $value->prefix)
                  <tr>
                    <td>
                      <input type="hidden" name="ibs_menu_id[]" id="ibs_menu_id[]" value="{{ $sm->id }}">
                      ==> {{ $sm->name }}
                    </td>
                    <td><input type="checkbox" name="read[{{ $sm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="create[{{ $sm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="modify[{{ $sm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="void[{{ $sm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="cancel_void[{{ $sm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="print[{{ $sm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="export[{{ $sm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="approve_1[{{ $sm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="cancel_approve_1[{{ $sm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="approve_2[{{ $sm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="cancel_approve_2[{{ $sm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="approve_3[{{ $sm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="cancel_approve_3[{{ $sm->id }}]" value="1"></td>
                  </tr>
                  @foreach ($parent_sub_menu as $pm)
                  @if ($pm->main_sub_menu == $sm->id_ibs_menu && $pm->prefix == $value->prefix) : ?>
                  <tr>
                    <td>
                      <input type="hidden" name="ibs_menu_id[]" id="ibs_menu_id[]" value="{{ $pm->id }}">
                      =====> {{ $pm->name }}
                    </td>
                    <td><input type="checkbox" name="read[{{ $pm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="create[{{ $pm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="modify[{{ $pm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="void[{{ $pm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="cancel_void[{{ $pm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="print[{{ $pm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="export[{{ $pm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="approve_1[{{ $pm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="cancel_approve_1[{{ $pm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="approve_2[{{ $pm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="cancel_approve_2[{{ $pm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="approve_3[{{ $pm->id }}]" value="1"></td>
                    <td><input type="checkbox" name="cancel_approve_3[{{ $pm->id }}]" value="1"></td>
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