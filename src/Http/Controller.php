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
            TendePayCallback::create([
                'initiator_reference' => $request->initiatorReference,
                'response_code' => $request->responseCode,
                'status' => $request->status,
                'status_description' => $request->statusDescription,
                'amount' => $request->amount,
                'account_reference' => $request->account_reference,
                'confirmation_code' => $request->confirmationcode,
                'msisdn' => $request->msisdn,
                'receiver_party_name' => $request->receiverpartyname,
                'date' => $request->date,
            ]);

            // TODO: Fire event
        } catch (QueryException $e) {
            Log::error('Error handling callback. - '.$e->getMessage());
        }
    }
}
