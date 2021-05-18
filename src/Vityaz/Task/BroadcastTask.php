<?php

declare(strict_types=1);

namespace Vityaz\Task;

use pocketmine\scheduler\Task;
use Vityaz\Main;

class BroadcastTask extends Task {

    private $core;
    private $time = 0;

    public function __construct(Main $core) {
        $this->core = $core;
    }

    public function onRun(int $currentTick): void {
        $this->time++;
        switch ($this->time) {
            case 90:
                $this->core->getServer()->broadcastMessage("§7Thank you for playing on the Vityaz Network!");
                break;
            case 180:
                $this->core->getServer()->broadcastMessage("§7Is someone cheating on the server, and no staff are online? Send a report using §l/report {player}§r§7.");
                break;
            case 270:
                $this->core->getServer()->broadcastMessage("§7Want to apply for staff? Join our Discord: §lhttps://dsc.gg/ponjodev§r§7.");
                break;
            case 360:
                $this->core->getServer()->broadcastMessage("§7You can purchase a rank on our store to receive cool perks and cosmetics.");
                break;
            case 450:
                $this->core->getServer()->broadcastMessage("§7For monthly giveaways, prizes, and events, join our Discord: §lhttps://dsc.gg/ponjodev§r§7.");
                $this->time = 0;
                break;
        }
    }
}