<?php

/*
*
*ooooo                          .             ooooooooo.                                                 
*`888'                        .o8             `888   `Y88.                                               
* 888  ooo. .oo.    .oooo.o .o888oo  .oooo.    888   .d88'  .ooooo.  oooo d8b ooo. .oo.  .oo.    .oooo.o 
* 888  `888P"Y88b  d88(  "8   888   `P  )88b   888ooo88P'  d88' `88b `888""8P `888P"Y88bP"Y88b  d88(  "8 
* 888   888   888  `"Y88b.    888    .oP"888   888         888ooo888  888      888   888   888  `"Y88b.  
* 888   888   888  o.  )88b   888 . d8(  888   888         888    .o  888      888   888   888  o.  )88b 
*o888o o888o o888o 8""888P'   "888" `Y888""8o o888o        `Y8bod8P' d888b    o888o o888o o888o 8""888P' 
* 
* The instant permissions manager that really is instant!
*
* @author BoxOfDevs Team
* @link http://boxofdevs.x10host.com/
* 
*/

namespace InstaPerms;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;
use pocketmine\command\PluginCommand;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\permission\Permission;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\IPlayer;
use pocketmine\Server;
use pocketmine\event\player\PlayerCommandPreprocessEvent;

class Main extends PluginBase implements CommandExecutor{
    
    const PREFIX = TF::BLACK."[".TF::AQUA."InstaPerms".TF::BLACK."] ";
    const AUTHOR = "BoxOfDevs Team";
    const VERSION = "1.0";
    const WEBSITE = "http://boxofdevs.x10host.com/software/instaperm";
    
    public function onEnable(){
        $this->getLogger()->info(self::PREFIX . TF::GREEN . "Enabled!");
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array$args){
        switch($cmd){
            case "setperm":
            if(!isset($args[1])){
                $sender->sendMessage(self::PREFIX . TF::DARK_RED . "Usage: /setperm <player> <permission>");
            }else{
                $playername = $args[0];
                $player = $this->getServer()->getPlayer($playername);
                $perm = Server::getInstance()->getPluginManager()->getPermission($args[1]);
                $player->addAttachment($this, $perm, true);
                $sender->sendMessage(self::PREFIX . TF::GREEN. $perm . " successfully set to " . $playername . "!");
            }
            return true;
            break;
            case "rmperm":
            if(!isset($args[1])){
                $sender->sendMessage(self::PREFIX . TF::DARK_RED . "Usage: /rmperm <player> <permission>");
            }else{
                $playername = $args[0];
                $player = $this->getServer()->getPlayer($playername);
                $perm = Server::getInstance()->getPluginManager()->getPermission($args[1]);
                $player->removeAttachment($this, $perm, true);
                $sender->sendMessage(self::PREFIX . TF::GREEN. $perm . " removed from " . $playername . "!");
            }
            return true;
            break;
            case "seeperms":
            if(!isset($args[0])){
                $sender->sendMessage(self::PREFIX . TF::DARK_RED . "Usage: /seeperms <player>");
            }else{
                $playername = $args[0];
                $player = $this->getServer()->getPlayer($playername);
                $perms = $player->getEffectivePermissions();
                $plperms = [];
                foreach($perms as $perm) {
                    array_push($plperms, $perm->getPermission());
	        }
	        $sender->sendMessage(self::PREFIX . TF::GOLD . $playername . "'s permissions: \n" . TF::AQUA . implode(", ", $plperms));
            }
            return true;
            break;
            case "hasperm":
            if(!isset($args[1])){
                $sender->sendMessage(self::PREFIX . TF::DARK_RED . "Usage: /hasperm <player> <permission>");
            }else{
                $playername = $args[0];
                $player = $this->getServer()->getPlayer($playername);
                $perm = $args[1];
                if($player->hasPermission($perm)){
                    $sender->sendMessage(self::PREFIX . TF::AQUA . $playername . " has permission " . $perm . "!");
                }else{
                    $sender->sendMessage(self::PREFIX . TF::AQUA . $playername . " doesn't have permission " . $perm . "!");
                }
            }
            return true;
            break;
        }
    return true;
    }

    public function getPrefix(){
        return self::PREFIX;
    }

    public function getAuthor(){
        return self::AUTHOR;
    }

    public function getVersion(){
        return self::VERSION;
    }

    public function getWebsite(){
        return self::WEBSITE;
    }

    public function onDisable(){
        $this->getLogger()->info(self::PREFIX . TF::DARK_RED . "Disabled!");
    }

}

?>
