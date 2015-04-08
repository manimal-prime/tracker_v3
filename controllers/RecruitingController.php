<?php

class RecruitingController {

	public static function _index() {
		$user = User::find($_SESSION['userid']);
		$member = Member::find($_SESSION['username']);
		$tools = Tool::find_all($user->role);
		$divisions = Division::find_all();
		$division = Division::findById(intval($member->game_id));
		$platoons = Platoon::find_all($member->game_id);
		Flight::render('recruiting/index', array(), 'content');
		Flight::render('layouts/application', array('user' => $user, 'member' => $member, 'tools' => $tools, 'divisions' => $divisions, 'platoons' => $platoons));
	}

	public static function _addNewMember() {
		$user = User::find($_SESSION['userid']);
		$member = Member::find($_SESSION['username']);
		$tools = Tool::find_all($user->role);
		$divisions = Division::find_all();
		$division = Division::findById(intval($member->game_id));
		$platoons = Platoon::find_all($member->game_id);
		$platoon_id = (($user->role >= 2) && (!User::isDev($user->id))) ? $member->platoon_id : false;
		$squadLeaders = Platoon::SquadLeaders($member->game_id, $platoon_id);
		Flight::render('recruiting/new_member', array('js' => 'recruit', 'user' => $user, 'division' => $division, 'platoons' => $platoons, 'squadLeaders' => $squadLeaders), 'content');
		Flight::render('layouts/application', array('js' => 'recruit', 'user' => $user, 'member' => $member, 'tools' => $tools, 'divisions' => $divisions, 'platoons' => $platoons));
	}

	public static function _doDivisionThreadCheck() {
		$player = trim($_POST['player']);
		$member = Member::find($_SESSION['username']);
		$gameThreads = DivisionThread::find_all($member->game_id);
		Flight::render('recruiting/thread_check', array('js' => 'check_threads', 'gameThreads' => $gameThreads, 'player' => $player));
	} 

}
