<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\View;

class LandingController extends Controller
{
  protected $client;

  public function __construct()
  {
    //Setup Curl client
    $this->client = new Client([
      'base_uri' => env('API_URL'),
      'defaults' => [
        'exceptions' => false
      ],
      'timeout'  => 10.0
    ]);
  }

  public function displayView(Request $request)
  {
    $page_name = (!$request->segment(1)) ? 'home' : $request->segment(1);

    $view_data = [
      'organizations' => $this->getOrganizations()
    ];

    $data = [
      'page_title' => $page_name,
      'content_view' => View::make('landing.pages.' . $page_name, $view_data)
    ];
    return view('landing.main', $data);
  }

  public function getOrganizations()
  {
    $request = $this->client->get('organizations');
    $response = $request->getBody();
    $organizations = json_decode($response, true);
    return $organizations;
  }
}
