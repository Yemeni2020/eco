<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\SiteSetting;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SiteSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FooterSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SiteSettingsSeeder::class);
    }

    public function test_guest_cannot_update_footer_settings(): void
    {
        $response = $this->put(route('admin.settings.footer.update'), []);

        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_update_footer_settings(): void
    {
        $admin = Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        $payload = [
            'translations' => [
                'en' => [
                    'company' => [
                        'name' => 'Otex Store',
                        'description' => 'English description',
                    ],
                    'links' => [
                        ['label' => 'Shop', 'url' => 'https://example.com/shop'],
                    ],
                    'contact' => [
                        'phone' => '+966000000000',
                        'email' => 'support@example.com',
                        'whatsapp' => 'https://wa.me/966000000000',
                    ],
                    'social' => [
                        'facebook' => 'https://facebook.com/otex',
                    ],
                    'bottom_text' => 'Otex © 2025',
                ],
                'ar' => [
                    'company' => [
                        'name' => 'أوتكس',
                        'description' => 'الوصف العربي',
                    ],
                    'links' => [
                        ['label' => 'متجر', 'url' => 'https://example.com/ar/shop'],
                    ],
                    'contact' => [
                        'phone' => '+966111111111',
                        'email' => 'support@otex.sa',
                        'whatsapp' => 'https://wa.me/966111111111',
                    ],
                    'social' => [
                        'twitter' => 'https://twitter.com/otex',
                    ],
                    'bottom_text' => 'أوتكس © 2025',
                ],
            ],
        ];

        $response = $this->actingAs($admin, 'admin')
            ->put(route('admin.settings.footer.update'), $payload);

        $response->assertRedirect(route('admin.settings.index'));
        $response->assertSessionHas('footer_status', 'Footer settings saved.');

        $setting = SiteSetting::firstWhere('key', 'footer');
        $this->assertEquals('Otex Store', $setting->value['translations']['en']['company']['name']);
        $this->assertEquals('أوتكس', $setting->value['translations']['ar']['company']['name']);
    }

    public function test_invalid_link_url_fails_validation(): void
    {
        $admin = Admin::create([
            'name' => 'Admin User',
            'email' => 'admin-2@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        $payload = [
            'translations' => [
                'en' => [
                    'company' => [
                        'name' => 'Otex Store',
                        'description' => 'Desc',
                    ],
                    'links' => [
                        ['label' => 'Invalid', 'url' => 'not-a-url'],
                    ],
                    'contact' => [
                        'phone' => '',
                        'email' => '',
                        'whatsapp' => '',
                    ],
                    'social' => [],
                    'bottom_text' => 'Otex © 2025',
                ],
                'ar' => [
                    'company' => [
                        'name' => 'أوتكس',
                        'description' => 'الوصف',
                    ],
                    'links' => [],
                    'contact' => [
                        'phone' => '',
                        'email' => '',
                        'whatsapp' => '',
                    ],
                    'social' => [],
                    'bottom_text' => 'أوتكس © 2025',
                ],
            ],
        ];

        $response = $this->actingAs($admin, 'admin')->put(route('admin.settings.footer.update'), $payload);

        $response->assertSessionHasErrors('translations.en.links.0.url');
    }
}
