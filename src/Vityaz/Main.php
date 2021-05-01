<?php

declare(strict_types=1);

namespace Vityaz;

use pocketmine\plugin\PluginBase;
use Vityaz\Managers\VityazManager;

class Main extends PluginBase {

    private $vityaz;

    public $cachedPlayers;
    public $cachedMaxPlayers;

    public function onEnable(): void {

        $this->vityaz = new VityazManager($this);
        $this->cachedPlayers = 0;
        $this->cachedMaxPlayers = 0;

        $this->getLogger()->info("

		 <-- Vityaz enabled. -->

		");
    }

    public static function getInstance(): self {
        return self::getInstance();
    }

    public function getCachedPlayers(): int {
        return $this->cachedPlayers;
    }

    public function setCachedPlayers(int $cachedPlayers): void {
        $this->cachedPlayers = $cachedPlayers;
    }

    public function getVityazManager(): VityazManager {
        return $this->vityaz;
    }
}
