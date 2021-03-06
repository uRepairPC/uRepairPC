<?php

declare(strict_types=1);

namespace App\Realtime\RequestComments;

use App\Realtime\Common\EJoinBroadcast;

class EJoin extends EJoinBroadcast
{
    use EModel;

    public function __construct(int $requestId, ...$items)
    {
        $rooms = [];

        foreach ($items as $item) {
            $rooms[] = self::$roomName.".{$requestId}.{$item->id}";
        }

        parent::__construct($rooms, false);
    }
}
