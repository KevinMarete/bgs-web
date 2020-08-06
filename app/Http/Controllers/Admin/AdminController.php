<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\BusinessMetricsEmail;
use App\Mail\OffersEmail;

class AdminController extends MyController
{

	public function displayDashboardView()
	{
		$token = session()->get('token');
		$role_id = session()->get('organization.organization_type.role_id');

		$charts = [
			[
				'title' => 'Trend Distribution of Buyers',
				'class' => 'chart-area',
				'id' => 'buyerChart',
				'width' => '100%',
				'height' => '30',
				'data' => [
					'labels' => ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'],
					'datasets' => [30, 50, 40, 10, 70, 45, 34]
				]
			],
			[
				'title' => 'Trend Distribution of Sellers',
				'class' => 'chart-area',
				'id' => 'sellerChart',
				'width' => '100%',
				'height' => '30',
				'data' => [
					'labels' => ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'],
					'datasets' => [30, 50, 40, 10, 70, 45, 34]
				]
			],
			[
				'title' => 'Trend Distribution of Published Products',
				'class' => 'chart-bar',
				'id' => 'productChart',
				'width' => '100%',
				'height' => '30',
				'data' => [
					'labels' => ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'],
					'datasets' => [30, 50, 40, 10, 70, 45, 34]
				]
			],
			[
				'title' => 'Trend Distribution of RFQs',
				'class' => 'chart-bar',
				'id' => 'rfqChart',
				'width' => '100%',
				'height' => '30',
				'data' => [
					'labels' => ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'],
					'datasets' => [30, 50, 40, 10, 70, 45, 34]
				]
			],
			[
				'title' => 'Trend Distribution of Orders',
				'class' => 'chart-area',
				'id' => 'orderChart',
				'width' => '100%',
				'height' => '30',
				'data' => [
					'labels' => ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'],
					'datasets' => [30, 50, 40, 10, 70, 45, 34]
				]
			],
			[
				'title' => 'Distribution of Sales Revenue',
				'class' => 'chart-area',
				'id' => 'revenueChart',
				'width' => '100%',
				'height' => '30',
				'data' => [
					'labels' => ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'],
					'datasets' => [30, 50, 40, 10, 70, 45, 34]
				]
			],
		];

		$view_data = [
			'charts' => $charts
		];
		$data = [
			'page_title' => 'Dashboard',
			'menus' => $this->getRoleMenus($token, $role_id),
			'content_view' => View::make('admin.dashboard', $view_data)
		];

		return view('template.main', $data);
	}

	public function displayTableView(Request $request)
	{
		$resource = $request->path();
		$resource_name = ucwords(str_replace('-', ' ', $resource));
		$resource_url = $this->getResourceUrl(session(), $resource);
		$resource_view = $this->getResourceView(session(), $resource);
		$token = session()->get('token');
		$role_id = session()->get('organization.organization_type.role_id');

		$view_data = [
			'resource_name' => $resource_name,
			'table_headers' => $this->getResourceKeys($resource),
			'table_data' => $this->getResourceData($token, $resource_url)
		];
		$data = [
			'page_title' => $resource_name,
			'content_view' => View::make($resource_view, $view_data),
			'menus' => $this->getRoleMenus($token, $role_id),
		];

		return view('template.main', $data);
	}

	public function getResourceUrl($session_obj, $resource)
	{
		$resource_url = $resource;
		$organization_id = $session_obj->get('organization_id');
		$role_name = strtolower($session_obj->get('organization.organization_type.role.name'));

		if ($role_name == 'seller' && $resource == 'products') {
			//Get resource_url for seller products
			$resource_url = 'organization/' . $organization_id . '/products';
		} else if ($role_name == 'admin' && $resource == 'users') {
			//Get resource_url for admin users
			$resource_url = 'user-admins';
		}

		return $resource_url;
	}

	public function getResourceView($session_obj, $resource)
	{
		$resource_view = 'admin.table';
		$role_name = strtolower($session_obj->get('organization.organization_type.role.name'));

		//Get resource_view for admin users
		if ($role_name == 'admin' && $resource == 'users') {
			$resource_view = 'admin.user_table';
		}

		return $resource_view;
	}

	public function getResourceData($token = null, $resource = null)
	{
		$resource_data = [];
		if ($token !== null && $resource != null) {
			$request = $this->client->get($resource, [
				'headers' => [
					'Authorization' => 'Bearer ' . $token
				]
			]);
			$response = $request->getBody();
			$resource_data = json_decode($response, true);
		}

		return $resource_data;
	}

	public function getResourceKeys($resource = null)
	{
		$header_data = [];
		if ($resource != null) {
			$headers = [
				'organizationtypes' => ['id', 'name', 'role'],
				'packages' => ['id', 'name', 'price', 'details'],
				'roles' => ['id', 'name'],
				'product-categories' => ['id', 'name'],
				'stocktypes' => ['id', 'name', 'effect'],
				'payment-types' => ['id', 'name', 'details'],
				'products' => ['id', 'brand_name', 'molecular_name', 'pack_size', 'product_category'],
				'menus' => ['id', 'name'],
				'menu-roles' => ['id', 'menu', 'role'],
				'couriers' => ['id', 'name', 'phone', 'email', 'contact'],
				'users' => ['id', 'firstname', 'lastname', 'email', 'phone', 'organization'],
				'rejectreasons' => ['id', 'name'],
				'faqs' => ['id', 'question', 'answer'],
				'how-tos' => ['id', 'title', 'link'],
			];
			$header_data = $headers[$resource];
		}

		return $header_data;
	}

