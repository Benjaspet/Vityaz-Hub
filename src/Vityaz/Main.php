<?php

declare(strict_types=1);

namespace Vityaz;

use pocketmine\plugin\PluginBase;
use Vityaz\Managers\VityazManager;

class Main extends PluginBase {

    private $vityaz;

    public function onEnable(): void {

        $this->vityaz = new VityazManager($this);

        $this->getLogger()->info("

		 <-- Vityaz enabled. -->

		");
    }

    public function getVityazManager(): VityazManager {
        return $this->vityaz;
    }
}