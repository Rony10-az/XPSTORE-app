<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');

        $data = [
            'app_name' => $settings['app_name'] ?? config('app.name'),
            'app_url' => $settings['app_url'] ?? config('app.url'),
            'mail_from_name' => $settings['mail_from_name'] ?? env('MAIL_FROM_NAME', config('app.name')),
            'mail_from_address' => $settings['mail_from_address'] ?? env('MAIL_FROM_ADDRESS', 'hello@example.com'),
            'support_email' => $settings['support_email'] ?? env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        ];

        return view('admin.settings.index', compact('data'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:100',
            'app_url' => 'required|url|max:150',
            'mail_from_name' => 'required|string|max:100',
            'mail_from_address' => 'required|email|max:150',
            'support_email' => 'nullable|email|max:150',
        ]);

        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value);
        }

        return redirect()->route('admin.settings')->with('success', 'Configuración actualizada.');
    }
}
