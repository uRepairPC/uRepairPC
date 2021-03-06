<?php

declare(strict_types=1);

namespace App\Realtime\EquipmentTypes;

use App\Enums\Perm;
use App\Realtime\Common\EJoinBroadcast;

class EGlobal extends EJoinBroadcast
{
    use EModel;

    public function __construct()
    {
        parent::__construct(self::getRooms(), false);
    }

    /**
     * @return array
     */
    public static function getRooms(): array
    {
        if (perm(Perm::EQUIPMENTS_CONFIG_VIEW_ALL)) {
            return [self::$roomName];
        }

        return [];
    }
}
