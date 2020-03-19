<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>Manage MenuRoles - {{ ucwords($manage_label) }}</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    <div class="card mb-4">
        <div class="card-header"> </div>
        <div class="card-body">
            <form role="form" action="/manage/menu-roles/{{ $manage_label }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Menu</label>
                    <div class="col-lg-9">
                        <select class="form-control" size="0" name="menu_id" required>
                            <option value="">Select Menu</option>
                            @foreach ($menus as $menu)
                                @if ($menu['id'] === (isset($edit['menu_id']) ? $edit['menu_id'] : ''))
                                    <option value="{{ $menu['id'] }}" selected>{{ $menu['name'] }}</option>
                                @else
                                    <option value="{{ $menu['id'] }}">{{ $menu['name'] }}</option>
                                @endif
                            @endforeach
                        </select></div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Role</label>
                    <div class="col-lg-9">
                        <select class="form-control" size="0" name="role_id" required>
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                @if ($role['id'] === (isset($edit['role_id']) ? $edit['role_id'] : ''))
                                    <option value="{{ $role['id'] }}" selected>{{ $role['name'] }}</option>
                                @else
                                    <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                @endif
                            @endforeach
                        </select>
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