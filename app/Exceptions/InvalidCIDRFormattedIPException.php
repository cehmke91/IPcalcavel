<?php declare(strict_types=1);

namespace App\Exceptions;

use Exception;

/** A user has provided a CIDR IP Address with invalid format. */
class InvalidCIDRFormattedIPException extends Exception
{}