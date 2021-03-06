<?php

declare(strict_types=1);

namespace App\Realtime\Equipments;

use App\Realtime\Common\ECreateBroadcast;

class ECreate extends ECreateBroadcast
{
    use EModel;

    /**
     * @return array
     */
    public function rooms(): array
    {
        return [
            self::$roomName,
            self::$roomName." [user_id.{$this->data['user_id']}]",
        ];
    }

    /**
     * @return array
     */
    public function join(): array
    {
        return [
            self::$roomName.".{$this->data['id']}",
        ];
    }
}
