<?php

namespace App\Rules;

use App\Exceptions\InvalidCIDRFormattedIPException;
use App\Services\IPAddressService;
use Illuminate\Contracts\Validation\InvokableRule;

class CIDRIPAddressRule implements InvokableRule
{
    /** Validate whether the value is a valid CIDR formatted IP address. */
    public function __invoke($attribute, $value, $fail): void
    {
        if (!is_string($value)) {
            $fail(':attribute must be passed as a string.');
        }

        try {
            $parts = IPAddressService::splitCIDRNotation($value);

            if (!IPAddressService::isValidIPAddress($parts['address'])) {
                $fail('The IP part in :attribute must be a valid IP address.');
            }
            
            if (!IPAddressService::isValidCIDRSubnetNumber($parts['subnet'])) {
                $fail('The Subnet part in :attribute must be valid.');
            }
        } catch (InvalidCIDRFormattedIPException $e) {
            $fail(':attribute must be a CIDR formatted IP address.');
        }
    }
}
