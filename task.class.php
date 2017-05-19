<?php
/**
 * This class handles the modification of a task object
 */
class Task {
    public $TaskId;
    public $TaskName;
    public $TaskDescription;
    protected $TaskDataSource;
    public function __construct($Id = null) {
        $this->TaskDataSource = file_get_contents('Task_Data.txt');
        if (strlen($this->TaskDataSource) > 0)
            $this->TaskDataSource = json_decode($this->TaskDataSource); // Should decode to an array of Task objects
        else
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array

        if (!$this->TaskDataSource)
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array
        if (!$this->LoadFromId($Id))
            $this->Create();
    }
    protected function Create() {
        // This function needs to generate a new unique ID for the task
        // Assignment: Generate unique id for the new task
        $this->TaskId = $this->getUniqueId();
        $this->TaskName = 'New Task';
        $this->TaskDescription = 'New Description';
    }
    protected function getUniqueId() {
        return count($this->TaskDataSource)+1; // returns the first available ID
    }
    protected function LoadFromId($Id = null) {
        if ($Id) {
			// Looks at all the IDS!
            foreach($this->TaskDataSource as $tsk){
				if($Id == $tsk->TaskId){
					$this->TaskName = $tsk->TaskName;
					$this->TaskDescription = $tsk->TaskDescription;
					$this->TaskId = $Id;
					return true;
				}
			}
			return false;
        } else
            return null;
    }

	public function Exists(){
		$compare = $this->TaskDataSource[$this->TaskId-1];
		
		
		
		return 	$this->TaskName == $compare->TaskName 
					and
				$this->TaskDescription == $compare->TaskDescription;
	}
	
    public function Save() {
		$this->TaskDataSource[$this->TaskId-1] = $this;
		file_put_contents("Task_Data.txt",json_encode($this->TaskDataSource));
		return true;
    }
    public function Delete() {
        $last = $this->TaskDataSource[count($this->TaskDataSource)-1];
		if($last->TaskId == $this->TaskId){					// If is the last element in the array then its fine to just remove it
			unset($this->TaskDataSource[count($this->TaskDataSource)-1]);
		}else{												// If not then replace the destructing element with the last one in the list reasigning the ID so there are no unused ones
			unset($this->TaskDataSource[$last->TaskId - 1]);
			$last->TaskId = $this->TaskId;
			$this->TaskDataSource[$last->TaskId-1] = $last;
		}
		file_put_contents("Task_Data.txt",json_encode($this->TaskDataSource));
		return true;
    }
}
?>