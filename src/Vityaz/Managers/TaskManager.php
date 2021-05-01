<?php

declare(strict_types=1);

namespace Vityaz\Managers;

use Vityaz\Main;
use Vityaz\Task\QueryTask;
use Vityaz\Task\TimerTask;

class TaskManager {

    private $core;
    public $task;

    public function __construct(Main $core) {

        $this->core = $core;
        $this->initTasks();

    }

    public function initTasks() {
        $this->core->getScheduler()->scheduleRepeatingTask(new QueryTask($this->core), 100);
        $this->core->getScheduler()->scheduleRepeatingTask(new TimerTask($this->core), 20);
    }
}
