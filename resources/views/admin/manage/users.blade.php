<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
  <div class="container-fluid">
    <div class="sb-page-header-content py-5">
      <h1 class="sb-page-header-title">
        <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
        <span>Manage Admin Users - {{ ucwords($manage_label) }}</span>
      </h1>
    </div>
  </div>
</div>
<div class="container-fluid mt-n10">
  @if (Session::has('bgs_msg'))
  {!! session('bgs_msg') !!}
  @endif
  <div class="card mb-4">
    <div class="card-header"> </div>
    <div class="card-body">
      <form action="/add-admin-account" method="POST">
        @csrf
        <div class="form-row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="small mb-1" for="inputFirstName">First Name</label>
              <input class="form-control" type="hidden" value="{{ isset($edit['id']) ? $edit['id'] : '' }}" name="id" required>
              <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter first name" name="firstname" required />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group"><label class="small mb-1" for="inputLastName">Last Name</label><input class="form-control py-4" id="inputLastName" type="text" placeholder="Enter last name" name="lastname" required /></div>
          </div>
        </div>
        <div class="form-group">
          <label class="small mb-1" for="selectOrganization">Organization</label>
          <select class="form-control form-control-solid" aria-label="Organization Name" aria-describedby="organizationHelp" name="organization_id" required>
            <option value="">Select Organization</option>
            @foreach ($admins as $organization)
            <option value="{{ $organization['id'] }}">{{ $organization['name'] }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-row">
          <div class="col-md-6">
            <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Email</label><input class="form-control py-4" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Enter email address" name="email" required /></div>
          </div>
          <div class="col-md-6">
            <div class="form-group"><label class="small mb-1" for="inputPhone">Phone</label><input class="form-control py-4" id="inputPhone" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" aria-describedby="phoneHelp" placeholder="Enter phone number" name="phone" required /></div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6">
            <div class="form-group"><label class="small mb-1" for="inputPassword">Password</label><input class="form-control py-4" id="inputPassword" type="password" placeholder="Enter password" name="password" required /></div>
          </div>
          <div class="col-md-6">
            <div class="form-group"><label class="small mb-1" for="inputConfirmPassword">Confirm Password</label><input class="form-control py-4" id="inputConfirmPassword" type="password" placeholder="Confirm password" name="cpassword" required /></div>
          </div>
        </div>
        <div class="form-group">
          <div class="custom-control custom-checkbox">
            <input type="hidden" name="is_mailing_list" value="false">
            <input type="checkbox" class="custom-control-input" id="mailingList" name="is_mailing_list" value="true">
            <label class="custom-control-label" for="mailingList"><strong>Subscribe to join our weekly promotions &amp; deals mailing list</strong></label>
          </div>
        </div>
        <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit">Create Account</button></div>
      </form>
    </div>
  </div>
</div>