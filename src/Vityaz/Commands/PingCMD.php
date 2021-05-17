<?php

declare(strict_types=1);

namespace Vityaz\Commands;

use pocketmine\Player;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use Vityaz\Main;

class PingCMD extends PluginCommand {

    private $core;

    public function __construct(Main $core){
        parent::__construct("ping", $core);
        $this->setPermission("vityaz.ping");
        $this->setPermissionMessage("§cYou cannot execute this command.");
        $this->setAliases(["ms"]);
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {

        if (!isset($args[0]) and $sender instanceof Player) {
            $sender->sendMessage("§aYour ping: " . $sender->getPing() . "ms.");
            return true;
        }

        if (!$sender instanceof Player) {
            $sender->sendMessage("§cRun this command as a player.");
            return false;
        }

        if (isset($args[0]) and $target = $this->core->getServer()->getPlayer($args[0]) === null) {
            $sender->sendMessage("§cPlayer not found.");
            return false;
        }

        $target = $this->core->getServer()->getPlayer($args[0]);

        if ($target instanceof Player) {
            $sender->sendMessage("§a" . $target->getName() . "'s ping: " . $target->getPing() . "ms.");
        }
        return true;
    }
}