	public function displayManageView(Request $request)
	{
		$resource_name = $request->resource;
		$singular_resource_name = Str::singular($resource_name);
		$token = session()->get('token');
		$role_id = session()->get('organization.organization_type.role_id');
		$view_data = $this->getDropDownData($token, $resource_name);
		$view_data['manage_label'] = 'new';

		if ($request->action) {
			if ($request->action == 'edit') {
				$view_data['manage_label'] = 'update';
				$view_data['edit'] = $this->getResourceData($token, $singular_resource_name . '/' . $request->id);
			} else {
				if ($request->action == 'new') {
					$response = $this->manageResourceData($token, 'POST', $singular_resource_name, $request->except('_token'));
				} else if ($request->action == 'update') {
					$response = $this->manageResourceData($token, 'PUT', $singular_resource_name . '/' . $request->id, $request->except('_token'));
				} else if ($request->action == 'delete') {
					$response = $this->manageResourceData($token, 'DELETE', $singular_resource_name . '/' . $request->id, $request->except('_token'));
				}

				//Handle response
				if (isset($response['error'])) {
					$flash_msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> ' . $response["error"] . '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
				} else {
					$flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> ' . ucwords($singular_resource_name) . ' was managed successfully
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
				}
				$request->session()->flash('bgs_msg', $flash_msg);
				return redirect('/' . $resource_name);
			}
		}

		$data = [
			'page_title' => ucwords($resource_name),
			'menus' => $this->getRoleMenus($token, $role_id),
			'content_view' => View::make('admin.manage.' . $resource_name, $view_data)
		];

		return view('template.main', $data);
	}

	public function getDropDownData($token = null, $resource = null)
	{
		$dropdown_data = [];
		$data_sources = [
			'organizationtypes' => ['roles'],
			'packages' => [],
			'roles' => [],
			'product-categories' => [],
			'stocktypes' => [],
			'payment-types' => [],
			'products' => ['product-categories', 'sellers'],
			'menus' => [],
			'menu-roles' => ['menus', 'roles'],
			'couriers' => [],
			'users' => ['admins'],
			'rejectreasons' => [],
			'faqs' => [],
			'how-tos' => [],
		];

		if ($token !== null && $resource !== null) {
			foreach ($data_sources[$resource] as $data_source) {
				$dropdown_data[str_replace('-', '_', $data_source)] = $this->getResourceData($token, $data_source);
			}
		}

		return $dropdown_data;
	}

	public function sendBusinessMetrics(Request $request)
	{
		$period_date = ($request->period_date ? $request->period_date : date('Y-m-d'));

		if ($this->validateDate($period_date)) {
			$metric = $this->get_business_metrics($period_date);
			$metric->email = $this->get_admin_emails();
			$metric->date = $period_date;

			Mail::send(new BusinessMetricsEmail($metric));
			return response(['msg' => 'Mail sent'], 200);
		} else {
			return response(['msg' => 'Mail could not be sent'], 401);
		}
	}

	public function validateDate($date, $format = 'Y-m-d')
	{
		$d = \DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) === $date;
	}

	public function get_business_metrics($period_date)
	{
		$metric = new \stdClass();

		$buyer_request = $this->client->get('metric/buyer/' . $period_date);
		$metric->buyers = json_decode($buyer_request->getBody(), true)['total'];

		$seller_request = $this->client->get('metric/seller/' . $period_date);
		$metric->sellers = json_decode($seller_request->getBody(), true)['total'];

		$orders_request = $this->client->request('POST', 'metric/orders', [
			'json' => ['status' => 'delivered, order_closed', 'updated_at' => $period_date]
		]);
		$metric->orders = json_decode($orders_request->getBody(), true)['total'];

		$revenue_request = $this->client->get('metric/revenue/' . $period_date);
		$metric->revenue = json_decode($revenue_request->getBody(), true)['revenue'];

		return $metric;
	}

	public function sendOffers(Request $request)
	{
		$period_date = ($request->period_date ? $request->period_date : date('Y-m-d'));

		if ($this->validateDate($period_date)) {
			$mailing_list = $this->get_offers($period_date);
			$mailing_list->email = $this->get_mailing_list_emails();
			$mailing_list->date = $period_date;

			$offers_count = sizeof($mailing_list->offers);
			if ($offers_count > 0) {
				Mail::send(new OffersEmail($mailing_list));
				return response(['msg' => 'Mail sent'], 200);
			} else {
				return response(['msg' => 'No Promos or Deals be sent'], 401);
			}
		} else {
			return response(['msg' => 'Mail could not be sent'], 401);
		}
	}

	public function get_mailing_list_emails()
	{
		$emails = [];
		$request = $this->client->get('emails/mailing-list');
		$mailing_list = json_decode($request->getBody(), true);

		foreach ($mailing_list as $user) {
			array_push($emails, $user['email']);
		}

		return $emails;
	}

	public function get_offers($period_date)
	{
		$mailing_list = new \stdClass();

		$offers_request = $this->client->get('marketing/offers/' . $period_date);
		$mailing_list->offers = json_decode($offers_request->getBody(), true);

		return $mailing_list;
	}

	public function saveAdminAccount(Request $request)
	{
		//Check if passwords match 
		if ($request->password !== $request->cpassword) {
			$flash_msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Your passwords do not match, please confirm again
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
			$request->session()->flash('bgs_msg', $flash_msg);
			return redirect('/manage/users');
		}

		//Send request data to Api
		$response = $this->client->post("register", ['json' => $request->all()]);
		$response = json_decode($response->getBody(), true);

		//Send Account Email 
		$response = $this->client->post("activateaccountemail", ['json' => ['id' => $response['id']]]);
		$response = json_decode($response->getBody(), true);

		//Set flash message for View
		$flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Account was created successfully. Check the account email for the account activation code.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
		$request->session()->flash('bgs_msg', $flash_msg);

		return redirect('/users');
	}
}
