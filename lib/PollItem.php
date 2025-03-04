<?

/**
 * @property int $VoteCount
 * @property Poll $Poll
 */
class PollItem extends PropertiesBase{
	public $PollItemId;
	public $PollId;
	public $Name;
	public $Description;
	protected $_VoteCount = null;
	protected $_Poll = null;


	// *******
	// GETTERS
	// *******

	protected function GetVoteCount(): int{
		if($this->_VoteCount === null){
			$this->_VoteCount = Db::QueryInt('SELECT count(*) from PollVotes pv inner join PollItems pi using (PollItemId) where pi.PollItemId = ?', [$this->PollItemId]);
		}

		return $this->_VoteCount;
	}


	// ***********
	// ORM METHODS
	// ***********

	public static function Get(?int $pollItemId): PollItem{
		if($pollItemId === null ){
			throw new Exceptions\InvalidPollItemException();
		}

		$result = Db::Query('SELECT * from PollItems where PollItemId = ?', [$pollItemId], 'PollItem');

		if(sizeof($result) == 0){
			throw new Exceptions\InvalidPollItemException();
		}

		return $result[0];
	}
}
