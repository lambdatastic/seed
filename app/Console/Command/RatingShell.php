<?php 

require("class_rating.php");

class RatingShell extends AppShell {
	public $uses = array('Ranking', 'Queue'); 
	
	public function main() {
		$this->out("Must call this shell with a function.");
	}
	
	public function createQueue() {
		$this->Ranking->recursive = -1;
		$this->Ranking->query("	CREATE TABLE queues
			SELECT `matches`.`player1_id`, `matches`.`player2_id`, `matches`.`result`, `tournaments`.`game`, `rankings`.`user_id`, `rankings`.`rating`, `rankings`.`rd`
			FROM  `matches` ,  `tournaments`, `rankings`
			WHERE  `matches`.`tournament_id` =  `tournaments`.`id` 
			AND  `completed` >  DATE_SUB(NOW(), INTERVAL 90 DAY)
			AND ( `matches`.`player1_id` = `rankings`.`user_id` OR `matches`.`player2_id` = `rankings`.`user_id`)
			AND `tournaments`.`game` = `rankings`.`game`
			AND `matches`.`player1_id` IS NOT NULL 
			AND `matches`.`player2_id` IS NOT NULL;");
	}	
	
	public function dropQueue() {
		$this->Ranking->recursive = -1;
		$this->Ranking->query("DROP TABLE queues;");
	}
	
	public function calcRatings() {
		$this->Ranking->recursive = -1;
		$rankings = $this->Ranking->find('all');
		
		foreach ($rankings as $ranking) {
			unset($matches);
			$matches = $this->Queue->find('all', array(
				'conditions' => array(
					'user_id !=' => $ranking['Ranking']['user_id'],
					'game' => $ranking['Ranking']['game'],
					'OR' => array(
						'player1_id' => $ranking['Ranking']['user_id'],
						'player2_id' => $ranking['Ranking']['user_id']
					)
				)
			));
			
			unset($matchData);
			for ($i = 0; $i < count($matches); $i++) {
				$matchData['rating'][$i] = $matches[$i]['Queue']['rating'];
				$matchData['RD'][$i] = $matches[$i]['Queue']['rd'];
				if (
					($matches[$i]['Queue']['player1_id'] == $ranking['Ranking']['user_id'] && $matches[$i]['Queue']['result'] == 'P1') ||
					($matches[$i]['Queue']['player2_id'] == $ranking['Ranking']['user_id'] && $matches[$i]['Queue']['result'] == 'P2')
				) {
					$matchData['outcome'][$i] = 1;
				} else {
					$matchData['outcome'][$i] = 0;
				}
			}
			
			$this->out($ranking['Ranking']['id']);
			$this->out(print_r($matches));
			$this->out(print_r($matchData));
			$this->out("");

			$calc = new rating($ranking['Ranking']['rating'], $ranking['Ranking']['rd'], $matchData);
			
			$newRank['Ranking']['id'] = $ranking['Ranking']['id'];
			$newRank['Ranking']['rating'] = $calc->newRating();
			$newRank['Ranking']['rd'] = $calc->newRD();
			if ($newRank['Ranking']['rd'] > 350) {
				$newRank['Ranking']['rd'] = 350;
			} elseif ($newRank['Ranking']['rd'] < 30) {
				$neRank['Ranking']['rd'] = 30;
			}
			$this->Ranking->save($newRank);
		}
	}
}			
