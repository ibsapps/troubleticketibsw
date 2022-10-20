@switch ($kind)
@case (2)
  <select id="reason_of_status" name="reason_of_status" class="form-control" required="true">
    <option value="Retired">Retired</option>
    <option value="Death Of Employee">Death Of Employee</option>
    <option value="Resigned">Resigned</option>
  </select>
  @break
@case (4)
  <select id="reason_of_status" name="reason_of_status" class="form-control" required="true">
    <option value="Appointment Permanent Employee">Appointment Permanent Employee</option>
    <option value="Mutation">Mutation</option>
    <option value="Promotion">Promotion</option>
    <option value="Reorganization">Reorganization</option>
  </select>
  @break
@default
@endswitch