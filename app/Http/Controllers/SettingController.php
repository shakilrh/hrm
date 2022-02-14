<?php

namespace App\Http\Controllers;

use App\Settings;
use App\Traits\FileHandler;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class SettingController extends Controller
{
    use FileHandler;

    public function index()
    {
        return view('settings');
    }

    public function update(Request $request, Settings $settings)
    {
        $settings->put('application_name', $request->application_name);
        $settings->put('application_title', $request->application_title);
        $settings->put('address', $request->address);
        $settings->put('system_email', $request->system_email);

        $logo = $request->file('logo');
        $this->uploadImage($logo, '/', 'logo', '100', '100', settings('logo'));
        $settings->put('logo', $this->fileName);

        $favicon = $request->file('favicon');
        $this->uploadImage($favicon, '/', 'favicon', '34', '34', settings('favicon'));
        $settings->put('favicon', $this->fileName);


        Toastr::success('Setings Successfully Saved', 'Success');
        return redirect()->back();
    }
}
