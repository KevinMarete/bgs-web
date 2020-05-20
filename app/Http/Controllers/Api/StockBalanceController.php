<?php

namespace App\Http\Controllers\Api;

use App\StockBalance;
use App\StockType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stockbalances = StockBalance::with('product', 'organization')->get();
        return response()->json($stockbalances);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, StockBalance::$rules);
        $stockbalance = StockBalance::firstOrCreate($request->all(), $request->all());
        return response()->json($stockbalance);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stockbalance = StockBalance::with('product', 'organization')->find($id);
        if(is_null($stockbalance)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($stockbalance);
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
        $this->validate($request, StockBalance::$rules);
        $stockbalance  = StockBalance::find($id);
        if(is_null($stockbalance)){
            return response()->json(['error' => 'not_found']);
        }
        $stockbalance->update($request->all());
        return response()->json($stockbalance);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stockbalance = StockBalance::find($id);
        if(is_null($stockbalance)){
            return response()->json(['error' => 'not_found']);
        }
        $stockbalance->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }

    /**
     * Display the specified Organization and Product Batch Balances.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getStockBatchBalance(Request $request)
    {   
        $stockbalances = StockBalance::with('organization', 'product')
                            ->where('batch_number', $request->batch_number)
                            ->where('expiry_date', $request->expiry_date)
                            ->where('organization_id', $request->organization_id)
                            ->where('product_id', $request->product_id)
                            ->first();
        return response()->json($stockbalances);
    }

    /**
     * Calulate the specified Organization and Product Transaction Balance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function CalculateBalance(Request $request)
    {   
        $quantity = intval($request->quantity);
        $response_data = [
            'opening_balance' => 0,
            'quantity' => $quantity,
            'closing_balance' => 0,
            'effect' => null,
            'stock_type' => null
        ];

        //Get stock_type_id effect
        $stock_type = StockType::find($request->stock_type_id);
        if($stock_type){
            $effect = $stock_type['effect'];
            $response_data['effect'] = $effect;
            $response_data['stock_type'] = $stock_type['name'];

            //Get product balance
            $opening_balance = 0;
            $stockbalance = StockBalance::where('batch_number', $request->batch_number)
                            ->where('expiry_date', $request->expiry_date)
                            ->where('organization_id', $request->organization_id)
                            ->where('product_id', $request->product_id)
                            ->first();
            if($stockbalance){
                $opening_balance = $stockbalance['quantity'];
                $response_data['opening_balance'] = $opening_balance;
            }

            //When stock_type effect is '0', it does not affect the stock and hence is new balance
            if($effect == 0){
                $response_data['closing_balance'] = $quantity;
            }else{
                //When stock_type effect greater than '0', it adds to the stock hence balance = old_balance + quantity
                if($effect > 0){
                    $response_data['closing_balance'] = $opening_balance + $quantity;
                }else{
                    /*
                    When stock_type effect less than '0', it removes from the stock 
                    hence balance = old_balance - quantity
                    ensure balance does not go below '0'*/
                    $closing_balance = $opening_balance - $quantity;
                    if($closing_balance >= 0){
                        $response_data['closing_balance'] = $closing_balance;
                    }else{
                        $response_data['closing_balance'] = 0;
                        $response_data['quantity'] = $quantity + $closing_balance;
                    }
                }
            }
        }

        return response()->json($response_data);
    }

}
