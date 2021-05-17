<?php

declare(strict_types=1);

namespace Vityaz\Task\Async\Selector;

use pocketmine\scheduler\Task;
use Vityaz\Main;

class SelectorTask extends Task {

    private $core;

    public function __construct(Main $core) {
        $this->core = $core;
    }

    public function onRun(int $currentTick): void {
        new AsyncSelectorTask($this->core);
    }
}
