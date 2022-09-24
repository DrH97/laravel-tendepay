<?php

namespace DrH\TendePay\Http;

use DrH\TendePay\Models\TendePayCallback;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Controller extends \Illuminate\Routing\Controller
{
    public function handleCallback(Request $request)
    {
//        tendePayLogInfo("ipn: ", [$request]);

        try {
            TendePayCallback::create($request->all());

            // TODO: Fire event
        } catch (QueryException $e) {
            Log::error('Error handling callback. - '.$e->getMessage());
        }
    }
}
