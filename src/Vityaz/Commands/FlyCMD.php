<?php

declare(strict_types=1);

namespace Valiant\Command;

use pocketmine\Player;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use Vityaz\Main;

class FlyCMD extends PluginCommand {

    private $plugin;

    public function __construct(Main $plugin){
        parent::__construct("fly", $plugin);
        $this->plugin=$plugin;
        $this->setPermission("valiant.fly");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {

        if (!$sender->hasPermission("vityaz.fly")){
            $sender->sendMessage("§cYou cannot execute this command.");
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
