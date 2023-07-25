<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\DeliveryDay;
use App\Models\User;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Libraries\Helpers;
use PDF;

class DeliveryDayController extends Controller
{

    public function index(Request $request)
    {
        $today = Carbon::now();
        $devliverydays = DeliveryDay::with('deliveries')->orderBy('delivery_date', 'desc')->get();
        $upcoming_devliverydays = DeliveryDay::with('deliveries')->where('delivery_date', '>=', $today)->orderBy('delivery_date', 'asc')->get();
        $pending_devliverydays = DeliveryDay::with('deliveries')->where('delivery_date', '<', $today)->orderBy('delivery_date', 'desc')->get();
        return view('backend.delivery_days.index', compact('devliverydays','upcoming_devliverydays','pending_devliverydays'));
    }
    public function create()
    {
        return view('backend.delivery_days.create');
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'delivery_date' => 'required',
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return redirect()->back()->with('error', $error);
            } else {
                $data = $request->except(['_method', '_token']);
                if (isset($data['thursday']) && isset($data['friday'])) {
                    $data['deliver_to'] = 'both';
                } elseif (isset($data['thursday'])) {
                    $data['deliver_to'] = 'thursday';
                } elseif (isset($data['friday'])) {
                    $data['deliver_to'] = 'friday';
                }
                $delivey_day = new DeliveryDay();
                if (isset($data['deliver_to']) && $data['deliver_to']) {
                    $delivey_day['deliver_to'] = $data['deliver_to'];
                }

                if (isset($data['delivery_date']) && $data['delivery_date']) {
                    $delivey_day['delivery_date'] = Carbon::createFromFormat('m/d/Y', $data['delivery_date'])->format('Y-m-d');
                }
                $delivey_day->save();
                return redirect()->route('admin.delivery_days.index')->with('success', 'Delivery Create Successfully.');
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return redirect()->back()->with('error', $error);
        }
    }
    public function cron_test()
    {
        try {
            $today = Carbon::now();
            $delivey_days_count = DeliveryDay::where('delivery_date', '>', $today)->count();

            if ($delivey_days_count < 20) {
                $additional_del = 20 - $delivey_days_count;
                $count = 1;
                $c = $delivey_days_count . '_' . $count;

                while ($count <= $additional_del) {
                    $lastDeliveryDay = DeliveryDay::orderBy('delivery_date', 'desc')->first();
                    if ($lastDeliveryDay) {
                        $lastDeliveryDate = $lastDeliveryDay->delivery_date;
                        $date = Carbon::parse($lastDeliveryDate);
                    } else {
                        $date = Carbon::now();
                    }
                    $day = Carbon::parse($date)->format('l');

                    if ($day == 'Thursday') {
                        $nextDeliveryDate = $date->is('Friday') ? $date : $date->next('Friday');
                        $nextDeliverTo = 'friday';
                    } else {
                        $nextDeliveryDate = $date->is('Thursday') ? $date : $date->next('Thursday');
                        $nextDeliverTo = 'thursday';
                    }

                    $delivey_day = new DeliveryDay();
                    $delivey_day['deliver_to'] = $nextDeliverTo;
                    $delivey_day['delivery_date'] = $nextDeliveryDate;
                    // $delivey_day->save();
                    if ($delivey_day->save()) {
                        $lastDeliveryDay = $delivey_day;
                    }
                    $count++;
                    $c = $c . '_' . $count;
                }
                dd($c);
            }
            // dd($c);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            dd($error);
        }
    }
    public function show($id = 0)
    {
        if ($id == 0) {
            $yesterday = Carbon::yesterday();
            $delivey_days = DeliveryDay::where('delivery_date', '>=', $yesterday)->where('status','Pending')->with('deliveries.user_package.user', 'deliveries.user_package.package')->orderBy('delivery_date', 'asc')->first();
        } else {
            $delivey_days = DeliveryDay::whereId($id)->with('deliveries.user_package.user', 'deliveries.user_package.package')->first();
        }
        $current_date = $delivey_days->delivery_date;
        $previousDay = DeliveryDay::where('delivery_date', '<', $current_date)->orderBy('delivery_date', 'desc')->first(); // orderby(delivery_date,'dsesc')
        $nextDay = DeliveryDay::where('delivery_date', '>', $current_date)->orderBy('delivery_date', 'asc')->first(); // orderby(delivery_date,'asc')
        $error_logs = json_decode($delivey_days->error_logs, true);
        return view('backend.delivery_days.show', compact('delivey_days', 'error_logs', 'previousDay', 'nextDay'));
    }
    public function designer_report($id)
    {
        $selected_delivery_day = DeliveryDay::whereId($id)->with('deliveries')->first();
        $package_types = Package::distinct()->get(['type'])->pluck('type');
        foreach ($package_types as $type) {
            $result = Delivery::where('delivery_day_id', $id)->where('status', '!=', 'Canceled')->with('delivery_day', 'user_package.package', 'user_package.user')->get()
                ->filter(function ($item) use ($type) {
                    return $item->delivery_type == $type;
                });
            $deliveries[$type]['deliveries'] = $result->all();
            $deliveries[$type]['count'] = $result->count();
        }
        $all_deliveries = Delivery::where('delivery_day_id', $id)->where('status', '!=', 'Canceled')->with('delivery_day', 'user_package.package', 'user_package.user')->get();
        return view('backend.delivery_days.designer_report', compact('deliveries', 'package_types', 'all_deliveries', 'selected_delivery_day'));
    }
    public function routes_labels($id)
    {
        $selected_delivery_day = DeliveryDay::whereId($id)->where('status', '!=', 'Canceled')->with('deliveries')->first();
        $delivery_days = DeliveryDay::where('status', '!=', 'Canceled')->where('status', '!=', 'Pending')->get();
        return view('backend.delivery_days.creat_routes', compact('delivery_days', 'selected_delivery_day'));
    }
    public function get_routes_labels_files(Request $request)
    {
        $delivery_day_id = $request->deliverydayId;
        $no_routes = $request->no_of_routes;
        $data['route_files'] = $this->create_routes_files($delivery_day_id, $no_routes);
        $data['label_files'] = route('admin.delivery_days.create_label_files', $delivery_day_id);
        return response()->json(['success' => true, 'routes_labels' => $data]);
    }


    public function TestDeliveryRoutes()
    {

        $this->create_routes_files(6, 2);
    }

    public function getClosetDeliveries($geoData, $lat, $long, $returnNearestOnly = true)
    {

        $arrCloseMatchLat   = array();
        $arrCloseMatchLong  = array();
        $matchedGeoSet      = array();
        foreach ($geoData as $iKey => $arrGeoStrip) {
            $arrCloseMatchLat[$iKey]    =  abs(floatval(($arrGeoStrip['latitude'])  - $lat));
            $arrCloseMatchLong[$iKey]   =  abs(floatval(($arrGeoStrip['longitude']) - $long));
        }
        asort($arrCloseMatchLat, SORT_NUMERIC);
        asort($arrCloseMatchLong, SORT_NUMERIC);
        if ($returnNearestOnly) {
            foreach ($arrCloseMatchLat as $index => $difference) {
                $matchedGeoSet['matches'][]  = $geoData[$index];
                break;
            }
        } else {
            foreach ($arrCloseMatchLat as $index => $difference) {
                $matchedGeoSet['matches'][]  = $geoData[$index];
            }
        }
        return $matchedGeoSet;
    }
    public function create_routes_files($delivery_day_id, $no_routes = 1)
    {
        // 24.91085391641344,67.07264835781206
        $address_cordinate = explode(',', (new Helpers())->getServiceValue('address_cordinate'));
        $lat = floatval($address_cordinate[0]);
        $lng = floatval($address_cordinate[1]);
        $deliveries = Delivery::with(['user_package.package', 'user_package.user' => function ($query) use ($lat, $lng) {
            $distance = DB::raw("*, ( 6371 * acos( cos( radians($lat) ) * cos( radians( delivery_lat ) ) * cos( radians( delivery_long ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( delivery_lat ) ) ) ) AS distance");
            $query->select($distance)->orderBy('distance', 'ASC');
        }])
            ->where('status', '!=', 'Canceled')
            ->where('delivery_day_id', $delivery_day_id)
            ->get()->sortBy('user_package.user.distance');

        if (!empty($deliveries)) {
            $sortedArray = array();
            $deliveriesArray = $deliveries->toArray();
            $packge_count = 0;
            foreach ($deliveriesArray as $key => $dd) {
                $key = array_search($dd['user_package']['user']['id'], array_column($sortedArray, 'user_id'));
                if ($key !== false && !empty($sortedArray[$key])) {
                    $sortedArray[$key]['packge_count'] += 1;
                    $sortedArray[$key]['delivery_type'] = $sortedArray[$key]['delivery_type'] . ',' . $dd['delivery_type'];
                    $sortedArray[$key]['idx_all'] = $sortedArray[$key]['idx_all'] . ',' . $dd['id'];
                } else {
                    $push = array();
                    $push['idx_all'] = $dd['id'];
                    $push['id'] = $dd['id'];
                    $push['arr_uniq_id'] = rand(10000, 5000000);
                    $push['user_id'] = $dd['user_package']['user']['id'];
                    $push['recipient_name'] = $dd['user_package']['user']['recipient_name'];
                    $push['recipient_phone'] = $dd['user_package']['user']['recipient_phone'];
                    $push['email'] = $dd['user_package']['user']['email'];
                    $push['phone'] = $dd['user_package']['user']['phone'];
                    $push['address_line_1'] = $dd['user_package']['user']['billing_address1'];
                    $push['address_line_2'] = $dd['user_package']['user']['billing_address2'];
                    $push['city'] = $dd['user_package']['user']['billing_city'];
                    $push['state'] = $dd['user_package']['user']['billing_state'];
                    $push['zipcode'] = $dd['user_package']['user']['billing_zip'];
                    $push['latitude'] = $dd['user_package']['user']['delivery_lat'];
                    $push['longitude'] = $dd['user_package']['user']['delivery_long'];
                    $push['notes'] = $dd['user_package']['description'];
                    $push['packge_count'] = 1;
                    $push['delivery_type'] = $dd['delivery_type'];
                    array_push($sortedArray, $push);
                }
            }
            if ($sortedArray) {
                $NearbyDeliveries = array();
                foreach ($sortedArray as $ddF) {
                    $getNearestFirst = $this->getClosetDeliveries($sortedArray, '41.091587', '-74.073768', true);
                    if (!empty($sortedArray)) {
                        if (isset($getNearestFirst['matches'][0]['arr_uniq_id'])) {
                            $key = array_search($getNearestFirst['matches'][0]['user_id'], array_column($sortedArray, 'user_id'));
                            if ($key !== false && !empty($sortedArray[$key])) {
                                array_push($NearbyDeliveries, $sortedArray[$key]);
                                unset($sortedArray[$key]);
                                $sortedArray = array_values($sortedArray);
                            }
                        }
                    }
                }
            }
            $sortedArray = array_reverse($NearbyDeliveries);
        }
        $half = ceil(count($sortedArray) / $no_routes);
        $devided = array_chunk($sortedArray, $half);
        $cntr = 1;
        $route_files = [];


        //dd($devided);

        foreach ($devided as $key => $dil) {

            $path = public_path('storage/csv');
            //check if the directory exists

            if (!File::isDirectory($path)) {
                File::makeDirectory($path);
            } else {
            }
            $filename =  public_path("storage/csv/routes_" . $delivery_day_id . "_" . $cntr . ".csv");
            $handle = fopen($filename, 'w');
            fputcsv($handle, [
                "Address Line 1",
                "Address Line 2",
                "City",
                "State",
                "Zip",
                "Country",
                "Notes",
                "Recipient Name",
                "Type of stop",
                "Recipient Email Address",
                "Recipient Phone Number",
                "Id",
                "Package Count",
                "Products"
            ]);

            foreach ($dil as $dilevery) {
                Delivery::whereIn('id', explode(',', $dilevery['idx_all']))->update(['route' => 'Route ' . ($key + 1)]);
                fputcsv($handle, [
                    $dilevery['address_line_1'],
                    $dilevery['address_line_2'],
                    $dilevery['city'],
                    $dilevery['state'],
                    $dilevery['zipcode'],
                    $dilevery['state'],
                    $dilevery['notes'],
                    $dilevery['recipient_name'],
                    'Delivery',
                    $dilevery['email'],
                    $dilevery['recipient_phone'],
                    $dilevery['user_id'],
                    $dilevery['packge_count'],
                    $dilevery['delivery_type'],
                ]);

                $cntr++;
            }
            fclose($handle);
            $route_files[$cntr - 1] = $filename;
            $cntr++;
        }
        return $route_files;
    }

    static function create_label_files($delivery_day_id)
    {
        $deliveries = Delivery::with('user_package.package', 'user_package.user')
            ->where('status', '!=', 'Canceled')
            ->where('delivery_day_id', $delivery_day_id)
            ->get();
        $html = '<style> @page { margin-top:0cm;margin-bottom:0;margin-right:0cm;margin-left:0;}.overlay-pdf{position: absolute;top: 0;left: 0;height: 100%;width: 100%;z-index: -1;background-color: #fff;} body{position: relative; font-family: Arial, Helvetica, sans-serif;margin: 0px;background: #fff;border-radius: 8px; padding: 0px;width:100%;height:100%;}.page-break {page-break-after: always;} p{margin:12px 5px 0 0; padding:0;font-size: 14px;color: #000000;line-height: 1.2;margin-left: 10px;} .pdf-logo{padding: 5px; border: solid thin #000; max-width:80px;position:absolute;top:10px;right: 15px; z-index: 9999;}</style>';
        foreach ($deliveries as $dilevery) {
            $html .= '<div id="overlay-pdf"></div>';
            $html .= '<img class="pdf-logo" src="' . url("https://budsmonsey.com/public/assets/backend/img/buds_logo.png") . '" >';
            $html .= '<p style="word-break: break-all">' . $dilevery->user_package->user->recipient_name . '</p>';
            $html .= '<p style="word-break: break-all;margin-top:5px;">' . $dilevery->user_package->user->phone . '</p>';
            $html .= '<p style="word-break: break-all;">' . $dilevery->user_package->package->type . ' <span style="margin-left: 60px">' . $dilevery->route . '</span></p>' ;
            $html .= '<p style="word-break: break-all;">' . $dilevery->user_package->user->delivery_zip . \Illuminate\Support\Str::limit($dilevery->user_package->user->delivery_address1, 81) . '</p>';
            $html .= '<p style="word-break: break-all;margin-top:5px;">' . \Illuminate\Support\Str::limit($dilevery->user_package->user->delivery_address2, 40) . '</p>';
            $html .= '<div class="page-break"></div>';
        }

        $selected_delivery_day = DeliveryDay::whereId($delivery_day_id)->first();
        $customPaper = array(0, 0, 225.00, 125.80);
        $pdf = PDF::loadHTML($html)->setPaper($customPaper, 'portrait');
        return $pdf->download('label-' . $selected_delivery_day->delivery_date . '.pdf');
    }
    public function canceled(Request $request)
    {
        $delivey = Delivery::whereId($request->cancelId)->first();
        if ($delivey->status == 'Canceled') {
            $delivey->status = 'Pending';
        } else {
            $delivey->status = 'Canceled';
        }
        if ($delivey->save()) {
            return response()->json(['success' => true, 'delivey_day' => $delivey]);
        } else {
            return redirect()->back()->with('error', "Something went wrong.");
        }
    }
}
