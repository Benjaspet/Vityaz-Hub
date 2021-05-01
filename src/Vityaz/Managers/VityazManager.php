<?php

declare(strict_types=1);

namespace Vityaz\Managers;

use Vityaz\Main;
use Vityaz\Utils\Forms\Form;
use Vityaz\Utils\FormUtil;
use Vityaz\Utils\QueryUtil;
use Vityaz\Utils\ScoreboardUtil;

class VityazManager {

    private $core;
    private $query;
    private $scoreboard;
    private $forms;

    public function __construct(Main $core) {

        $this->core = $core;
        $this->core->getServer()->getNetwork()->setName("§cVityaz§r");

        $this->query = new QueryUtil($this->core);
        $this->scoreboard = new ScoreboardUtil($this->core);
        $this->forms = new FormUtil($this->core);

        new CommandManager($this->core);
        new TaskManager($this->core);
        new EventManager($this->core);

        foreach(array_diff(scandir($this->core->getServer()->getDataPath() . "worlds"), ["..", "."]) as $levelName){
            if($this->core->getServer()->loadLevel($levelName)){
                $level = $this->core->getServer()->getLevelByName($levelName);
                $this->core->getLogger()->debug("Loaded level §6${levelName}.");
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
}
