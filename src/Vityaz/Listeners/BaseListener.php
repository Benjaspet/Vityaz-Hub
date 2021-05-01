<?php

declare(strict_types=1);

namespace Vityaz\Listeners;

use pocketmine\block\Anvil;
use pocketmine\block\BrewingStand;
use pocketmine\block\BurningFurnace;
use pocketmine\block\Button;
use pocketmine\block\Chest;
use pocketmine\block\CraftingTable;
use pocketmine\block\Door;
use pocketmine\block\EnchantingTable;
use pocketmine\block\EnderChest;
use pocketmine\block\FenceGate;
use pocketmine\block\Furnace;
use pocketmine\block\IronDoor;
use pocketmine\block\IronTrapdoor;
use pocketmine\block\Lever;
use pocketmine\block\Trapdoor;
use pocketmine\block\TrappedChest;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\LeavesDecayEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\inventory\FurnaceSmeltEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\plugin\PluginDisableEvent;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\item\Bed;
use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\network\mcpe\protocol\DisconnectPacket;
use pocketmine\Player;
use Vityaz\Main;

class BaseListener implements Listener {

    private $core;

    public function __construct(Main $core) {
        $this->core = $core;
    }

    public function onCraft(CraftItemEvent $event) {
        $event->setCancelled(true);
    }

    function onFurnace(FurnaceSmeltEvent $event) {
        $event->setCancelled(true);
    }

    public function onExhaust(PlayerExhaustEvent $event) {
        $cause = $event->getCause();
        $event->setCancelled(true);
    }

    public function onDeathMessage(PlayerDeathEvent $event) {
        $event->setDeathMessage(null);
    }

    public function onDecay(LeavesDecayEvent $event) {
        $event->setCancelled(true);
    }

    public function onDrop(PlayerDropItemEvent $event) {
        $event->setCancelled(true);
    }

    public function onDamage(EntityDamageByEntityEvent $event) {
        if ($event->getEntity() instanceof Player) {
            switch ($event->getCause()) {
                case EntityDamageByEntityEvent::CAUSE_VOID:
                case EntityDamageByEntityEvent::CAUSE_FALL:
                case EntityDamageByEntityEvent::CAUSE_ENTITY_ATTACK:
                    $event->setCancelled(true);
                    break;
            }
        }
    }

    public function onEntityDamage(EntityDamageEvent $event) {
        $entity = $event->getEntity();
        if ($entity instanceof Player) {
            switch ($event->getCause()) {
                case EntityDamageByEntityEvent::CAUSE_FALL:
                case EntityDamageByEntityEvent::CAUSE_ENTITY_ATTACK:
                    $event->setCancelled(true);
                    break;
                case EntityDamageByEntityEvent::CAUSE_VOID:
                    $event->setCancelled(true);
                    $this->teleportToHub($entity);
                    break;
            }
        }
    }

    public function onChat(PlayerChatEvent $event) {
        $player = $event->getPlayer();
        $message = $event->getMessage();
        if ($player instanceof Player) {
            $event->setFormat("§c" . $player->getName() . ":§f " . $message);
        }
    }

    public function onSlotChange(InventoryTransactionEvent $event){
        $event->setCancelled();
    }

    public function nullInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $b = $event->getBlock();
        $i = $event->getItem();
        if ($player instanceof Player) {
            if ($b instanceof Anvil or $b instanceof Bed or $b instanceof BrewingStand or $b instanceof BurningFurnace or $b instanceof Button or $b instanceof Chest or $b instanceof CraftingTable or $b instanceof Door or $b instanceof EnchantingTable or $b instanceof EnderChest or $b instanceof FenceGate or $b instanceof Furnace or $b instanceof IronDoor or $b instanceof IronTrapDoor or $b instanceof Lever or $b instanceof TrapDoor or $b instanceof TrappedChest) {
                $event->setCancelled(true);
            }
        }
    }

    public function onPlace(BlockPlaceEvent $event) {
        if (!$event->getPlayer()->isOp()) {
            $event->getPlayer()->sendPopup("§cYou cannot place blocks.");
            $event->setCancelled(true);
        }
    }

    public function onBreak(BlockBreakEvent $event) {
        if (!$event->getPlayer()->isOp()) {
            $event->getPlayer()->sendPopup("§cYou cannot break blocks.");
            $event->setCancelled(true);
        }
    }

    public function onDisconnectPacket(DataPacketSendEvent $event) {
        $packet = $event->getPacket();
        $player = $event->getPlayer();
        if ($packet instanceof DisconnectPacket and $packet->message === "Internal server error") {
            $packet->message = ("§cYou have encountered a bug.\n§cContact us on Discord: §7https://discord.gg/XjJPgjztK7");
        }
        if ($packet instanceof DisconnectPacket and $packet->message === "Server is white-listed") {
            $packet->message = ("§l§cVityaz §r§cis currently whitelisted.\n§cJoin our Discord: §7https://discord.gg/XjJPgjztK7");
        }
    }

    public function onPluginDisable(PluginDisableEvent $event) {
        $this->core->getServer()->getLogger()->info("Vityaz Hub core disabled.");
    }

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $player->setGamemode(2);
        $player->setFood(20);
        $player->setXpProgress(0);
        $player->setHealth(20);
        $player->setXpLevel(0);
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $player->removeAllEffects();
        $player->setFood(20);
        $event->setJoinMessage("§8[§2+§8] §a" . $player->getName());
        $player->sendMessage("§aWelcome to the Vityaz Network, " . $player->getName() . "!");
        $player->sendTitle("§l§cVityaz", "§7Network", 10, 30, 10);
        $this->teleportToHub($player);
        $this->giveHubItem($player);
        $this->core->getVityazManager()->getScoreboardUtil()->setHubScoreboard($player);
    }

    public function giveHubItem(Player $player) {
        $item = Item::get(Item::COMPASS);
        $item->setCustomName("§r§l§cTransfer");
        $player->getInventory()->setItem(4, $item);
    }

    public function teleportToHub(Player $player) {
        $lobby = $this->core->getServer()->getLevelByName("Hub");
        $pos = new Position(282.5, 74.5, 284.5, $lobby);
        $player->teleport($pos);
    }

    public function handleCompassItem(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $action = $event->getAction();
        $item = $event->getItem();
        if ($action == PlayerInteractEvent::RIGHT_CLICK_AIR) {
            switch($item->getId()) {
                case Item::COMPASS:
                    $this->core->getVityazManager()->getFormUtil()->transferForm($player);
                    break;
            }
        }
    }
}