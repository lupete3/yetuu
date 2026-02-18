<?php

// App\Http\Controllers\SettingController.php
namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $viewData['title'] = 'Parametres';
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('settings.index', compact('settings'))->with('viewData',$viewData);
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            Setting::set($key, $value);
        }

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('logos'), $filename);
            Setting::set('logo', $filename);
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }    

}
