<?php

namespace App\Http\Controllers\Api;

use App\Faq;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Faq::all();
        return response()->json($faqs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Faq::$rules);
        $faq = Faq::firstOrCreate($request->all(), $request->all());
        return response()->json($faq);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $faq = Faq::find($id);
        if (is_null($faq)) {
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($faq);
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
        $this->validate($request, Faq::$rules);
        $faq  = Faq::find($id);
        if (is_null($faq)) {
            return response()->json(['error' => 'not_found']);
        }
        $faq->update($request->all());
        return response()->json($faq);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq = Faq::find($id);
        if (is_null($faq)) {
            return response()->json(['error' => 'not_found']);
        }
        $faq->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
