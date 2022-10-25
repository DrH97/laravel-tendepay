<?php

namespace DrH\TendePay\Events;

use DrH\TendePay\Models\TendePayRequest;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TendePayRequestEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public readonly TendePayRequest $request)
    {
        tendePayLogInfo("TendePayRequestEvent: ", [$request]);
    }
}
