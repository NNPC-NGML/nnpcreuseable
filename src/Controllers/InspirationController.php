<?php

namespace Skillz\Nnpcreusable\Controllers;

use Illuminate\Http\Request;
use Skillz\Nnpcreusable\Inspire;

class InspirationController
{
    public function __invoke(Inspire $inspire)
    {
        $quote = $inspire->justDoIt();

        return view('inspire::index', compact('quote'));
    }
}
