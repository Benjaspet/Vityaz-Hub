<?php

declare(strict_types=1);

namespace Vityaz\Managers;

use Vityaz\Main;

class CountManager {

    public $cachedPlayers;
    public $count;

    public function __construct(Main $core) {
        $this->cachedPlayers = 0;
    }

    public function getCachedPlayers(): int {
        return $this->cachedPlayers;
    }

    public function setCachedPlayers(int $cachedPlayers): void {
        $this->cachedPlayers = $cachedPlayers;
    }
}
