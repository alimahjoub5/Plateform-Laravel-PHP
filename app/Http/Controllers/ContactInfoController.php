<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    public function edit()
    {
        $contactInfo = ContactInfo::first();
        return view('admin.contact-info.edit', compact('contactInfo'));
    }

    public function update(Request $request)
    {
        $contactInfo = ContactInfo::firstOrNew();
        $contactInfo->phone = $request->input('phone');
        $contactInfo->email = $request->input('email');
        $contactInfo->address = $request->input('address');
        $contactInfo->working_hours = $request->input('working_hours');
        $contactInfo->facebook_url = $request->input('facebook_url');
        $contactInfo->twitter_url = $request->input('twitter_url');
        $contactInfo->linkedin_url = $request->input('linkedin_url');
        $contactInfo->instagram_url = $request->input('instagram_url');
        $contactInfo->save();
    
        return redirect()->route('dashboard.contact-info.edit')->with('success', 'Informations de contact mises à jour avec succès.');
    }
}
