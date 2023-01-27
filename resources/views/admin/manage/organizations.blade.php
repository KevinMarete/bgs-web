<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>Manage Organizations - {{ ucwords($manage_label) }}</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    <div class="card mb-4">
        <div class="card-header"> </div>
        <div class="card-body">
            <form role="form" action="/manage/organizations/{{ $manage_label }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Name</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="hidden" value="{{ isset($edit['id']) ? $edit['id'] : '' }}" name="id" required>
                        <input class="form-control" type="text" value="{{ isset($edit['name']) ? $edit['name'] : '' }}" name="name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Town</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" value="{{ isset($edit['town']) ? $edit['town'] : '' }}" name="town" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Road</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" value="{{ isset($edit['road']) ? $edit['road'] : '' }}" name="road" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Building</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" value="{{ isset($edit['building']) ? $edit['building'] : '' }}" name="building" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">OrganizationType</label>
                    <div class="col-lg-9">
                        <select class="form-control" size="0" name="organization_type_id" required>
                            <option value="">Select OrganizationType</option>
                            @foreach ($organizationtypes_all as $organizationtype)
                            @if ($organizationtype['id'] === (isset($edit['organization_type_id']) ? $edit['organization_type_id'] : ''))
                            <option value="{{ $organizationtype['id'] }}" selected>{{ $organizationtype['name'] }}</option>
                            @else
                            <option value="{{ $organizationtype['id'] }}">{{ $organizationtype['name'] }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">PPB Licence</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" value="{{ isset($edit['ppb_licence']) ? $edit['ppb_licence'] : '' }}" name="ppb_licence" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Primary Phone</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" value="{{ isset($edit['primary_phone']) ? $edit['primary_phone'] : '' }}" name="primary_phone" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Secondary Phone</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" value="{{ isset($edit['secondary_phone']) ? $edit['secondary_phone'] : '' }}" name="secondary_phone">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Email</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="email" value="{{ isset($edit['email']) ? $edit['email'] : '' }}" name="email" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Website</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" value="{{ isset($edit['website']) ? $edit['website'] : '' }}" name="website">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label"></label>
                    <div class="col-lg-9">
                        <button type="reset" class="btn btn-secondary"><i class="fa fa-refresh"></i>&nbsp;Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
