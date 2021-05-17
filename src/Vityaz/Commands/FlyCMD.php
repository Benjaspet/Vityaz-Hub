<?php

declare(strict_types=1);

namespace Valiant\Command;

use pocketmine\Player;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use Vityaz\Main;

class FlyCMD extends PluginCommand {

    private $core;

    public function __construct(Main $core){
        parent::__construct("fly", $core);
        $this->setPermission("vityaz.fly");
        $this->setPermissionMessage("§cYou cannot execute this command.");
        $this->setAliases([]);
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {


        if (!$this->testPermission($sender)) {
            $sender->sendMessage($this->getPermissionMessage());
            return false;
        }

        if ($sender instanceof Player) {
            if ($sender->getAllowFlight() === false){
                $sender->setFlying(true);
                $sender->setAllowFlight(true);
                $sender->sendMessage("§aYou enabled flight.");
            } else {
                $sender->setFlying(false);
                $sender->setAllowFlight(false);
                $sender->sendMessage("§aYou disabled flight.");
            }
        }
        return true;
    }
}
