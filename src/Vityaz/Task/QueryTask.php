<?php

declare(strict_types=1);

namespace Vityaz\Task;

use pocketmine\scheduler\Task;
use Vityaz\Main;
use Vityaz\Task\Async\QueryUpdateTask;

class QueryTask extends Task {

    private $core;

    public function __construct(Main $core) {
        $this->core = $core;
    }

    public function onRun(int $currentTick) {
        $this->core->setCachedPlayers($this->core->getVityazManager()->getQueryUtil()->getTotalNetworkCount());
    }
}
