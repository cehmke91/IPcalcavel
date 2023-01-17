<?php declare(strict_types=1);

namespace App\Exceptions;

use Exception;

/** A user has provided a CIDR Subnet numbers with invalid value. */
class InvalidCIDRSubnetNumberException extends Exception
{}