<?php declare(strict_types=1);

namespace App\Services;

use App\Exceptions\InvalidCIDRFormattedIPException;
use App\Exceptions\InvalidCIDRSubnetNumberException;
use App\Models\IPAddress;

/**
 *  This class is used to interact with IP addresses and contains functions
 *  which can extract information from an IP address.
 */
class IPAddressService
{
    /**
     *  Splits a CIDR formatted IP into the IP and Subnet parts.
     *  
     *  @return array<string> containing 'ip' and 'subnet'
     *  @throws InvalidCIDRFormattedIPException
     */
    public static function splitCIDRNotation(string $CIDRIPAddress): array
    {
        $parts = array_map('trim', explode('/', $CIDRIPAddress));

        if (count($parts) !== 2) {
            throw new InvalidCIDRFormattedIPException(
                "The given IP Must be a valid CIDR formatted IP address."
            );
        }

        return [
            'address' => $parts[0],
            'subnet' => $parts[1]
        ];
    }

    /**
     *  Determines whether the number is a valid CIDR notation subnet.
     *  Valid numbers range from 0 to 32; 0 is no mask and 32 is a full mask.
     * 
     *  @param string|int   The CIDR notation subnet number.
     *                      strings may be provided for convenience.
     */
    public static function isValidCIDRSubnetNumber($number): bool
    {
        // if a string was provided convert to int.
        if (is_string($number)) $number = intval($number);

        return $number >= 0 && $number <=32;
    }

    /**
     *  Determines whether the given value is a valid IP address.
     *  Currently supports IPv4 and IPv6.
     */
    public static function isValidIPAddress(string $address): bool
    {
        // filter_var will return filtered data if it is correct.
        return false !== filter_var($address, FILTER_VALIDATE_IP);
    }

    /**
     *  Converts a CIDR formatted subnet number to a subnet mask.
     *  
     *  @throws InvalidCIDRSubnetNumberException
     */
    public static function CIDRToMask(int $subnet): string
    {
        if (!self::isValidCIDRSubnetNumber($subnet)) {
            throw new InvalidCIDRSubnetNumberException(
                "Subnet number must be between 0 and 32, inclusive"
            );
        }

        // create a blank mask then flip the relevant bits.
        $subnetMask = '00000000000000000000000000000000';
        for ($i = 0; $i < $subnet; $i++) {
            $subnetMask[$i] = '1';
        }

        // split the resulting mask to groups of 8 representing the IP parts.
        $subnetMask = str_split($subnetMask, 8);

        // convert the binary to decimal.
        foreach ($subnetMask as &$part) {
            $part = bindec($part);
        }

        // return in string format.
        return implode(".", $subnetMask);
    }

    /**
     *  Calculate the subnet range for a given IP address.
     */
    public static function calculateSubnetRange(IPAddress $address): array
    {
        $first = '';
        $last = '';
        $hosts = 1; // since this host is present there must be 1

        // break the ip and subnet mask into parts so we can work on
        // each part individually.
        $ip = explode('.', $address->ip);
        $subnetMask = explode('.', $address->subnetMask);

        foreach ($subnetMask as $i => $part) {
            // if the mask completely covers this range then we can assume
            // that they are the same as the IP.
            if ($part === '255') {
                $first .= '.'.$ip[$i];
                $last .= '.'.$ip[$i];
                continue;
            }

            // Get the range then multiply the number of hosts by the range.
            // This is multiplied because the part which follows will have
            // its' own full range for each of the addresses in this range.
            $range = 254 - (int) $part;
            $hosts *= $range;

            // append the first address value
            $first .= '.' . $ip[$i];

            // calculate the last address value
            $lastValue = (int) $ip[$i] + $range;
            $last .= '.' . (string) $lastValue;
        }

        return [
            'first' => ltrim($first, '.'),
            'last' => ltrim($last, '.'),
            'hosts' => $range
        ];
    }
}