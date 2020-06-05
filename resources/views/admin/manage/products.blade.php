<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
  <div class="container-fluid">
    <div class="sb-page-header-content py-5">
      <h1 class="sb-page-header-title">
        <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
        <span>Manage Products - {{ ucwords($manage_label) }}</span>
      </h1>
    </div>
  </div>
</div>
<div class="container-fluid mt-n10">
  <div class="card mb-4">
    <div class="card-header"> </div>
    <div class="card-body">
      <form role="form" action="/manage/products/{{ $manage_label }}" method="POST">
        @csrf
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">MolecularName</label>
          <div class="col-lg-9">
            <input class="form-control" type="hidden" value="{{ isset($edit['id']) ? $edit['id'] : '' }}" name="id" required>
            <input class="form-control" type="text" value="{{ isset($edit['molecular_name']) ? $edit['molecular_name'] : '' }}" name="molecular_name" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">BrandName</label>
          <div class="col-lg-9">
            <input class="form-control" type="text" value="{{ isset($edit['brand_name']) ? $edit['brand_name'] : '' }}" name="brand_name" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Packsize</label>
          <div class="col-lg-9">
            <input class="form-control" type="text" value="{{ isset($edit['pack_size']) ? $edit['pack_size'] : '' }}" name="pack_size" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">ProductCategory</label>
          <div class="col-lg-9">
            <select class="form-control" size="0" name="product_category_id" required>
              <option value="">Select Product Category</option>
              @foreach ($product_categories as $product_category)
              @if ($product_category['id'] === (isset($edit['product_category_id']) ? $edit['product_category_id'] : ''))
              <option value="{{ $product_category['id'] }}" selected>{{ $product_category['name'] }}</option>
              @else
              <option value="{{ $product_category['id'] }}">{{ $product_category['name'] }}</option>
              @endif
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Organization</label>
          <div class="col-lg-9">
            @if (strtolower(session()->get('organization.organization_type.role.name')) === 'admin')
            <select class="form-control" size="0" name="organization_id" required>
              <option value="">Select Organization</option>
              @foreach ($sellers as $organization)
              @if ($organization['id'] === (isset($edit['organization_id']) ? $edit['organization_id'] : ''))
              <option value="{{ $organization['id'] }}" selected>{{ $organization['name'] }}</option>
              @else
              <option value="{{ $organization['id'] }}">{{ $organization['name'] }}</option>
              @endif
              @endforeach
            </select>
            @else
            <select class="form-control" size="0" readonly name="organization_id" required>
              @foreach ($sellers as $organization)
              @if ($organization['id'] === session()->get('organization_id'))
              <option value="{{ $organization['id'] }}" selected>{{ $organization['name'] }}</option>
              @endif
              @endforeach
            </select>
            @endif
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