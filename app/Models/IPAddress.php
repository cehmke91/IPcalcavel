<?php

namespace App\Models;

use App\Services\IPAddressService;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IPAddress
{
    use HasFactory; // This could be used for testing later.

    public string $ip;
    public string $subnet;

    public function __construct(string $ip, string $subnet = '0')
    {
        $this->ip = $ip;
        $this->subnet = $subnet;
    }

    /** Create a new IPAddress from a CIDR formatted string */
    public static function fromCIDRNotation(string $CIDRformattedIP): IPAddress
    {
        $parts = IPAddressService::SplitCIDRNotation($CIDRformattedIP);

        return new self(
            $parts['address'],
            IpAddressService::CIDRToMask($parts['subnet'])
        );
    }
}