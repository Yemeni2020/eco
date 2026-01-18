<?php

namespace App\Services;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class PhoneNormalizer
{
    public function normalize(string $phone): string
    {
        $util = PhoneNumberUtil::getInstance();
        $region = config('phone.default_region');

        try {
            $parsed = $util->parse($phone, $region);
        } catch (NumberParseException $exception) {
            throw new \InvalidArgumentException('Unable to normalize phone number.');
        }

        return $util->format($parsed, PhoneNumberFormat::E164);
    }
}
