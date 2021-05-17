<?php

declare(strict_types=1);

namespace Vityaz\Managers;

use Vityaz\Main;
use Vityaz\Utils\Data\MasterConfig;
use Vityaz\Utils\Forms\Form;
use Vityaz\Utils\FormUtil;
use Vityaz\Utils\PlayerUtil;
use Vityaz\Utils\QueryUtil;
use Vityaz\Utils\ScoreboardUtil;

class VityazManager {

    private $core;
    private $query;
    private $scoreboard;
    private $forms;
    private $config;
    private $counter;
    private $player;

    public function __construct(Main $core) {

        $this->core = $core;
        $this->core->getServer()->getNetwork()->setName("§cVityaz§r");

        $this->query = new QueryUtil($this->core);
        $this->scoreboard = new ScoreboardUtil($this->core);
        $this->forms = new FormUtil($this->core);
        $this->player = new PlayerUtil($this->core);
        $this->config = new MasterConfig($this->core);
        $this->counter = new CountManager($this->core);

        new CommandManager($this->core);
        new TaskManager($this->core);
        new EventManager($this->core);

        foreach (array_diff(scandir($this->core->getServer()->getDataPath() . "worlds"), ["..", "."]) as $levelName){
            if($this->core->getServer()->loadLevel($levelName)){
                $level = $this->core->getServer()->getLevelByName($levelName);
                $this->core->getLogger()->info("Loaded level §6${levelName}.");
                $level->setTime(4000);
                $level->stopTime();
            }
        }
    }

    public function getQueryUtil(): QueryUtil {
        return $this->query;
    }

    public function getScoreboardUtil(): ScoreboardUtil {
        return $this->scoreboard;
    }

    public function getFormUtil(): FormUtil {
        return $this->forms;
    }

    public function getPlayerUtil(): PlayerUtil {
        return $this->player;
    }

    public function getMasterConfig(): MasterConfig {
        return $this->config;
    }

    public function getPlayerCountManager(): CountManager {
        return $this->counter;
    }
}