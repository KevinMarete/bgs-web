<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class LandingController extends Controller
{
    protected $client;

    public function __construct()
    {
        //Setup Curl client
        $this->client = new Client([
            "base_uri" => env("API_URL"),
            "defaults" => [
                "exceptions" => false
            ],
            "timeout" => 10.0
        ]);
    }

    public function displayView(Request $request)
    {
        $page_name = (!$request->segment(1)) ? "home" : $request->segment(1);
        $organizations = $this->getOrganizations();
        $organization_type_totals = $this->getOrganizationTypeTotals($organizations);
        $view_data = [
            "organizations" => $organizations,
            "categories" => [
                [
                    "name" => "Pharmacies",
                    "icon" => "fa fa-pills",
                    "total" => ($organization_type_totals["pharmacy"] ?? 0) + ($organization_type_totals["chemist"] ?? 0)],
                [
                    "name" => "Hospitals",
                    "icon" => "fa fa-hospital",
                    "total" => ($organization_type_totals["hospital"] ?? 0) + ($organization_type_totals["clinic"] ?? 0)],
                [
                    "name" => "Suppliers",
                    "icon" => "fa fa-truck",
                    "total" => ($organization_type_totals["supplier"] ?? 0) + ($organization_type_totals["distributor"] ?? 0)
                ]
            ],
            "partner_geo_coordinates" => json_encode($this->getOrganizationGeoCoordinates($organizations))
        ];

        $data = [
            "page_title" => $page_name,
            "content_view" => View::make("landing.pages." . $page_name, $view_data)
        ];
        return view("landing.main", $data);
    }

    public function getOrganizations()
    {
        $request = $this->client->get("organizations");
        $response = $request->getBody();
        $organizations = json_decode($response, true);
        return $organizations;
    }

    public function getOrganizationTypeTotals($organizations)
    {
        return array_reduce($organizations, function ($carry, $organization) {
            $role_name = strtolower($organization["organization_type"]["name"]);
            if (!isset($carry[$role_name])) {
                $carry[$role_name] = 1;
            } else {
                $carry[$role_name]++;
            }
            return $carry;
        });
    }

    public function getOrganizationGeoCoordinates($organizations)
    {
        return array_map(function ($organization) {
            $address = $organization["building"] . "," . $organization["road"] . "," . $organization["town"];
            return $this->getGeocodesWithGoogleMaps($address);
        }, $organizations);
    }

    public function getGeocodesWithGoogleMaps($address)
    {
        $address = urlencode($address);
        $api_key = env("GOOGLE_MAPS_KEY");

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=$api_key" ;

        $resp_json = file_get_contents($url);
        $resp = json_decode($resp_json, true);

        if ($resp["status"] == "OK") {
            $latitude = isset($resp["results"][0]["geometry"]["location"]["lat"]) ? $resp["results"][0]["geometry"]["location"]["lat"] : "";
            $longitude = isset($resp["results"][0]["geometry"]["location"]["lng"]) ? $resp["results"][0]["geometry"]["location"]["lng"] : "";
            return [$latitude, $longitude];
        }
        return [null, null];
    }
}
