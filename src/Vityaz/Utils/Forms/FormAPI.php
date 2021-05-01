<?php

declare(strict_types = 1);

namespace Vityaz\Utils\Forms;

use pocketmine\plugin\PluginBase;
use Vityaz\Utils\Forms\SimpleForm;

class FormAPI extends PluginBase{

    public function createSimpleForm(?callable $function = null): SimpleForm {
        return new SimpleForm($function);
    }
}
