<?php

/**
 * LegionPE
 * Copyright (C) 2015 PEMapModder
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

namespace legionpe\theta\query;

use legionpe\theta\BasePlugin;

class SearchServerQuery extends AsyncQuery{
	/** @var int */
	public $class;
	private $checkPlayers;
	public function __construct(BasePlugin $plugin, $class, $checkPlayers){
		parent::__construct($plugin);
		$this->class = $class;
		$this->checkPlayers = $checkPlayers;
	}
	public function getQuery(){
		$checkPlayers = $this->checkPlayers ? " AND online_players<max_players" : "";
		return "SELECT ip,port FROM server_status WHERE unix_timestamp()-last_online < 5 AND class=$this->class$checkPlayers ORDER BY online_players ASC LIMIT 1";
	}
	public function getResultType(){
		return self::TYPE_ASSOC;
	}
	public function getExpectedColumns(){
		return [
			"ip" => self::COL_STRING,
			"port" => self::COL_INT
		];
	}
}
