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

namespace FlynnKunz\StaffMenuUI\forms\subforms;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\player\GameMode;

use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\item\ItemFactory;

use Vecnavium\FormsUI\CustomForm;

use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\type\InvMenuTypeIds;
use muqsit\invmenu\InvMenu;

use FlynnKunz\StaffMenuUI\Main;
use FlynnKunz\StaffMenuUI\utils\PluginUtils;

class InvForm{
    
    public function InvseeForm(Player $player){
        $playerlist = Main::getInstance()->getOnlinePlayersName();
        $form = new CustomForm(function(Player $player, $data) use ($playerlist){
            if($data !== null){
               if(count($playerlist) == 0){
                 $player->sendMessage(Main::getInstance()->messages->getNested("Messages.InvForm.player-not-found"));
               }
               if(Server::getInstance()->getPlayerExact($playerlist[$data["name"]]) === null){
                 $player->sendMessage(Main::getInstance()->messages->getNested("Messages.InvForm.player-not-found"));
                 return true;
               }else{
                 $targetname = $playerlist[$data["name"]];
               }
               $target = Server::getInstance()->getPlayerExact($targetname);
               $menu = InvMenu::create(InvMenuTypeIds::TYPE_DOUBLE_CHEST);
               $menu->setListener(InvMenu::readonly());
               # Inventory owner name
               $message = Main::getInstance()->messages->getNested("InvSee.name");
			         $menu->setName(str_replace(["{PLAYER-NAME}"], [$targetname], $message));
               
               $menu->getInventory()->setContents($target->getInventory()->getContents());
               for($i = 36; $i < 54; $i++){
                  switch($i){
                      case 36:
                          $item = ItemFactory::getInstance()->get(ItemIds::SIGN, 1, 1);
						              $item->setCustomName(Main::getInstance()->messages->getNested("InvSee.Armor.boots"));
						              $menu->getInventory()->setItem($i, $item);
                      break;
                      
                      case 45:
						              $menu->getInventory()->setItem($i, $target->getArmorInventory()->getBoots() ?? ItemFactory::getInstance()->get(ItemIds::AIR));
						          break;

					            case 37:
					              	$item = ItemFactory::getInstance()->get(ItemIds::SIGN, 1, 1);
						              $item->setCustomName(Main::getInstance()->messages->getNested("InvSee.Armor.leggings"));
						              $menu->getInventory()->setItem($i, $item);
						          break;
                      
					            case 46:
						              $menu->getInventory()->setItem($i, $target->getArmorInventory()->getLeggings() ?? ItemFactory::getInstance()->get(ItemIds::AIR));
					          	break;

					            case 38:
						              $item = ItemFactory::getInstance()->get(ItemIds::SIGN, 1, 1);
						              $item->setCustomName(Main::getInstance()->messages->getNested("InvSee.Armor.chestplate"));
						              $menu->getInventory()->setItem($i, $item);
						          break;
                      
					            case 47:
					              	$menu->getInventory()->setItem($i, $target->getArmorInventory()->getChestplate() ?? ItemFactory::getInstance()->get(ItemIds:AIR));
						          break;

					            case 39:
						              $item = ItemFactory::getInstance()->get(ItemIds::SIGN, 1, 1);
						              $item->setCustomName(Main::getInstance()->messages->getNested("InvSee.Armor.helmet"));
						              $menu->getInventory()->setItem($i, $item);
						          break;
                      
					            case 48:
					              	$menu->getInventory()->setItem($i, $target->getArmorInventory()->getHelmet() ?? ItemFactory::getInstance()->get(ItemIds::AIR));
						          break;

					            case 41:
					              	$item = ItemFactory::getInstance()->get(ItemIds::SIGN, 1, 1);
						              $item->setCustomName(Main::getInstance()->messages->getNested("InvSee.Utils.health"));
						              $menu->getInventory()->setItem($i, $item);
					          	break;
                      
					            case 50:
						             $item = ItemFactory::getInstance()->get(ItemIds::GOLDEN_APPLE, 1, 1);
						             $item->setCustomName("§2".$target->getHealth()."/".$target->getMaxHealth());
						             $menu->getInventory()->setItem($i, $item);
						          break;

					            case 42:
						              $item = ItemFactory::getInstance()->get(ItemIds::SIGN, 1, 1);
						              $item->setCustomName(Main::getInstance()->messages->getNested("InvSee.Utils.hunger"));
						              $menu->getInventory()->setItem($i, $item);
						          break;
                      
					            case 51:
						              $item = ItemFactory::getInstance()->get(ItemIds::COOKED_BEEF, 1, 1);
					              	$item->setCustomName("§2".$target->getHungerManager()->getFood()."/".$target->getHungerManager()->getMaxFood());
						              $menu->getInventory()->setItem($i, $item);
						           break;

					             case 43:
					              	$item = ItemFactory::getInstance()->get(ItemIds::SIGN, 1, 1);
						              $item->setCustomName(Main::getInstance()->messages->getNested("InvSee.Utils.gamemode"));
						              $menu->getInventory()->setItem($i, $item);
						           break;
                       
					             case 52:
						              if($target->getGamemode() == SURVIVAL()){
							              $gamemode = "Survival";
						              }elseif($target->getGamemode() == CREATIVE()){
							              $gamemode = "Creative";
						              }elseif($target->getGamemode() == ADVENTURE()){
							              $gamemode = "Adventure";
						              }elseif($target->getGamemode() == SPECTATOR()){
							              $gamemode = "Spectator";
						              }
						              $item = ItemFactory::getInstance()->get(ItemIds::BEDROCK, 1, 1);
						              $item->setCustomName("§2".$gamemode);
						              $menu->getInventory()->setItem($i, $item);
						           break;

					             case 44:
						               $item = ItemFactory::getInstance()->get(ItemIds::SIGN, 1, 1);
						               $item->setCustomName(Main::getInstance()->messages->getNested("InvSee.Utils.ping"));
						               $menu->getInventory()->setItem($i, $item);
						           break;
                        
					             case 53:
					                 $item = ItemFactory::getInstance()->get(ItemIds::DAYLIGHT_SENSOR, 1, 1);
						               $item->setCustomName("§2".$target->getNetworkSession()->getPing()."ms");
						               $menu->getInventory()->setItem($i, $item);
						           break;
                       
                       default:
						           break;
                  }
               }
               $menu->send($player);
			         return true;
            }
        });
        $form->setTitle(Main::getInstance()->messages->getNested("Forms.Invsee.title"));
		    $form->addDropdown(Main::getInstance()->messages->getNested("Forms.Invsee.content"), $playernamelist, null, Main::getInstance()->messages->getNested("Forms.Invsee.subcontent"));
		    $player->sendForm($form);
    }
}
