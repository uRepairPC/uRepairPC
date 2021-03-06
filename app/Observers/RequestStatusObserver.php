<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\RequestStatus;
use App\Realtime\RequestStatuses\EDelete;

class RequestStatusObserver
{
    /**
     * Handle the request status "deleted" event.
     *
     * @param  RequestStatus  $requestStatus
     * @return void
     */
    public function deleted(RequestStatus $requestStatus): void
    {
        EDelete::dispatchAfterResponse($requestStatus);
    }
}
