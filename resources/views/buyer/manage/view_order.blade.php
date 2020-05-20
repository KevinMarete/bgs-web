<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>View Order#{{ $order['id'] }}</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    @if (Session::has('bgs_msg'))
        {!! session('bgs_msg') !!}
    @endif
    <div class="card mb-4">
        <div class="card-header"> 
            @if($role_name !== 'buyer')
                <a href="/action-order/{{ $order['id'] }}" class="btn btn-primary ml-auto">
                    <i data-feather="plus"></i> 
                    Manage Order
                </a>
            @endif
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <caption style="caption-side: top">OrderSummary</caption>
                            <tbody>
                                <tr>
                                    <td>Status</td>
                                    <td><strong>{{ $order['status'] }}</strong></td>
                                </tr>
                                <tr>
                                    <td>OrderDate</td>
                                    <td>{{ $order['created_at'] }}</td>
                                </tr>
                                <tr>
                                    <td>ProductTotal</td>
                                    <td>KES {{ number_format($order['product_total']) }}</td>
                                </tr>
                                <tr>
                                    <td>ShippingTotal</td>
                                    <td>KES {{ number_format($order['shipping_total']) }}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><strong>KES {{ number_format($order['product_total'] + $order['shipping_total']) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-7">
                        <div class="sb-datatable table-responsive">
                            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                <caption style="caption-side: top">OrderLogs</caption>
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>User</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>User</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($order['order_logs'] as $order_log)
                                        <tr>
                                            <td>{{ $order_log['status'] }}</td>
                                            <td>{{ $order_log['created_at'] }}</td>
                                            <td>{{ $order_log['user']['firstname'].' '.$order_log['user']['lastname'] }}</td>
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
                                <caption style="caption-side: top">OrderItems</caption>
                                <thead>
                                    <tr>
                                        <th>Organization</th>
                                        <th>ProductName</th>
                                        <th>Quantity</th>
                                        <th>UnitPrice</th>
                                        <th>SubTotal</th>
                                        <th>Shipping</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Supplier</th>
                                        <th>ProductName</th>
                                        <th>Quantity</th>
                                        <th>UnitPrice</th>
                                        <th>SubTotal</th>
                                        <th>Shipping</th>
                                        <th>Total</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($order['order_items'] as $order_item)
                                        <tr>
                                            <td>{{ $order_item['organization']['name'] }}</td>
                                            <td>{{ $order_item['product_now']['product']['molecular_name'] }}</td>
                                            <td>{{ number_format($order_item['quantity']) }}</td>
                                            <td>KES {{ number_format($order_item['unit_price']) }}</td>
                                            <td>KES {{ number_format($order_item['sub_total']) }}</td>
                                            <td>KES {{ number_format($order_item['shipping_total']) }}</td>
                                            <td>KES {{ number_format($order_item['total_cost']) }}</td>
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