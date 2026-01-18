<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;

class SiteContent
{
    protected array $settings = [];

    public function __construct()
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        SiteSetting::all()->each(function (SiteSetting $setting) {
            $this->settings[$setting->key] = $setting->value ?? [];
        });
    }

    public function topbar(?string $locale = null): array
    {
        return $this->localized($this->settings['topbar'] ?? $this->defaultTopbar(), $locale);
    }

    public function footer(?string $locale = null): array
    {
        return $this->localized($this->settings['footer'] ?? $this->defaultFooter(), $locale);
    }

    protected function localized(array $setting, ?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();
        $translations = $setting['translations'] ?? [];
        if ($translations) {
            $defaultLocale = $setting['default_locale'] ?? 'en';
            if (isset($translations[$locale])) {
                return $translations[$locale];
            }
            if (isset($translations[$defaultLocale])) {
                return $translations[$defaultLocale];
            }
            if (isset($translations['en'])) {
                return $translations['en'];
            }
        }

        return $setting;
    }

    protected function defaultTopbar(): array
    {
        return [
            'default_locale' => 'en',
            'translations' => [
                'en' => [
                    'label' => 'Breaking',
                    'items' => [
                        ['text' => 'Markets rally as inflation cools', 'url' => '#'],
                        ['text' => 'New AI model boosts developer productivity', 'url' => '#'],
                        ['text' => 'Weather update: clear skies this week', 'url' => '#'],
                        ['text' => 'Championship match ends in dramatic draw', 'url' => '#'],
                    ],
                ],
                'ar' => [
                    'label' => 'عاجل',
                    'items' => [
                        ['text' => 'الأسواق ترتفع مع تراجع التضخم', 'url' => '#'],
                        ['text' => 'نموذج ذكاء اصطناعي جديد يزيد الإنتاجية', 'url' => '#'],
                        ['text' => 'تحديث الطقس: سماء صافية هذا الأسبوع', 'url' => '#'],
                        ['text' => 'مباراة نهائية تنتهي بالتعادل الدرامي', 'url' => '#'],
                    ],
                ],
            ],
        ];
    }

    protected function defaultFooter(): array
    {
        return [
            'default_locale' => 'en',
            'translations' => [
                'en' => [
                    'company' => [
                        'name' => 'Otex for E-Commerce',
                        'description' => 'Premium automotive marketplace built for customers who expect premium experiences.',
                        'registrations' => [
                            ['label' => 'Commercial Register', 'value' => '000000000'],
                            ['label' => 'VAT Registration', 'value' => '000000000000000'],
                        ],
                    ],
                    'links' => [
                        ['label' => 'Shipping & Returns', 'url' => '#'],
                        ['label' => 'Privacy Policy', 'url' => '#'],
                        ['label' => 'Terms & Conditions', 'url' => '#'],
                        ['label' => 'Support Center', 'url' => '#'],
                    ],
                    'contact' => [
                        ['type' => 'whatsapp', 'label' => '+966000000000', 'url' => 'https://wa.me/966000000000'],
                        ['type' => 'phone', 'label' => '+966000000001', 'url' => 'tel:+966000000001'],
                        ['type' => 'email', 'label' => 'example123@example.com', 'url' => 'mailto:example123@example.com'],
                    ],
                    'payments' => [
                        ['src' => 'https://cdn.salla.network/cdn-cgi/image/fit=scale-down,width=58,height=58,onerror=redirect,format=auto/images/payment/mada_mini.png', 'alt' => 'Mada'],
                        ['src' => 'https://cdn.salla.network/cdn-cgi/image/fit=scale-down,width=58,height=58,onerror=redirect,format=auto/images/payment/credit_card_mini.png', 'alt' => 'Credit card'],
                        ['src' => 'https://cdn.salla.network/cdn-cgi/image/fit=scale-down,width=58,height=58,onerror=redirect,format=auto/images/payment/stc_pay_mini.png', 'alt' => 'STC Pay'],
                        ['src' => 'https://cdn.salla.network/cdn-cgi/image/fit=scale-down,width=58,height=58,onerror=redirect,format=auto/images/payment/apple_pay_mini.png', 'alt' => 'Apple Pay'],
                        ['src' => 'https://cdn.salla.network/cdn-cgi/image/fit=scale-down,width=58,height=58,onerror=redirect,format=auto/images/payment/google_pay_mini.png', 'alt' => 'Google Pay'],
                        ['src' => 'https://cdn.salla.network/cdn-cgi/image/fit=scale-down,width=58,height=58,onerror=redirect,format=auto/images/payment/tamara_installment_mini.png', 'alt' => 'Tamara Installment'],
                        ['src' => 'https://cdn.salla.network/cdn-cgi/image/fit=scale-down,width=58,height=58,onerror=redirect,format=auto/images/payment/cod_mini.png', 'alt' => 'Cash on Delivery'],
                    ],
                    'copyright' => 'Otex E-Commerce © ' . now()->year,
                ],
                'ar' => [
                    'company' => [
                        'name' => 'أوتكس للتجارة الإلكترونية',
                        'description' => 'سوق سيارات متميز للعملاء الذين يتوقعون تجربة راقية.',
                        'registrations' => [
                            ['label' => 'السجل التجاري', 'value' => '000000000'],
                            ['label' => 'رقم ضريبة القيمة المضافة', 'value' => '000000000000000'],
                        ],
                    ],
                    'links' => [
                        ['label' => 'الشحن والإرجاع', 'url' => '#'],
                        ['label' => 'سياسة الخصوصية', 'url' => '#'],
                        ['label' => 'الشروط والأحكام', 'url' => '#'],
                        ['label' => 'مركز الدعم', 'url' => '#'],
                    ],
                    'contact' => [
                        ['type' => 'whatsapp', 'label' => '+966000000000', 'url' => 'https://wa.me/966000000000'],
                        ['type' => 'phone', 'label' => '+966000000001', 'url' => 'tel:+966000000001'],
                        ['type' => 'email', 'label' => 'example123@example.com', 'url' => 'mailto:example123@example.com'],
                    ],
                    'payments' => [
                        ['src' => 'https://cdn.salla.network/cdn-cgi/image/fit=scale-down,width=58,height=58,onerror=redirect,format=auto/images/payment/mada_mini.png', 'alt' => 'مدى'],
                        ['src' => 'https://cdn.salla.network/cdn-cgi/image/fit=scale-down,width=58,height=58,onerror=redirect,format=auto/images/payment/credit_card_mini.png', 'alt' => 'بطاقات الائتمان'],
                        ['src' => 'https://cdn.salla.network/cdn-cgi/image/fit=scale-down,width=58,height=58,onerror=redirect,format=auto/images/payment/stc_pay_mini.png', 'alt' => 'خدمة سوا'],
                        ['src' => 'https://cdn.salla.network/cdn-cgi/image/fit=scale-down,width=58,height=58,onerror=redirect,format=auto/images/payment/apple_pay_mini.png', 'alt' => 'آبل باي'],
                        ['src' => 'https://cdn.salla.network/cdn-cgi/image/fit=scale-down,width=58,height=58,onerror=redirect,format=auto/images/payment/google_pay_mini.png', 'alt' => 'جوجل باي'],
                        ['src' => 'https://cdn.salla.network/cdn-cgi/image/fit=scale-down,width=58,height=58,onerror=redirect,format=auto/images/payment/tamara_installment_mini.png', 'alt' => 'تمارا'],
                        ['src' => 'https://cdn.salla.network/cdn-cgi/image/fit=scale-down,width=58,height=58,onerror=redirect,format=auto/images/payment/cod_mini.png', 'alt' => 'دفع عند التسليم'],
                    ],
                    'copyright' => 'أوتكس للتجارة الإلكترونية © ' . now()->year,
                ],
            ],
        ];
    }
}
