<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\Site;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use ManagesImages;

    public function edit()
    {
        $fields = collect(config('site.fields'))
            ->map(fn ($f, $k) => $f + ['key' => $k])
            ->groupBy('group');

        return view('admin.settings.edit', ['groups' => $fields]);
    }

    public function update(Request $r)
    {
        $fields = config('site.fields');
        $rules = [];
        $names = [];
        foreach ($fields as $key => $f) {
            $names[$key] = $f['label'];
            $rules[$key] = match ($f['type']) {
                'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'url' => ['nullable', 'url', 'max:255'],
                'textarea' => ['nullable', 'string', 'max:5000'],
                default => ['nullable', 'string', 'max:255'],
            };
        }
        $r->validate($rules, [], $names);

        foreach ($fields as $key => $f) {
            if ($f['type'] === 'image') {
                $old = Setting::where('name', $key)->value('value');
                $new = $this->saveImage($r, $old, 'site', $key);
                if ($new !== $old) {
                    Setting::put($key, $new);
                }
            } else {
                Setting::put($key, $r->input($key));
            }
        }
        Site::forget();
        \App\Models\ActivityLog::record('settings', 'Mengubah pengaturan situs');

        return redirect()->route('admin.settings.edit')->with('ok', 'Pengaturan disimpan.');
    }
}
