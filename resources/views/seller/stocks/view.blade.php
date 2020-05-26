<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>View Stock Item</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    <div class="card mb-4">
        <div class="card-header"> </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>MolecularName</label>
                            <input class="form-control" type="text" value="{{ $product['molecular_name'] }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>BrandName</label>
                            <input class="form-control" type="text" value="{{ $product['brand_name'] }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>PackSize</label>
                            <input class="form-control" type="text" value="{{ $product['pack_size'] }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Strength</label>
                            <input class="form-control" type="text" value="{{ $product['strength'] }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="sb-datatable table-responsive">
                            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                <caption style="caption-side: top">Batch Balances</caption>
                                <thead>
                                    <tr>
                                        <th>Batch No.</th>
                                        <th>Expiry Date</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Batch No.</th>
                                        <th>Expiry Date</th>
                                        <th>Quantity</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($balances as $balance)
                                    <tr>
                                        <td>{{ $balance['batch_number'] }}</td>
                                        <td>{{ $balance['expiry_date'] }}</td>
                                        <td>{{ $balance['quantity'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="sb-datatable table-responsive">
                            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                <caption style="caption-side: top">Stock Transactions</caption>
                                <thead>
                                    <tr>
                                        <th>Transaction Date</th>
                                        <th>Stock Type</th>
                                        <th>Batch No.</th>
                                        <th>Expiry Date</th>
                                        <th>Quantity</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Transaction Date</th>
                                        <th>Stock Type</th>
                                        <th>Batch No.</th>
                                        <th>Expiry Date</th>
                                        <th>Quantity</th>
                                        <th>Balance</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($stocks as $stock)
                                    <tr>
                                        <td>{{ $stock['transaction_date'] }}</td>
                                        <td>{{ $stock['stock_type']['name'] }}</td>
                                        <td>{{ $stock['batch_number'] }}</td>
                                        <td>{{ $stock['expiry_date'] }}</td>
                                        <td>{{ $stock['quantity'] }}</td>
                                        <td>{{ $stock['balance'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>