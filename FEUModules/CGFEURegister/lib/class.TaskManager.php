<?php
namespace CGFEURegister;

class TaskManager
{
    private $tasks = [];

    public function register_task(TaskInterface $intask)
    {
        foreach( $this->tasks as $onetask ) {
            if( get_class($onetask) == get_class($intask) ) throw new \InvalidArgumentException('An instance of '.get_class($intask).' has already been registered');
        }
        $this->tasks[] = $intask;
    }

    public function hourly()
    {
        foreach( $this->tasks as $task ) {
            if( $task instanceof HourlyTask ) $task->hourly();
        }
    }

    public function daily()
    {
        foreach( $this->tasks as $task ) {
            if( $task instanceof DailyTask ) $task->daily();
        }
    }

    public function weekly()
    {
        foreach( $this->tasks as $task ) {
            if( $task instanceof WeeklyTask ) $task->weekly();
        }
    }

    public function monthly()
    {
        foreach( $this->tasks as $task ) {
            if( $task instanceof MontlyTask ) $task->monthly();
        }
    }

} // class