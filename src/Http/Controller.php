<?php

namespace DrH\TendePay\Http;

use DrH\TendePay\Events\TendePayRequestFailedEvent;
use DrH\TendePay\Events\TendePayRequestSuccessEvent;
use DrH\TendePay\Models\TendePayCallback;
use DrH\TendePay\Models\TendePayRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Controller extends \Illuminate\Routing\Controller
{
    public function handleCallback(Request $request)
    {
        tendePayLogInfo("ipn: ", [$request]);

        // TODO: Should we separate handling of Non-Existent request,
        //  duplicate callback and catch-all Exceptions separately?
        try {
            //Check that there exists a related request
            $tendePayRequest = TendePayRequest::whereTransactionReference($request->initiatorReference)->firstOrFail();

            $callback = TendePayCallback::create([
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

            $event = $callback->status == 1 ?
                new TendePayRequestSuccessEvent($tendePayRequest, $callback) :
                new TendePayRequestFailedEvent($tendePayRequest, $callback);

            event($event);
        } catch (Exception $e) {
            Log::error('Error handling callback. - '.$e->getMessage());
        }

        return response()->json(['status' => true]);
    }
}
