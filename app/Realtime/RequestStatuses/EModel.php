<?php

declare(strict_types=1);

namespace App\Realtime\RequestStatuses;

trait EModel
{
    public static string $roomName = 'request_statuses';

    /**
     * @return string
     */
    public function event(): string
    {
        return 'request_statuses';
    }
}
