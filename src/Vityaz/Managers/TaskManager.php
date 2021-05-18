<?php

declare(strict_types=1);

namespace Vityaz\Managers;

use Vityaz\Main;
use Vityaz\Task\Async\Count\CountTask;
use Vityaz\Task\Async\Selector\SelectorTask;
use Vityaz\Task\BroadcastTask;
use Vityaz\Task\ScoreboardTask;

class TaskManager {

    private $core;
    public $task;

    public function __construct(Main $core) {
        $this->core = $core;
        $this->initTasks();
    }

    public function initTasks() {
        $this->core->getScheduler()->scheduleRepeatingTask(new CountTask($this->core), 15 * 20);
        $this->core->getScheduler()->scheduleRepeatingTask(new SelectorTask($this->core), 15 * 20);
        $this->core->getScheduler()->scheduleRepeatingTask(new ScoreboardTask($this->core), 20);
        $this->core->getScheduler()->scheduleRepeatingTask(new BroadcastTask($this->core), 20);
    }
}
