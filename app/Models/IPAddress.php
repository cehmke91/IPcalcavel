<?php

namespace App\Models;

use App\Services\IPAddressService;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IPAddress
{
    use HasFactory; // This could be used for testing later.

    public string $ip;
    public string $subnetMask;

    public function __construct(string $ip, string $subnetMask = '0')
    {
        $this->ip = $ip;
        $this->subnetMask = $subnetMask;
    }

    public function __toString()
    {
        return $this->ip; // . "/" . $this->subnetMask;
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

    /** Return the networkId for this IPAddress */
    public function networkId(): string
    {
        return substr($this->ip, 0, strrpos($this->ip, "."));
    }

    /** Return the host portion of this IPAddress */
    public function host(): string
    {
        return substr($this->ip, strrpos($this->ip, ".") +1);
    }
}