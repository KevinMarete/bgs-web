<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>Catalogue</span>
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
            <div class="col-lg-12">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="" data-target="#order-now" data-toggle="tab" class="nav-link active">OrderNow</a>
                    </li>
                    <li class="nav-item">
                        <a href="" data-target="#productpromos" data-toggle="tab" class="nav-link">Promos</a>
                    </li>
                    <li class="nav-item">
                        <a href="" data-target="#productdeals" data-toggle="tab" class="nav-link">Deals of the Day</a>
                    </li>
                </ul>
                <div class="tab-content py-4">
                    <div class="tab-pane active" id="order-now">
                        <div class="card mb-4">
                            <div class="card-header">
                                OrderNow Listing
                                <a href="/manage-ordernows" class="btn btn-primary ml-auto">
                                    <i data-feather="plus"></i> 
                                    Add OrderNow
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="sb-datatable table-responsive">
                                    <table class="table table-bordered table-hover dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                @foreach ($productnows['table_headers'] as $header)
                                                    <th>{{ ucwords($header) }}</th>  
                                                @endforeach
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                @foreach ($productnows['table_headers'] as $header)
                                                    <th>{{ ucwords($header) }}</th>  
                                                @endforeach
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($productnows['table_data'] as $row)
                                                <tr>
                                                    <td>{{ $row['id'] }}</td>
                                                    <td>{{ $row['product']['molecular_name'] }}</td> 
                                                    <td>{{ $row['product']['brand_name'] }}</td> 
                                                    <td>{{ $row['product']['pack_size'] }}</td> 
                                                    <td>{{ ($row['is_published'] ? 'Yes' : 'No') }}</td> 
                                                    <td>
                                                        <a href="/manage/productnows/edit/{{ $row['id'] }}" class="btn sb-btn-datatable sb-btn-icon sb-btn-transparent-dark mr-2">
                                                            <i data-feather="more-vertical"></i>
                                                        </a>
                                                        <a href="/manage/productnows/delete/{{ $row['id'] }}" class="delete btn sb-btn-datatable sb-btn-icon sb-btn-transparent-dark">
                                                            <i data-feather="trash-2"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="productpromos">
                        <div class="card mb-4">
                            <div class="card-header">
                                Promos Listing
                                <a href="/manage-promos" class="btn btn-primary ml-auto">
                                    <i data-feather="plus"></i> 
                                    Add Promos
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="sb-datatable table-responsive">
                                    <table class="table table-bordered table-hover dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                @foreach ($productpromos['table_headers'] as $key => $header)
                                                    <th>{{ ucwords($header) }}</th>  
                                                @endforeach
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                @foreach ($productpromos['table_headers'] as $header)
                                                    <th>{{ ucwords($header) }}</th>  
                                                @endforeach
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($productpromos['table_data'] as $row)
                                                <tr>
                                                    <td>{{ $row['id'] }}</td> 
                                                    <td>{{ $row['product_now']['product']['molecular_name'] }}</td> 
                                                    <td>{{ $row['product_now']['product']['brand_name'] }}</td> 
                                                    <td>{{ $row['coupon_code'] }}</td> 
                                                    <td>{{ $row['product_now']['unit_price'] }}</td> 
                                                    <td>{{ $row['offer']['discount'] }}</td>
                                                    <td>{{ $row['offer']['max_discount_amount'] }}</td>  
                                                    <td>
                                                        <a href="/manage/productpromos/edit/{{ $row['id'] }}" class="btn sb-btn-datatable sb-btn-icon sb-btn-transparent-dark mr-2">
                                                            <i data-feather="more-vertical"></i>
                                                        </a>
                                                        <a href="/manage/productpromos/delete/{{ $row['id'] }}" class="delete btn sb-btn-datatable sb-btn-icon sb-btn-transparent-dark">
                                                            <i data-feather="trash-2"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="productdeals">
                        <div class="card mb-4">
                            <div class="card-header">
                                Deals Listing
                                <a href="/manage-deals" class="btn btn-primary ml-auto">
                                    <i data-feather="plus"></i> 
                                    Add Deals
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="sb-datatable table-responsive">
                                    <table class="table table-bordered table-hover dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                @foreach ($productdeals['table_headers'] as $key => $header)
                                                    <th>{{ ucwords($header) }}</th>  
                                                @endforeach
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                @foreach ($productdeals['table_headers'] as $header)
                                                    <th>{{ ucwords($header) }}</th>  
                                                @endforeach
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($productdeals['table_data'] as $row)
                                                <tr>
                                                    <td>{{ $row['id'] }}</td> 
                                                    <td>{{ $row['product_now']['product']['molecular_name'] }}</td> 
                                                    <td>{{ $row['product_now']['product']['brand_name'] }}</td> 
                                                    <td>{{ $row['minimum_order_quantity'] }}</td> 
                                                    <td>{{ $row['product_now']['unit_price'] }}</td> 
                                                    <td>{{ $row['offer']['discount'] }}</td>
                                                    <td>{{ $row['offer']['max_discount_amount'] }}</td>
                                                    <td>
                                                        <a href="/manage/productdeals/edit/{{ $row['id'] }}" class="btn sb-btn-datatable sb-btn-icon sb-btn-transparent-dark mr-2">
                                                            <i data-feather="more-vertical"></i>
                                                        </a>
                                                        <a href="/manage/productdeals/delete/{{ $row['id'] }}" class="delete btn sb-btn-datatable sb-btn-icon sb-btn-transparent-dark">
                                                            <i data-feather="trash-2"></i>
                                                        </a>
                                                    </td>
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
    </div>
</div>