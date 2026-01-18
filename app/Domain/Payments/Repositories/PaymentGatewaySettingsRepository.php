<?php

namespace App\Domain\Payments\Repositories;

use App\Models\PaymentGatewaySetting;
use Illuminate\Support\Collection;

class PaymentGatewaySettingsRepository
{
    private const GATEWAYS = [
        'mada' => [
            'label' => 'Mada',
            'public_fields' => [
                'merchant_id' => 'Merchant ID',
                'terminal_id' => 'Terminal ID',
            ],
            'secret_fields' => [
                'api_key' => 'API Key',
                'secret' => 'Secret key',
            ],
        ],
        'stcpay' => [
            'label' => 'STC Pay',
            'public_fields' => [
                'merchant_id' => 'Merchant ID',
                'terminal_id' => 'Terminal ID',
            ],
            'secret_fields' => [
                'api_key' => 'API Key',
                'secret' => 'Secret key',
            ],
        ],
        'applepay' => [
            'label' => 'Apple Pay',
            'public_fields' => [
                'merchant_id' => 'Merchant ID',
                'apple_merchant_id' => 'Apple Merchant ID',
            ],
            'secret_fields' => [
                'api_key' => 'API Key',
                'secret' => 'Secret key',
            ],
        ],
    ];

    public function supportedGateways(): array
    {
        return self::GATEWAYS;
    }

    public function get(string $gateway): PaymentGatewaySetting
    {
        return PaymentGatewaySetting::firstOrNew(
            ['gateway' => $gateway],
            ['display_name' => self::GATEWAYS[$gateway]['label'] ?? ucfirst($gateway)]
        );
    }

    public function all(): Collection
    {
        return PaymentGatewaySetting::query()
            ->whereIn('gateway', array_keys(self::GATEWAYS))
            ->get()
            ->keyBy('gateway');
    }

    public function enabled(): Collection
    {
        return $this->all()->filter->is_enabled;
    }

    public function decryptCredentials(string $gateway): array
    {
        $setting = $this->get($gateway);
        $definition = $this->supportedGateways()[$gateway] ?? [];

        return collect(array_merge(
            $definition['public_fields'] ?? [],
            $definition['secret_fields'] ?? []
        ))->keys()->mapWithKeys(function (string $field) use ($setting) {
            return [$field => $setting->getCredential($field)];
        })->filter(function ($value) {
            return $value !== null;
        })->toArray();
    }

    public function configFor(string $gateway): array
    {
        $setting = $this->get($gateway);

        return [
            'gateway' => $gateway,
            'display_name' => $setting->display_name ?? (self::GATEWAYS[$gateway]['label'] ?? ucfirst($gateway)),
            'sandbox_mode' => $setting->sandbox_mode,
            'credentials' => $this->decryptCredentials($gateway),
        ];
    }

    public function updateFromPayload(array $payload): Collection
    {
        $updated = collect();

        foreach ($this->supportedGateways() as $gateway => $definition) {
            $data = $payload[$gateway] ?? [];
            if (! is_array($data)) {
                continue;
            }

            $setting = $this->get($gateway);
            $setting->fill([
                'display_name' => $data['display_name'] ?? $setting->display_name ?? $definition['label'],
                'is_enabled' => isset($data['is_enabled']) ? boolval($data['is_enabled']) : false,
                'sandbox_mode' => isset($data['sandbox_mode']) ? boolval($data['sandbox_mode']) : true,
            ]);

            $credentialFields = array_merge(
                array_keys($definition['public_fields'] ?? []),
                array_keys($definition['secret_fields'] ?? [])
            );

            foreach ($credentialFields as $field) {
                $value = $data[$field] ?? null;
                $secretField = in_array($field, array_keys($definition['secret_fields'] ?? []), true);

                if ($secretField && $value === PaymentGatewaySetting::SECRET_PLACEHOLDER) {
                    continue;
                }

                $setting->setCredential($field, $value);
            }

            $setting->save();
            $updated->push($setting);
        }

        return $updated;
    }

    public function enabledOptions(): Collection
    {
        return $this->enabled()->map(function (PaymentGatewaySetting $setting) {
            $definition = $this->supportedGateways()[$setting->gateway] ?? [];

            return [
                'gateway' => $setting->gateway,
                'label' => $setting->display_name ?? ($definition['label'] ?? ucfirst($setting->gateway)),
            ];
        })->values();
    }
}
