<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>Action Order#{{ $order['id'] }}</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    <div class="card mb-4">
        <div class="card-header"></div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
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
                                    <td>Total</td>
                                    <td><strong>KES {{ number_format($order['product_total'] + $order['shipping_total']) }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Action</td>
                                    <td>
                                        @if(!empty($actions))
                                            <form role="form" action="/action-order/{{ $order['id'] }}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="hidden" name="id" value="{{ $order['id'] }}"/>
                                                        <input type="hidden" name="organization_id" value="{{ $order['organization_id'] }}"/>
                                                        <input type="hidden" name="product_total" value="{{ $order['product_total'] }}"/>
                                                        <input type="hidden" name="shipping_total" value="{{ $order['shipping_total'] }}"/>
                                                        <select class="form-control" name="status" required>
                                                            <option value="">Select Action</option>
                                                            @foreach($actions as $label => $action_status)
                                                                <option value="{{ $action_status }}"> {{ ucwords($label) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @if($order['status'] == 'confirmed, awaiting_dispatch')
                                                        <div class="col">
                                                            <select class="form-control" name="courier_id" required>
                                                                <option value="">Select Courier</option>
                                                                @foreach($couriers as $courier)
                                                                    <option value="{{ $courier['id'] }}"> {{ $courier['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif
                                                    <div class="col">
                                                        <button type="submit" class="form-control btn btn-primary">
                                                            <i class="fa fa-save"></i> &nbsp; Save Action
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @else
                                            <span class="badge badge-success">No Action Required</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="sb-datatable table-responsive">
                            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                <caption style="caption-side: top">OrderItems</caption>
                                <thead>
                                    <tr>
                                        <th>Supplier</th>
                                        <th>ProductName</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Supplier</th>
                                        <th>ProductName</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($order['order_items'] as $order_item)
                                        <tr>
                                            <td>{{ $order_item['organization']['name'] }}</td>
                                            <td>{{ $order_item['product_now']['product']['molecular_name'] }}</td>
                                            <td>{{ number_format($order_item['quantity']) }}</td>
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