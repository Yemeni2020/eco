<?php

namespace App\Domain\Payments;

use App\Domain\Payments\Contracts\PaymentGateway;
use App\Domain\Payments\Gateways\ApplePayGateway;
use App\Domain\Payments\Gateways\MadaGateway;
use App\Domain\Payments\Gateways\MockGateway;
use App\Domain\Payments\Gateways\StcPayGateway;
use App\Domain\Payments\Repositories\PaymentGatewaySettingsRepository;
use InvalidArgumentException;

class PaymentGatewayResolver
{
    private const PROVIDER_MAP = [
        'mada' => MadaGateway::class,
        'stcpay' => StcPayGateway::class,
        'applepay' => ApplePayGateway::class,
        'mock' => MockGateway::class,
    ];

    public function __construct(private PaymentGatewaySettingsRepository $gatewaySettingsRepository)
    {
    }

    public function resolve(?string $provider = null): PaymentGateway
    {
        $provider = $this->normalizeProvider($provider);

        if (! isset(self::PROVIDER_MAP[$provider])) {
            throw new InvalidArgumentException("Unsupported payment provider: {$provider}");
        }

        if ($provider !== 'mock' && ! $this->gatewaySettingsRepository->get($provider)->is_enabled) {
            throw new InvalidArgumentException("Payment provider {$provider} is not enabled.");
        }

        $config = $this->buildGatewayConfig($provider);

        $class = self::PROVIDER_MAP[$provider];

        return new $class($config);
    }

    private function normalizeProvider(?string $provider): string
    {
        $provider = $provider ?: config('payments.default', 'mock');

        return strtolower($provider);
    }

    private function buildGatewayConfig(string $provider): array
    {
        if ($provider === 'mock') {
            return config('payments.providers.mock', []);
        }

        $settings = $this->gatewaySettingsRepository->get($provider);

        return array_merge(
            $this->gatewaySettingsRepository->decryptCredentials($provider),
            [
                'sandbox_mode' => $settings->sandbox_mode,
            ]
        );
    }
}
