<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('pages.contact', [
            'contactHeading' => SiteSetting::getValue('contact_heading', 'Get in touch'),
            'contactDescription' => SiteSetting::getValue('contact_description', "Have a question or need assistance? We're here to help you with anything from product inquiries to order support."),
            'contactPhone' => SiteSetting::getValue('contact_phone', '+91 9106005682'),
            'contactEmail' => SiteSetting::getValue('contact_email', 'info@lillysnook.com'),
            'contactAddress' => SiteSetting::getValue('contact_address', 'Rajkot, Gujarat, India'),
            'contactInstagram' => SiteSetting::getValue('contact_instagram', 'https://instagram.com/lillysnook'),
            'contactFacebook' => SiteSetting::getValue('contact_facebook', 'https://facebook.com/lillysnook'),
            'contactWhatsapp' => SiteSetting::getValue('contact_whatsapp', 'https://wa.me/919106005682'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'message' => ['required', 'string', 'min:10'],
        ]);

        ContactMessage::query()->create($validated);

        return redirect()->route('contact.show')->with('status', 'Your message has been sent.');
    }
}
