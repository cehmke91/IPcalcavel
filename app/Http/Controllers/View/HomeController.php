<?php declare(strict_types=1);

namespace App\Http\Controllers\View;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;

/** Render out the home page. */
class HomeController extends Controller
{
    /** Render out the homepage */
    public function __invoke()
    {
        return View::make('pages/home');
    }
}
