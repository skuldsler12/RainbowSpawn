<?php

namespace Skuld;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TE;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Main extends PluginBase implements Listener {

    public $usrActv = 0;

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getLogger()->info("¡RainbowSpawn Cargado!");
        $this->Data = new Config($this->getDataFolder() . "vips.json", Config::JSON);
    }

    public function onPlayerLogin(PlayerLoginEvent $event) {
        $player = $event->getPlayer();
        $playername = $player->getName();
        
        if($this->checkData($playername)) {
            $rank = $this->getRank($playername);
            $player->setNameTag(TE::GRAY."[".TE::GOLD.$rank.TE::GRAY."]".TE::AQUA.$playername);
            $player->addAttachment($this, "test.command");
            $player->teleport($this->getServer()->getDefaultLevel()->getSafeSpawn());
        }else{

            $online = count($this->getServer()->getOnlinePlayers());
            if ($online < $this->usrActv || $this->getLootVip($username)) {
                self::$usrActv++;
            }else{
                $event->getPlayer()->kick(TE::YELLOW."Servidor completo...",true,"Vuelva a intentarlo...");
                $event->setCancelled();
            }
        }
    }

    public function checkData($username) {
        return $this->Data->exists($username);
    }

    public function getRank($username) {
        return $this->Data->get($username);
    }

    public function setRank($username, $rank) {
        $this->Data->set($username, $rank);
        $this->Data->save();
    }

    public function getLootVip($username) {
        //your code for loot vip or no vip player. RETURN IN BOOL!!
        return true || false; //modify
    }

    public function onPlayerQuit(PlayerQuitEvent $event) {
        self::$usrActv--;
    }

    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) : bool {
        switch ($cmd->getName()) {
            case 'vip':
            if ($args[0] == 'add') {
                # code...
            }
        }
    }

}
