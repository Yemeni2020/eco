<?php

namespace App\Http\Requests\Admin;

use App\Domain\Payments\Repositories\PaymentGatewaySettingsRepository;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentGatewaysRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin') !== null;
    }

    public function rules(): array
    {
        $repository = app(PaymentGatewaySettingsRepository::class);

        $rules = [
            'gateways' => ['required', 'array'],
        ];

        foreach ($repository->supportedGateways() as $gateway => $definition) {
            $rules["gateways.{$gateway}.display_name"] = ['nullable', 'string', 'max:255'];
            $rules["gateways.{$gateway}.is_enabled"] = ['sometimes', 'boolean'];
            $rules["gateways.{$gateway}.sandbox_mode"] = ['sometimes', 'boolean'];

            $credentialFields = array_merge(
                array_keys($definition['public_fields'] ?? []),
                array_keys($definition['secret_fields'] ?? [])
            );

            foreach ($credentialFields as $field) {
                $rules["gateways.{$gateway}.{$field}"] = ['nullable', 'string', 'max:2048'];
            }
        }

        return $rules;
    }
}
