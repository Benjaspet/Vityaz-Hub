<?php

declare(strict_types=1);

namespace Vityaz\Task;

use pocketmine\scheduler\Task;
use Vityaz\Main;

class TimerTask extends Task {

    private $core;

    public function __construct(Main $core) {
        $this->core = $core;
    }

    public function onRun(int $currentTick) {
        foreach ($this->core->getServer()->getOnlinePlayers() as $player) {
            $this->core->getVityazManager()->getScoreboardUtil()->updateScoreboardLines($player);
        }
    }
}
