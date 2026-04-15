<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Settings\GeneralSettings;
class SettngController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GeneralSettings $generalSettings)
    {
        return view('admin.settings.edit', compact('generalSettings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, GeneralSettings $settings)
{
    $request->validate([
        'site_name' => 'required|string|max:255',
        'site_email' => 'required|email',
        'site_phone' => 'required',
        'site_address' => 'required',
    ]);

    // تحديث الإعدادات ببساطة
    $settings->site_name = $request->site_name;
    $settings->site_email = $request->site_email;
    $settings->site_phone = $request->site_phone;
    $settings->site_address = $request->site_address;
    $settings->facebook_url = $request->facebook_url;
    $settings->twitter_url = $request->twitter_url;
    $settings->instagram_url = $request->instagram_url;
    $settings->linkedin_url = $request->linkedin_url;

    $settings->save();

    return back()->with('success', 'Settings updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
