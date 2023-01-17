<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Rules\CIDRIPAddressRule;

/**
 *  This controller handles requests to calculate IP ranges
 *  based on the given subnet mask.
 */
class SubnetInfoController extends Controller
{
    /** Calculate and return the subnet info */
    public function calculateInfo(Request $request): Response
    {
        $validated = $request->validate([
            'ip' => [ 'required' , new CIDRIPAddressRule ]
        ]);

        $ip = $validated['ip'];


        return new Response($ip);
    }
}