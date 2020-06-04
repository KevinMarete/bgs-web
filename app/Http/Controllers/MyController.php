<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class MyController extends Controller
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

  public function getRoleMenus($token = null, $role_id = null)
  {
    $menus = [];
    if ($token !== null) {
      $request = $this->client->get('role/' . $role_id . '/menus', [
        'headers' => [
          'Authorization' => 'Bearer ' . $token
        ]
      ]);
      $response = $request->getBody();
      $menus = json_decode($response, true);
    }
    return $menus;
  }

  public function manageResourceData($token = null, $rest_method = null, $resource = null, $request_data = null)
  {
    $response = $this->client->request($rest_method, $resource, [
      'headers' => [
        'Authorization' => 'Bearer ' . $token
      ],
      'json' => $request_data
    ]);

    $response = json_decode($response->getBody(), true);

    return $response;
  }

  public function process_payment($token = null, $organization_id, $user_id = null, $payment_data = [])
  {
    $response = [];
    if (!empty($payment_data) && $token != null && $organization_id != null && $user_id != null) {

      //ADD PAYMENT INTEGRATION HERE

      $response = $this->client->request('POST', 'payment', [
        'headers' => [
          'Authorization' => 'Bearer ' . $token
        ],
        'json' => [
          'amount' => $payment_data['amount'],
          'details' => json_encode([
            'transaction_code' => strtoupper(Str::random(8)),
            'transaction_time' => date('Y:m:d H:i:s'),
            'transaction_status' => 'successful'
          ]),
          'organization_id' => $organization_id,
          'user_id' => $user_id
        ]
      ]);
      $response = json_decode($response->getBody(), true);
    }
    return $response;
  }

  public function getAlertMessage($alert_type, $message)
  {
    return '<div class="alert alert-' . $alert_type . ' alert-dismissible fade show" role="alert">
              ' . $message . '
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>';
  }

  public function getFileDetails($file)
  {
    return [
      'name' => $file->getClientOriginalName(),
      'extension' => $file->getClientOriginalExtension(),
      'path' => $file->getRealPath(),
      'size' => $file->getSize(),
    ];
  }

  public function isValidExtension($extension, $valid_extension)
  {
    return in_array(strtolower($extension), $valid_extension);
  }

  public function isAllowedSize($fileSize, $maxFileSize)
  {
    return ($fileSize <= $maxFileSize);
  }

  public function getCsvData($filepath, $limit = 1000, $header = false)
  {
    $csv_data = [];
    $file = fopen($filepath, "r");
    $i = 0;

    while (($filedata = fgetcsv($file, $limit, ",")) !== FALSE) {
      $num = count($filedata);
      // Skip first row (header)
      if ($i == 0 && !$header) {
        $i++;
        continue;
      }
      for ($c = 0; $c < $num; $c++) {
        $csv_data[$i][] = $filedata[$c];
      }
      $i++;
    }

    fclose($file);

    return $csv_data;
  }
}
