<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>Manage Offers - {{ ucwords($manage_label) }}</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    <div class="card mb-4">
        <div class="card-header"> </div>
        <div class="card-body">
            <form role="form" action="/manage/offers/{{ $manage_label }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Description</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="hidden" value="{{ isset($edit['id']) ? $edit['id'] : '' }}" name="id" required>
                        <input class="form-control" type="text" value="{{ isset($edit['description']) ? $edit['description'] : '' }}" name="description" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">ValidFrom</label>
                    <div class="col-lg-3">
                        <input class="form-control" type="date" value="{{ isset($edit['valid_from']) ? $edit['valid_from'] : '' }}" name="valid_from" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                    </div>
                    <label class="col-lg-3 col-form-label form-control-label">ValidUntil</label>
                    <div class="col-lg-3">
                        <input class="form-control" type="date" value="{{ isset($edit['valid_until']) ? $edit['valid_until'] : '' }}" name="valid_until" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Discount</label>
                    <div class="col-lg-3">
                        <input class="form-control" type="text" value="{{ isset($edit['discount']) ? $edit['discount'] : '' }}" name="discount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                    </div>
                    <label class="col-lg-3 col-form-label form-control-label">MaximumDiscountAmount</label>
                    <div class="col-lg-3">
                        <input class="form-control" type="text" value="{{ isset($edit['max_discount_amount']) ? $edit['max_discount_amount'] : '' }}" name="max_discount_amount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Organizations</label>
                    <div class="col-lg-9">
                        <select class="form-control" size="0" readonly name="organization_id" required>
                            <option value="">Select Organization</option>
                            @foreach ($organizations as $organization)
                                @if ($organization['id'] === session()->get('organization_id'))
                                    <option value="{{ $organization['id'] }}" selected>{{ $organization['name'] }}</option>
                                @else
                                    <option value="{{ $organization['id'] }}">{{ $organization['name'] }}</option>
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