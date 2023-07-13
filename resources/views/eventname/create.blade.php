<form id="createEventForm">
  <div class="row mb-2">
    <div class="col">
      <label for="code" title="{{ $tableComments['code'] }}"><b>Code</b></label>
      <input type="text" class="form-control" name="code">
    </div>
    <div class="col">
      <label title="{{ $tableComments['is_task'] }}">Is task</label>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="is_task" value="1">
        <label class="form-check-label">Yes</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="is_task" value="0" checked>
        <label class="form-check-label">No</label>
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col">
      <label for="name" title="{{ $tableComments['name'] }}"><b>Name</b></label>
      <input type="text" class="form-control" name="name">
    </div>
    <div class="col">
      <label title="{{ $tableComments['status_event'] }}">Is status event</label>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="status_event" value="1">
        <label class="form-check-label">Yes</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="status_event" value="0" checked>
        <label class="form-check-label">No</label>
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col">
      <label title="{{ $tableComments['default_responsible'] }}">Default responsible</label>
      <input type='hidden' name='default_responsible'>
      <input type="text" class="form-control" data-ac="/user/autocomplete" data-actarget="default_responsible"
        autocomplete="off">
    </div>
    <div class="col">
      <label title="{{ $tableComments['use_matter_resp'] }}">Use matter responsible</label>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="use_matter_resp" value="1">
        <label class="form-check-label">Yes</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="use_matter_resp" value="0" checked>
        <label class="form-check-label">No</label>
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col">
      <label for="country" title="{{ $tableComments['country'] }}">Country</label>
      <input type='hidden' name='country'>
      <input type="text" class="form-control" data-ac="/country/autocomplete" data-actarget="country"
        autocomplete="off">
    </div>
    <div class="col">
      <label for="category" title="{{ $tableComments['category'] }}">Category</label>
      <input type='hidden' name='category'>
      <input type="text" class="form-control" data-ac="/category/autocomplete" data-actarget="category"
        autocomplete="off">
    </div>
  </div>
  <div class="row mb-2">
    <div class="col">
      <label for="notes" title="{{ $tableComments['notes'] }}">Notes</label>
      <textarea class="form-control" name="notes"></textarea>
    </div>
    <div class="col">
      <label title="{{ $tableComments['killer'] }}">Is killer</label>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="killer" value="1">
        <label class="form-check-label">Yes</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="killer" value="0" checked>
        <label class="form-check-label">No</label>
      </div>
    </div>
  </div>
  <div class="d-grid">
    <button type="button" id="createEventNameSubmit" class="btn btn-primary">Create event name</button>
  </div>
</form>