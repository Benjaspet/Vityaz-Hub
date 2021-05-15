<?php

declare(strict_types=1);

namespace Vityaz\Managers;

use Valiant\Command\FlyCMD;
use Vityaz\Commands\PingCMD;
use Vityaz\Main;

class CommandManager {

    private $core;

    public function __construct(Main $core) {

        $this->core = $core;
        $map = $this->core->getServer()->getCommandMap();
        $map->register("ping", new PingCMD($this->core));
        $map->register("fly", new FlyCMD($this->core));

        $map->unregister($map->getCommand("me"));
        $map->unregister($map->getCommand("w"));
        $map->unregister($map->getCommand("version"));
        $map->unregister($map->getCommand("pl"));
        $map->unregister($map->getCommand("list"));
        $map->unregister($map->getCommand("kill"));
        $map->unregister($map->getCommand("enchant"));
        $map->unregister($map->getCommand("effect"));
        $map->unregister($map->getCommand("defaultgamemode"));
        $map->unregister($map->getCommand("spawnpoint"));
        $map->unregister($map->getCommand("setworldspawn"));
        $map->unregister($map->getCommand("title"));
        $map->unregister($map->getCommand("seed"));
        $map->unregister($map->getCommand("help"));
        $map->unregister($map->getCommand("particle"));
        $map->unregister($map->getCommand("gamemode"));
        $map->unregister($map->getCommand("kick"));
        $map->unregister($map->getCommand("ban"));
        $map->unregister($map->getCommand("banlist"));
        $map->unregister($map->getCommand("ban-ip"));
        $map->unregister($map->getCommand("gamerule"));
        $map->unregister($map->getCommand("multiworld"));
        $map->unregister($map->getCommand("checkperm"));
        $map->unregister($map->getCommand("unban"));
        $map->unregister($map->getCommand("teleport"));
        $map->unregister($map->getCommand("makeplugin"));
        $map->unregister($map->getCommand("genplugin"));
        $map->unregister($map->getCommand("give"));
        $map->unregister($map->getCommand("pardon-ip"));
        $map->unregister($map->getCommand("difficulty"));
        $map->unregister($map->getCommand("extractplugin"));
        $map->unregister($map->getCommand("timings"));

    }
}
