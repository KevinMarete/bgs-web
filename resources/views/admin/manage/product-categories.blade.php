<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>Manage ProductCategories - {{ ucwords($manage_label) }}</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    <div class="card mb-4">
        <div class="card-header"> </div>
        <div class="card-body">
            <form role="form" action="/manage/product-categories/{{ $manage_label }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Name</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="hidden" value="{{ isset($edit['id']) ? $edit['id'] : '' }}" name="id" required>
                        <input class="form-control" type="text" value="{{ isset($edit['name']) ? $edit['name'] : '' }}" name="name" required>
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