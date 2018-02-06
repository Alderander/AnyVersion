<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace BeforePacketHandler\Packets\120;

use pocketmine\utils\Binary;

use pocketmine\network\mcpe\NetworkSession;

class EventPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::EVENT_PACKET;

	public const TYPE_ACHIEVEMENT_AWARDED = 0;
	public const TYPE_ENTITY_INTERACT = 1;
	public const TYPE_PORTAL_BUILT = 2;
	public const TYPE_PORTAL_USED = 3;
	public const TYPE_MOB_KILLED = 4;
	public const TYPE_CAULDRON_USED = 5;
	public const TYPE_PLAYER_DEATH = 6;
	public const TYPE_BOSS_KILLED = 7;
	public const TYPE_AGENT_COMMAND = 8;
	public const TYPE_AGENT_CREATED = 9;

	/** @var int */
	public $playerRuntimeId;
	/** @var int */
	public $eventData;
	/** @var int */
	public $type;

	protected function decodePayload(){
		$this->playerRuntimeId = $this->getEntityRuntimeId();
		$this->eventData = $this->getVarInt();
		$this->type = (\ord($this->get(1)));

		//TODO: nice confusing mess
	}

	protected function encodePayload(){
		$this->putEntityRuntimeId($this->playerRuntimeId);
		$this->putVarInt($this->eventData);
		($this->buffer .= \chr($this->type));

		//TODO: also nice confusing mess
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleEvent($this);
	}
}
