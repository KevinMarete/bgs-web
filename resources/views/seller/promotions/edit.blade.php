<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>Update {{ ucwords($type) }} Promotion</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    <div class="card mb-4">
        <div class="card-header"> </div>
        <div class="card-body">
            <form role="form" action="/promotions/{{ $manage_label }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">DisplayDate</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="hidden" value="{{ isset($edit['id']) ? $edit['id'] : '' }}" name="id" required>
                        <input class="form-control" type="hidden" value="{{ isset($edit['type']) ? $edit['type'] : '' }}" name="type" required>
                        <input class="form-control" type="hidden" value="{{ isset($edit['status']) ? $edit['status'] : '' }}" name="status" required>
                        <input class="form-control" type="hidden" value="{{ isset($edit['display_url']) ? $edit['display_url'] : '' }}" name="display_url" required>
                        <input class="form-control" type="hidden" value="{{ isset($edit['organization_id']) ? $edit['organization_id'] : '' }}" name="organization_id" required>
                        <input class="form-control" type="text" value="{{ isset($edit['display_date']) ? $edit['display_date'] : '' }}" name="display_date" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">DisplayImage</label>
                    <div class="col-lg-3">
                        <img src="{{ isset($edit['display_url']) ? '/'.$edit['display_url'] : '' }}" alt="Image not loaded" width="100" height="100" class="img-fluid img-thumbnail">
                    </div>
                    <div class="col-lg-3">
                        <input type="file" name="upload" accept="image/x-png,image/jpeg" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">PricelistProduct</label>
                    <div class="col-lg-9">
                        <select class="form-control" size="0" name="product_now_id">
                            @foreach ($productnows as $productnow)
                            @if ($productnow['product']['id'] === $edit['product_now']['product_id'])
                            <option value="{{ $productnow['id'] }}" selected>{{ $productnow['product']['molecular_name'].'-'.$productnow['product']['brand_name'] }}</option>
                            @else
                            <option value="{{ $productnow['id'] }}">{{ $productnow['product']['molecular_name'].'-'.$productnow['product']['brand_name'] }}</option>
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