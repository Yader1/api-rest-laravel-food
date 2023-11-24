<?php

namespace App\Http\Controllers\Api\V1;
use App\Models\Zone;
use App\Models\BusinessSetting;
use App\Models\Currency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\CentralLogics\Helpers;
use Grimzy\LaravelMysqlSpatial\Types\Point;


class ConfigController extends Controller{
    public function geocode_api(Request $request){
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if ($validator->errors()->count()>0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$request->lat.','.$request->lng.'&key='."AIzaSyBv2O1XCPgrtT8TAkeCn1UKDgI0p2_jMe8");
        return $response->json();
    }
    
    public function get_zone(Request $request){
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if ($validator->errors()->count()>0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $point = new Point($request->lat,$request->lng);
        $zones = Zone::contains('coordinates', $point)->latest()->get();
        if(empty($zones)){
            return response()->json(['code'=>1, 'message'=>'error'], 404);
        }
        return response()->json(['code'=>0, 'message'=>'success', 'data'=>$zones->id]);
        //return response()->json(['message'=>trans('messages.we_are_temporarily_unavailable_in_this_area')], 403);
        //return response()->json(['zone_id'=>1], 200);
    }

    public function configuration(){
        
    }

    public function place_api_autocomplete(Request $request){
        $validator = Validator::make($request -> all(), [
            'search_text' => 'required'
        ]);

        if($validator->errors()->count()>0){
            return response()->json(
                ['errors' => Helpers::error_processor($validator)], 
                403
            );
        }

        $response = Http::get(
            'https://maps.googleapis.com/maps/api/place/autocomplete/json?input='
            .$request['search_text']
            .'&key='
            .'AIzaSyBv2O1XCPgrtT8TAkeCn1UKDgI0p2_jMe8'
        );

        return $response->json();
    }

    public function place_api_details(Request $request){
        $validator = Validator::make($request -> all(), [
            'placeid' => 'required'
        ]);

        if($validator->errors()->count()>0){
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $response = Http::get(
            'https://maps.googleapis.com/maps/api/place/details/json?placeid='
            .$request['placeid']
            .'&key='
            .'AIzaSyBv2O1XCPgrtT8TAkeCn1UKDgI0p2_jMe8'
        );

        return $response->json();
    }
}