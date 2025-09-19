<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function showMap()
    {
        return view('map');
    }

    public function geocodeAddress(Request $request)
    {
        $address = $request->input('address');
        
        // استخدام خدمة Nominatim للجيو كودينغ
        $url = "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($address);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Laravel-Geocoding");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        
        if (!empty($data)) {
            return response()->json([
                'success' => true,
                'lat' => $data[0]['lat'],
                'lng' => $data[0]['lon'],
                'display_name' => $data[0]['display_name']
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'لم يتم العثور على العنوان'
        ]);
    }
}