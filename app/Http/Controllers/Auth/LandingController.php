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
            'timeout' => 10.0
        ]);
    }

    public function displayView(Request $request)
    {
        $page_name = (!$request->segment(1)) ? 'home' : $request->segment(1);
        $organizations = $this->getOrganizations();
        $organization_type_totals = $this->getOrganizationTypeTotals($organizations);
        $view_data = [
            'organizations' => $organizations,
            'categories' => [
                [
                    "name" => "Pharmacies",
                    "icon" => "fa fa-pills",
                    "total" => ($organization_type_totals['pharmacy'] ?? 0) + ($organization_type_totals['chemist'] ?? 0)],
                [
                    "name" => "Hospitals",
                    "icon" => "fa fa-hospital",
                    "total" => ($organization_type_totals['hospital'] ?? 0) + ($organization_type_totals['clinic'] ?? 0)],
                [
                    "name" => "Suppliers",
                    "icon" => "fa fa-truck",
                    "total" => ($organization_type_totals['supplier'] ?? 0) + ($organization_type_totals['distributor'] ?? 0)
                ]
            ]
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

    public function getOrganizationTypeTotals($organizations)
    {
        return array_reduce($organizations, function ($carry, $organization) {
            $role_name = strtolower($organization['organization_type']['name']);
            if (!isset($carry[$role_name])) {
                $carry[$role_name] = 1;
            } else {
                $carry[$role_name]++;
            }
            return $carry;
        });
    }
}
