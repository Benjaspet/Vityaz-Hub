<?php

declare(strict_types=1);

namespace Vityaz\Utils;

use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\Player;
use Vityaz\Main;
use Vityaz\Task\Async\ProxyTask;

class PlayerUtil {

    private $core;

    public function __construct(Main $core) {
        $this->core = $core;
    }

    public function initPlayerJoin(Player $player) {
        $player->setGamemode(2);
        $player->setFood(20);
        $player->setXpProgress(0);
        $player->setHealth(20);
        $player->setXpLevel(0);
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $player->removeAllEffects();
        $player->setFood(20);
        $player->sendMessage("§aWelcome to the Vityaz Network, " . $player->getName() . "!");
        $player->sendTitle("§l§cVityaz", "§7Network", 10, 30, 10);
        $this->teleportToHub($player);
        $this->giveHubItem($player);
        $this->core->getVityazManager()->getScoreboardUtil()->setHubScoreboard($player);
        $this->core->getServer()->getAsyncPool()->submitTask(new ProxyTask($player->getName(), $player->getAddress()));
    }

    public function giveHubItem(Player $player) {
        $item = Item::get(Item::COMPASS);
        $item->setCustomName("§r§l§cTransfer");
        $player->getInventory()->setItem(4, $item);
    }

    public function teleportToHub(Player $player) {
        $lobby = $this->core->getServer()->getLevelByName("Hub");
        $pos = new Position(282.5, 74.5, 284.5, $lobby);
        $player->teleport($pos);
    }
}
