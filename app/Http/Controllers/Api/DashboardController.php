<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Rfq;
use App\ProductNow;
use App\Order;
use App\OrderItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

  /**
   * Display the buyers created in period.
   *
   * @param  date  $start
   * @param  date  $end
   * @return \Illuminate\Http\Response
   */
  public function getBuyers($start, $end)
  {

    /*
    SELECT u.created_at::DATE as label, ot.name stack, count(*) as value
    FROM tbl_user u
    INNER JOIN tbl_organization o ON u.organization_id = o.id
    INNER JOIN tbl_organization_type ot ON o.organization_type_id = ot.id
    INNER JOIN tbl_role r ON ot.role_id = r.id
    WHERE r.name = 'buyer'
    GROUP BY u.created_at::DATE, ot.name
    */

    $buyers = User::whereHas('organization.organization_type.role', function ($query) {
      $query->where('name', 'buyer');
    })
      ->whereDate('created_at', '>=', $start)
      ->whereDate('created_at', '<=', $end)
      ->groupBy(DB::raw('created_at::DATE'))
      ->select(DB::raw('created_at::DATE as label'), DB::raw('count(*) as value'))
      ->get();
    return response()->json($buyers);
  }

  /**
   * Display the sellers created in period.
   *
   * @param  date  $start
   * @param  date  $end
   * @return \Illuminate\Http\Response
   */
  public function getSellers($start, $end)
  {
    $sellers = User::whereHas('organization.organization_type.role', function ($query) {
      $query->where('name', 'seller');
    })
      ->whereDate('created_at', '>=', $start)
      ->whereDate('created_at', '<=', $end)
      ->groupBy(DB::raw('created_at::DATE'))
      ->select(DB::raw('created_at::DATE as label'), DB::raw('count(*) as value'))
      ->get();
    return response()->json($sellers);
  }

  /**
   * Display the published products created in period.
   *
   * @param  date  $start
   * @param  date  $end
   * @return \Illuminate\Http\Response
   */
  public function getPublishedProducts($start, $end)
  {
    $productnows = ProductNow::where('is_published', true)
      ->whereDate('created_at', '>=', $start)
      ->whereDate('created_at', '<=', $end)
      ->groupBy(DB::raw('created_at::DATE'))
      ->select(DB::raw('created_at::DATE as label'), DB::raw('count(*) as value'))
      ->get();
    return response()->json($productnows);
  }

  /**
   * Display the rfqs created in period.
   *
   * @param  date  $start
   * @param  date  $end
   * @return \Illuminate\Http\Response
   */
  public function getRFQs($start, $end)
  {
    $rfqs = Rfq::where('status', 'proforma_invoice_sent, awaiting_delivery')
      ->whereDate('created_at', '>=', $start)
      ->whereDate('created_at', '<=', $end)
      ->groupBy(DB::raw('created_at::DATE'))
      ->select(DB::raw('created_at::DATE as label'), DB::raw('count(*) as value'))
      ->get();
    return response()->json($rfqs);
  }

  /**
   * Display the orders created in period.
   *
   * @param  date  $start
   * @param  date  $end
   * @return \Illuminate\Http\Response
   */
  public function getOrders($start, $end)
  {
    $orders = Order::where('status', 'delivered, order_closed')
      ->whereDate('created_at', '>=', $start)
      ->whereDate('created_at', '<=', $end)
      ->groupBy(DB::raw('created_at::DATE'))
      ->select(DB::raw('created_at::DATE as label'), DB::raw('count(*) as value'))
      ->get();
    return response()->json($orders);
  }

  /**
   * Display the revenue created in period.
   *
   * @param  date  $start
   * @param  date  $end
   * @return \Illuminate\Http\Response
   */
  public function getRevenue($start, $end)
  {
    $revenue = OrderItem::whereHas('order', function ($query) {
      $query->where('status', 'delivered, order_closed');
    })
      ->whereDate('created_at', '>=', $start)
      ->whereDate('created_at', '<=', $end)
      ->groupBy(DB::raw('created_at::DATE'))
      ->select(DB::raw('created_at::DATE as label'), DB::raw('sum(total_cost) as value'))
      ->get();
    return response()->json($revenue);
  }
}
