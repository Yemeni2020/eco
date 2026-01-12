<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SeoSettingRequest;
use App\Models\SeoSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $seoSetting = SeoSetting::firstOrNew(['slug' => 'global']);

        if (! $seoSetting->exists) {
            $seoSetting->fill([
                'title' => config('seo.site_title'),
                'description' => config('seo.site_description'),
                'image' => config('seo.default_image'),
                'locale' => config('seo.locale'),
            ]);
        }

        return view('admin.settings.index', [
            'seoSetting' => $seoSetting,
        ]);
    }

    public function updateSeo(SeoSettingRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $meta = $data['meta'] ? json_decode($data['meta'], true) : [];
        $jsonLd = $data['json_ld'] ? json_decode($data['json_ld'], true) : [];

        SeoSetting::updateOrCreate(
            ['slug' => $data['slug']],
            [
                'route_name' => $data['route_name'] ?? null,
                'title' => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
                'image' => $data['image'] ?? null,
                'locale' => $data['locale'] ?? null,
                'meta' => $meta ?: null,
                'json_ld' => $jsonLd ?: null,
            ]
        );

        return back()->with('status', 'SEO settings saved.');
    }
}
