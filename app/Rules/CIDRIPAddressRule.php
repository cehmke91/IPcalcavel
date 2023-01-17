<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class CIDRIPAddressRule implements InvokableRule
{
    /** Validate whether the value is a valid CIDR formatted IP address. */
    public function __invoke($attribute, $value, $fail): void
    {
        if (!is_string($value)) {
            $fail(':attribute must be passed as a string.');
        }
        
        // Split into IP and subnet mask parts.
        $parts = array_map('trim', explode('/', $value));
        
        if (count($parts) !== 2) {
            $fail(':attribute must be a CIDR formatted IP address.');
        }
        
        if (! $this->isValidIPAddress($parts[0])) {
            $fail('The IP part in :attribute must be a valid IP address.');
        }
        
        if (! $this->isValidCIDRSubnetMask((int) $parts[1])) {
            $fail('The Subnet part in :attribute must be valid.');
        }
    }

    /**
     *  Determines whether the given value is a valid IP address.
     *  Currently supports IPv4 and IPv6.
     */
    private function isValidIPAddress(string $address): bool
    {
        return filter_var($address, FILTER_VALIDATE_IP);
    }

    /**
     *  Determines whether the given number is a valid CIDR number.
     *  A valid CIDR number is between 1 and 32 and corresponds to
     *  the number of bits flipped to 1 in the subnet mask.
     */
    private function isValidCIDRSubnetMask(int $mask): bool
    {
        return $mask > 0 && $mask <= 32;
    }
}
