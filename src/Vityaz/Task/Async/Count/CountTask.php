<?php

declare(strict_types=1);

namespace Vityaz\Task\Async\Count;

use pocketmine\scheduler\Task;
use Vityaz\Main;

class CountTask extends Task {

    private $core;

    public function __construct(Main $core) {
        $this->core = $core;
    }

    public function onRun(int $currentTick): void {
        new AsyncCountTask($this->core);
    }
}