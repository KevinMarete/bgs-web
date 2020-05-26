<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>New Stock Item(s)</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    <div class="card mb-4">
        <div class="card-header"> </div>
        <div class="card-body">
            <form role="form" action="/stocks/save" method="POST">
                @csrf
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Transaction Date</label>
                                <input class="form-control" type="date" value="{{ date('Y-m-d') }}" name="transaction_date" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                            </div>
                            <div class="form-group">
                                <label>StockType</label>
                                <select class="form-control" size="0" name="stock_type_id" required>
                                    <option value="">Select StockType</option>
                                    @foreach ($stocktypes as $stocktype)
                                    <option value="{{ $stocktype['id'] }}">{{ $stocktype['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Save</button>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="sb-datatable table-responsive">
                                <table class="table table-bordered table-hover transactions-tbl" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Batch No.</th>
                                            <th>Expiry Date</th>
                                            <th>Quantity</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Product</th>
                                            <th>Batch No.</th>
                                            <th>Expiry Date</th>
                                            <th>Quantity</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr class="tr_clone">
                                            <td>
                                                <select class="product col-md-12" size="0" name="product_id[]" required>
                                                    <option value="">Select Product</option>
                                                    @foreach ($products as $product)
                                                    <option value="{{ $product['id'] }}">{{ $product['molecular_name']  }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="batch_number" value="" name="batch_number[]" required />
                                            </td>
                                            <td>
                                                <input type="date" class="expiry_date" value="" name="expiry_date[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required />
                                            </td>
                                            <td>
                                                <input type="text" class="quantity" value="" name="quantity[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required />
                                            </td>
                                            <td>
                                                <a href="#" class="add"><i class="fa fa-plus"></i></a> |
                                                <a href="#" class="remove"><i class="fa fa-minus"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>