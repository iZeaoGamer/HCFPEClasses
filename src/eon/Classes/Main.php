<?php
namespace eon\Classes;

use pocketmine\entity\EffectInstance;
use pocketmine\entity\Effect;
use pocketmine\event\entity\EntityArmorChangeEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\PluginTask;

class Main extends PluginBase implements Listener {
	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	public function onArmourChange(EntityArmorChangeEvent $ev) {
		$entity = $ev->getEntity();
		if($entity instanceof Player) {
			$this->getServer()->getScheduler()->scheduleDelayedTask(new class($this, $entity->getName()) extends PluginTask {
				public function __construct(Plugin $owner, string $player) {
					parent::__construct($owner);
					$this->player = $player;
				}

				public function onRun(int $currentTick) {
					/** @var Player|null $entity */
					$entity = $this->getOwner()->getServer()->getPlayer($this->player);
					if(count($entity->getArmorInventory()->getContents()) === 4) {
						/** @var Item[] $slots */
						$slots = $entity->getArmorInventory()->getContents();
						if(
							$slots[0]->getId() === Item::LEATHER_HELMET and
							$slots[1]->getId() === Item::LEATHER_CHESTPLATE and
							$slots[2]->getId() === Item::LEATHER_LEGGINGS and
							$slots[3]->getId() === Item::LEATHER_BOOTS
						) {
							$entity->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 3, INT32_MAX));
							$entity->addEffect(new EffectInstance(Effect::getEffect(Effect::DAMAGE_RESISTANCE), INT32_MAX));
							return;
						}
						if(
							$slots[0]->getId() === Item::IRON_HELMET and
							$slots[1]->getId() === Item::IRON_CHESTPLATE and
							$slots[2]->getId() === Item::IRON_LEGGINGS and
							$slots[3]->getId() === Item::IRON_BOOTS
						) {
							$entity->addEffect(new EffectInstance(Effect::getEffect(Effect::NIGHT_VISION), INT32_MAX));
							$entity->addEffect(new EffectInstance(Effect::getEffect(Effect::FIRE_RESISTANCE), INT32_MAX));
							$entity->addEffect(new EffectInstance(Effect::getEffect(Effect::HASTE), 2, INT32_MAX));
							return;
						}
						if(
							$slots[0]->getId() === Item::GOLD_HELMET and
							$slots[1]->getId() === Item::GOLD_CHESTPLATE and
							$slots[2]->getId() === Item::GOLD_LEGGINGS and
							$slots[3]->getId() === Item::GOLD_BOOTS
						) {
							$entity->addEffect(new EffectInstance(Effect::getEffect(Effect::REGENERATION), 1, INT32_MAX));
							$entity->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 1, INT32_MAX));
							return;
						}
						if(
							$slots[0]->getId() === Item::CHAIN_HELMET and
							$slots[1]->getId() === Item::CHAIN_CHESTPLATE and
							$slots[2]->getId() === Item::CHAIN_LEGGINGS and
							$slots[3]->getId() === Item::CHAIN_BOOTS
						) {
							$entity->addEffect(new EffectInstance(Effect::getEffect(Effect::JUMP), 1, INT32_MAX));
							$entity->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 2, INT32_MAX));
							$entity->addEffect(new EffectInstance(Effect::getEffect(Effect::STRENGTH), INT32_MAX));
							return;
						}
						$entity->removeAllEffects();
					}
				}
			}, 5); // Plugin by @EonIsDead [ https://github.com/ItsEonPE/HCFPEClasses ]
		}
	}
}
