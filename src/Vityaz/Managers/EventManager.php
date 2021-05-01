<?php

declare(strict_types=1);

namespace Vityaz\Managers;

use Vityaz\Listeners\BaseListener;
use Vityaz\Listeners\ServerListener;
use Vityaz\Main;

class EventManager {

    private $core;

    public function __construct(Main $core) {

        $this->core = $core;
        $map = $this->core->getServer()->getPluginManager();
        $map->registerEvents(new BaseListener($this->core), $this->core);
        $map->registerEvents(new ServerListener($this->core), $this->core);

    }
}
