<?php

namespace App\Http\Controllers\Api;

use App\Organization;
use App\Offer;
use App\OrganizationPaymentType;
use App\Stock;
use App\StockBalance;
use App\ProductNow;
use App\Order;
use App\Product;
use App\Subscription;
use App\Promotion;
use App\Rfq;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $organizations = Organization::with('organization_type', 'organization_type.role')->get();
    return response()->json($organizations);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validate($request, Organization::$rules);
    $organization = Organization::firstOrCreate([
      'name' => $request->name,
      'organization_type_id' => $request->organization_type_id,
      'ppb_licence' => $request->ppb_licence
    ], $request->all());
    return response()->json($organization);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $organization = Organization::with('organization_type', 'organization_type.role')->find($id);
    if (is_null($organization)) {
      return response()->json(['error' => 'not_found']);
    }
    return response()->json($organization);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $this->validate($request, Organization::$rules);
    $organization  = Organization::find($id);
    if (is_null($organization)) {
      return response()->json(['error' => 'not_found']);
    }
    $organization->update($request->all());
    return response()->json($organization);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $organization = Organization::find($id);
    if (is_null($organization)) {
      return response()->json(['error' => 'not_found']);
    }
    $organization->delete();
    return response()->json(['msg' => 'Removed successfully']);
  }

  /**
   * Display the specified Organization's all offers.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationOffers($id)
  {
    $offers = Offer::with('product_now', 'product_now.product', 'organization')->where('organization_id', $id)->get();
    return response()->json($offers);
  }

  /**
   * Display the specified Organization's active offers.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationActiveOffers($id)
  {
    $offers = Offer::with('product_now', 'product_now.product', 'organization')->where('organization_id', $id)->whereDate('valid_until', '>=', date('Y-m-d'))->get();
    return response()->json($offers);
  }

  /**
   * Display the specified Organization's PaymentType.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationPaymentType($id)
  {
    $payment_types = OrganizationPaymentType::with('organization', 'payment_type')->where('organization_id', $id)->first();
    return response()->json($payment_types);
  }

  /**
   * Display the specified Organization's Stocks.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationStocks($id)
  {
    $stocks = Stock::with('organization', 'product', 'stock_type', 'user')->where('organization_id', $id)->get();
    return response()->json($stocks);
  }

  /**
   * Display the specified Organization's StockBalances.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationAllStockBalances($id)
  {
    $stockbalances = DB::table('tbl_stock_balance AS sb')
      ->select(DB::raw('SUM(sb.quantity) as balance, sb.product_id, sb.organization_id, p.molecular_name, p.brand_name, p.pack_size, p.strength'))
      ->join('tbl_product AS p', 'p.id', '=', 'sb.product_id')
      ->where('sb.organization_id', $id)
      ->where('p.organization_id', $id)
      ->whereNull('sb.deleted_at')
      ->whereNull('p.deleted_at')
      ->groupBy('sb.product_id', 'sb.organization_id', 'p.molecular_name', 'p.brand_name', 'p.pack_size', 'p.strength')
      ->orderBy('p.molecular_name', 'ASC')
      ->get();
    return response()->json($stockbalances);
  }

  /**
   * Display the specified Organization's StockBalances not in Pricelist.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationPricelistStockBalances($id)
  {
    $stockbalances = DB::table('tbl_stock_balance AS sb')
      ->select(DB::raw('SUM(sb.quantity) as balance, sb.product_id, sb.organization_id, p.molecular_name, p.brand_name, p.pack_size, p.strength'))
      ->join('tbl_product AS p', 'p.id', '=', 'sb.product_id')
      ->where('sb.organization_id', $id)
      ->where('p.organization_id', $id)
      ->whereRaw('sb.product_id NOT IN(SELECT product_id FROM tbl_product_now WHERE organization_id = ' . $id . ' AND deleted_at IS NULL)')
      ->whereNull('sb.deleted_at')
      ->whereNull('p.deleted_at')
      ->groupBy('sb.product_id', 'sb.organization_id', 'p.molecular_name', 'p.brand_name', 'p.pack_size', 'p.strength')
      ->orderBy('p.molecular_name', 'ASC')
      ->get();
    return response()->json($stockbalances);
  }

  /**
   * Display the specified Organization and Product Stocks.
   *
   * @param  int  $id, $product
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationProductStocks($id, $product)
  {
    $stocks = Stock::with('organization', 'product', 'stock_type', 'user')->where('organization_id', $id)->where('product_id', $product)->orderBy('id', 'DESC')->get();
    return response()->json($stocks);
  }

  /**
   * Display the specified Organization and Product StockBalances.
   *
   * @param  int  $id, $product
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationProductStockBalances($id, $product)
  {
    $stockbalances = StockBalance::with('organization', 'product')->where('organization_id', $id)->where('product_id', $product)->orderBy('id', 'DESC')->get();
    return response()->json($stockbalances);
  }

  /**
   * Display the specified Organization's productnows.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationProductNows($id)
  {
    $productnows = ProductNow::with('product', 'organization', 'user')->where('organization_id', $id)->get();
    return response()->json($productnows);
  }

  /**
   * Display the specified Organization's all promotions.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationPromotions($id)
  {
    $promotions = Promotion::with(['product_now', 'product_now.product'])->where('organization_id', $id)->get();
    return response()->json($promotions);
  }

  /**
   * Display the specified Organization's all slider promotions.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationSliderPromotions($id)
  {
    $promotions = Promotion::with(['product_now', 'product_now.product'])->where('type', 'slider')->where('organization_id', $id)->get();
    return response()->json($promotions);
  }

  /**
   * Display the specified Organization's all static promotions.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationStaticPromotions($id)
  {
    $promotions = Promotion::with(['product_now', 'product_now.product'])->where('type', 'static')->where('organization_id', $id)->get();
    return response()->json($promotions);
  }

  /**
   * Display the specified Organization's orders.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationOrders($id)
  {
    $orders = Order::with('organization')->where('organization_id', $id)->get();
    return response()->json($orders);
  }

  /**
   * Display the specified Organization's Seller Orders.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationSellerOrders($id)
  {
    $seller_orders = Order::with(['organization', 'order_items', 'order_logs'])->whereHas('order_items', function ($query) use ($id) {
      $query->where('organization_id', $id);
    })->get();
    return response()->json($seller_orders);
  }

  /**
   * Display the specified Organization's Products.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationProducts($id)
  {
    $organization_products = Product::with(['organization', 'product_category'])->where('organization_id', $id)->orderBy('molecular_name', 'ASC')->get();
    return response()->json($organization_products);
  }

  /**
   * Display the all seller organizations.
   *
   * @return \Illuminate\Http\Response
   */
  public function getSellerOrganizations()
  {
    $seller_orgs = Organization::with(['organization_type', 'organization_type.role', 'users'])->whereHas('organization_type.role', function ($query) {
      $query->where('name', 'seller');
    })->get();
    return response()->json($seller_orgs);
  }

  /**
   * Display the all admin organizations.
   *
   * @return \Illuminate\Http\Response
   */
  public function getAdminOrganizations()
  {
    $admin_orgs = Organization::with(['organization_type', 'organization_type.role'])->whereHas('organization_type.role', function ($query) {
      $query->where('name', 'admin');
    })->get();
    return response()->json($admin_orgs);
  }

  /**
   * Display the specified Organization's Unpublished productnows.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getUnpublishedProductNows($id)
  {
    $productnows = ProductNow::with('product', 'product.product_category', 'organization', 'user')->where('organization_id', $id)->where('is_published', false)->get();
    return response()->json($productnows);
  }

  /**
   * Display the specified Organization's productnows.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getPublishedProductNows($id)
  {
    $productnows = ProductNow::with('product', 'product.product_category', 'organization', 'user')->where('organization_id', $id)->where('is_published', true)->get();
    return response()->json($productnows);
  }

  /**
   * Display the specified Organization's subscription.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationSubscription($id)
  {
    $subscription = Subscription::with('organization', 'package')->where('organization_id', $id)->first();
    return response()->json($subscription);
  }

  /**
   * Display the specified Organization's rfqs.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationRfqs($id)
  {
    $rfqs = Rfq::with('organization', 'rfq_items', 'rfq_items.organization', 'rfq_logs')->where('organization_id', $id)->get();
    return response()->json($rfqs);
  }

  /**
   * Display the specified Organization's Seller Rfqs.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getOrganizationSellerRfqs($id)
  {
    $seller_rfqs = Rfq::with(['organization', 'rfq_items', 'rfq_logs'])->whereHas('rfq_items', function ($query) use ($id) {
      $query->where('organization_id', $id);
    })->get();
    return response()->json($seller_rfqs);
  }
}
