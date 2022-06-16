<?php 

/* Copyright 2022-2022 FlynnKunz and fernanACM

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
*/

namespace FlynnKunz\StaffMenuUI;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;
# Libs
use muqsit\invmenu\InvMenuHandler;
use muqsit\simplepackethandler\SimplePacketHandler;
use Vecnavium\FormsUI\FormsUI;
use CortexPE\Commando\PacketHooker;
use CortexPE\Commando\BaseCommand;

# PluginUtils by fernanACM
use FlynnKunz\StaffMenuUI\utils\PluginUtils;
# My files
use FlynnKunz\StaffMenuUI\forms\StaffUI;
use FlynnKunz\StaffMenuUI\forms\subforms\InvForm;
use FlynnKunz\StaffMenuUI\forms\subforms\VanishForm;
use FlynnKunz\StaffMenuUI\forms\subforms\GamemodeForm;
use FlynnKunz\StaffMenuUI\forms\subforms\Freeze;

# NickUI | Depend by fernanACM
use fernanACM\NickUI\Loader;

class Main extends PluginBase{
  
    public static $instance;
    public Config $messages;
    public Config $config;
  
    public function onEnable(): void{
          self::$instance = $this;
          $this->saveDefaultConfig();
          $this->saveResource("messages.yml");
          $this->saveResource("config.yml");
          $this->config = new Config($this->getDatafolder() . "config.yml");
          $this->messages = new Config($this->getDatafolder() . "messages.yml");
	  $this->loadEvents();
	  foreach ([
		"FormsUI" => FormsUI::class,
                "InvMenu" => InvMenuHandler::class,
                "Commando" => BaseCommand::class,
                "SimplePacketHandler" => SimplePacketHandler::class
            ] as $virion => $class
        ) {
            if (!class_exists($class)) {
                $this->getLogger()->error($virion . " virion not found. Please download EnderChest from Poggit-CI or use DEVirion (not recommended).");
                $this->getServer()->getPluginManager()->disablePlugin($this);
                return;
            }
        }
        # InvMenu
        if (!InvMenuHandler::isRegistered()) {
            InvMenuHandler::register($this);
        }
        #Commando
        if (!PacketHooker::isRegistered()) {
            PacketHooker::register($this);
        }
    }
    
    public function loadEvents(){
          # StaffModeUI Forms
          $this->menu = new StaffUI($this);
          $this->vanish = new VanishForm($this);
          $this->gamemode = new GamemodeForm($this);
          $this->nickui = new Nick($this);
          $this->freeze = new FreezeForm($this);
          $this->invsee = new InvForm($this);
    }
	
    public static function getInstance(): Main{
        return self::$instance;
    }
}
