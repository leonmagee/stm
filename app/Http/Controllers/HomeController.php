<?php

namespace App\Http\Controllers;

use App\Carrier;
use App\Helpers;
use App\Plan;
use App\ReportType;
use App\Settings;
use App\Sim;
use App\Slide;
use App\User;
use App\UserCreditBonus;
use Cloudder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();

        if ($user->isAdmin() || $user->isManager() || $user->isEmployee()) {
            return $this->outputCharts();
        } else {
            if (Helpers::is_site_locked()) {
                return $this->outputLockedPage();
            } else {
                return $this->outputCharts();
            }
        }

    }

    public function commission()
    {
        $h2o_plans = Plan::where('carrier_id', 1)->get();
        $lyca_plans = Plan::where('carrier_id', 2)->get();

        return view('commission', compact('h2o_plans', 'lyca_plans'));
    }

    public function outputLockedPage()
    {
        return view('locked');
    }

    public function outputProfile(User $user)
    {
        $bonus_credit = UserCreditBonus::where([
            'user_id' => $user->id,
            'date' => Helpers::current_date(),
        ])->first();

        if (isset($bonus_credit->bonus)) {
            $bonus = '$' . number_format($bonus_credit->bonus, 2);
        } else {
            $bonus = false;
        }
        if (isset($bonus_credit->credit)) {
            $credit = '$' . number_format($bonus_credit->credit, 2);
        } else {
            $credit = false;
        }

        if ($user->role->id === 1) {
            $role = 'Admin';
        } else {
            $role = $user->role->name;
        }
        return view('users.show_not_admin', compact('user', 'role', 'bonus', 'credit'));
    }

    public function outputUpload()
    {

        $report_types = ReportType::query()->orderBy('order_index')->get();

        $carriers = Carrier::all();

        $role_id = Helpers::current_role_id();

        $users = User::where('role_id', $role_id)->get();
        return view('sims.upload', compact('report_types', 'users', 'carriers'));
    }

    public function outputCharts()
    {
        $current_date = Settings::first()->current_date;

        $data_array = [];

        $array_item = [];

        $date_array = Helpers::date_array();

        $array_index = array_search($current_date, $date_array);

        $one_month_ago = $date_array[$array_index - 1];
        $two_month_ago = $date_array[$array_index - 2];
        $three_month_ago = $date_array[$array_index - 3];

        $date_array_final = [
            $current_date,
            $one_month_ago,
            $two_month_ago,
            $three_month_ago,
        ];

        $date_name_array = [
            Helpers::current_date_name(),
            Helpers::get_date_name($one_month_ago),
            Helpers::get_date_name($two_month_ago),
            Helpers::get_date_name($three_month_ago),
        ];

        $report_types_array = ReportType::where('spiff', 1)->orderBy('order_index')->get();

        foreach ($report_types_array as $report_type) {

            $name = $report_type->name;

            $carrier = $report_type->carrier->name;

            $array_item['title'] = $carrier . " " . $name;

            $temp_count = 0;

            foreach ($date_array_final as $date) {

                $sims = Sim::where([
                    'upload_date' => $date,
                    'report_type_id' => $report_type->id,
                ])->get();

                $number = count($sims);

                $array_item['counts'][] = $number;

                $temp_count += $number;
            }

            if ($temp_count > 0) { // exclude report types with no data
                $data_array[] = $array_item;
            }

            $array_item = [];
        }

        return view('index', compact('data_array', 'date_name_array'));

    }

    public function imei()
    {
        dd('test');
        /**
         * Shell Exec
         */
        // $imei = "355136052818864";
        // // $imei = "353331072816483";

        // $curl_command = "curl -X POST https://www.imei.info/api/checkimei/ -H 'cache-control: no-cache'  -H 'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW' -F imei=" . $imei . " -F key=bb31213cd934cecdd3546016528a8ee26770f10d9ad4b8711f0d0ce0d6cbd179";

        // $response = shell_exec($curl_command);

        // echo $response;

        /// END SHELL

        $curl = curl_init();

        // curl -X POST https://www.imei.info/api/checkimei/ -H 'cache-control: no-cache'  -H 'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW' -F imei={imei-to-check-here} -F key={your-api-key-here}

        // $curl_url = "-X POST https://www.imei.info/api/checkimei/ -H 'cache-control: no-cache'  -H 'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW' -F imei=" . $imei . " -F key=" . env('IMEI_KEY');

        //$curl_url = "https://www.imei.info/api/checkimei/ -H 'cache-control: no-cache' -H boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW' -F";
        $curl_url = "https://www.imei.info/api/checkimei/";

        curl_setopt($curl, CURLOPT_URL, $curl_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_exec($curl);

        curl_close($curl);

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => $curl_url,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => "imei=353331072816483",
        //     CURLOPT_HTTPHEADER => array(
        //         //"content-type: application/x-www-form-urlencoded",
        //         "content-type: multipart/form-data",
        //         //"x-rapidapi-host: ismaelc-imei-info.p.rapidapi.com",
        //         "key: 7f92af3009mshfe041a55ab2ecf1p14ef7ejsn8f081578ce1e",
        //     ),
        // ));

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://ismaelc-imei-info.p.rapidapi.com/checkimei?password=e9cdsR*M71%2526363KrT%25400O&login=leonmagee33%2540gmail.com",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => "imei=355136052818864",
        //     CURLOPT_HTTPHEADER => array(
        //         "content-type: application/x-www-form-urlencoded",
        //         "x-rapidapi-host: ismaelc-imei-info.p.rapidapi.com",
        //         "x-rapidapi-key: 7f92af3009mshfe041a55ab2ecf1p14ef7ejsn8f081578ce1e",
        //     ),
        // ));

        // $response = curl_exec($curl);
        // $err = curl_error($curl);

        // curl_close($curl);

        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // } else {
        //     echo $response;
        // }

        //dd('so far');

        return view('imei.index');
    }

    public function slider()
    {
        $slides = Slide::orderBy('order')->get();
        return view('settings.slider-settings', compact('slides'));
    }

    public static function update_order(Request $request)
    {
        $slide = Slide::find($request->slideId);
        $slide->update_order($request->slideIndex);
    }

    public function update_slides(Request $request)
    {
        $slides = Slide::orderBy('order')->get();
        foreach ($slides as $slide) {
            ${"image_upload_" . $slide->id} = $request->file('upload-image-' . $slide->id);
            if (${"image_upload_" . $slide->id}) {
                $image_path = ${"image_upload_" . $slide->id}->getRealPath();
                $cloudinaryWrapper = Cloudder::upload($image_path, null, [
                    'folder' => 'STM',
                    'format' => 'jpeg',
                ]);
                $result = $cloudinaryWrapper->getResult();
                $slide->url = $result['secure_url'];
            } elseif ($request->{"img_url_" . $slide->id}) {
                $slide->url = $request->{"img_url_" . $slide->id};
            } else {
                $slide->url = '';
            }
            $slide->save();
        }

        session()->flash('message', 'Slides have been updated.');
        return redirect()->back();
    }
}
