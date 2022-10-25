<?php

namespace DrH\TendePay\Events;

use DrH\TendePay\Models\TendePayCallback;
use DrH\TendePay\Models\TendePayRequest;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TendePayRequestSuccessEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public readonly TendePayRequest $request, public readonly TendePayCallback $callback)
    {
        tendePayLogInfo("TendePayRequestSuccessEvent: ", [$request, $callback]);
    }
}
