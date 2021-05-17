<?php

declare(strict_types=1);

namespace Vityaz\Utils;

use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\Player;
use Vityaz\Main;

class ScoreboardUtil {

    private $core;

    public function __construct(Main $core) {
        $this->core = $core;
    }

    public function setHubScoreboard(Player $player, string $title = "Vityaz"): void {
        $totalCount = $this->core->getVityazManager()->getQueryUtil()->getTotalNetworkCount();
        $practiceCount = $this->core->getVityazManager()->getQueryUtil()->getHubCountAsInteger();
        $this->lineTitle($player, "§c§l" . $title);
        $this->lineCreate($player, 0, str_repeat("§7  ", 12));
        $this->lineCreate($player, 1, "§cNetwork: §f" . $totalCount);
        $this->lineCreate($player, 2, "§cPractice: §f" . $practiceCount);
        $this->lineCreate($player, 3, str_repeat(" ", 2));
        $this->lineCreate($player, 4, "§cPing: §f" . $player->getPing() . "ms");
        $this->lineCreate($player, 5, str_repeat("  ", 12));
        $this->lineCreate($player, 6, "§cvityaz.tk");
    }

    public function updateScoreboardLines(Player $player) {
        $totalCount = $this->core->getVityazManager()->getQueryUtil()->getTotalNetworkCount();
        $practiceCount = $this->core->getVityazManager()->getQueryUtil()->getHubCountAsInteger();
        $this->lineRemove($player, 1);
        $this->lineRemove($player, 2);
        $this->lineRemove($player, 4);
        $this->lineCreate($player, 1, "§cNetwork: §f" . $totalCount);
        $this->lineCreate($player, 2, "§cPractice: §f" . $practiceCount);
        $this->lineCreate($player, 4, "§cPing: §f" . $player->getPing() . "ms");
    }

    public function lineTitle(Player $player, string $title){
        $packet = new SetDisplayObjectivePacket();
        $packet->displaySlot = "sidebar";
        $packet->objectiveName = "objective";
        $packet->displayName = $title;
        $packet->criteriaName = "dummy";
        $packet->sortOrder = 0;
        $player->sendDataPacket($packet);
    }

    public function removeScoreboard(Player $player){
        $packet = new RemoveObjectivePacket();
        $packet->objectiveName = "objective";
        $player->sendDataPacket($packet);
    }

    public function lineCreate(Player $player, int $line, string $content){
        $packetline = new ScorePacketEntry();
        $packetline->objectiveName = "objective";
        $packetline->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
        $packetline->customName = " ". $content . "   ";
        $packetline->score = $line;
        $packetline->scoreboardId = $line;
        $packet = new SetScorePacket();
        $packet->type = SetScorePacket::TYPE_CHANGE;
        $packet->entries[] = $packetline;
        $player->sendDataPacket($packet);
    }

    public function lineRemove(Player $player, int $line){
        $entry = new ScorePacketEntry();
        $entry->objectiveName="objective";
        $entry->score = $line;
        $entry->scoreboardId = $line;
        $packet = new SetScorePacket();
        $packet->type = SetScorePacket::TYPE_REMOVE;
        $packet->entries[] = $entry;
        $player->sendDataPacket($packet);
    }
}
