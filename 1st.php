<?php

new SLA();

class SLA{

    private $current_date,
    $day_time,
    $day_off,
    $celebs,
    $number_of_tasks,
    $time_for_complete,
    $priority, $task_map;

    function __construct()
    {
        $this->ReadFile();
    }

    private function ReadFile(){

        $data = fopen('1st.txt', "r");
        if ($data === FALSE) return false;

        $this->current_date = trim(fgets($data));
        $this->day_time = explode(" ", trim(fgets($data)));
        $this->day_off = explode(" ", trim(fgets($data)));
        $this->celebs = explode(" ", trim(fgets($data)));
        $this->number_of_tasks = trim(fgets($data));
        $this->time_for_complete = explode(" ", trim(fgets($data)));
        $this->priority = explode(" ", trim(fgets($data)));

        foreach ($this->priority as $key=>$value){
            $this->task_map[$value] = $this->convert_time($this->time_for_complete[$key]);
        }

        krsort($this->task_map);
        $this->CalculateTime();


        echo "";

    }

    private function CalculateTime(){

        $date = strtotime($this->current_date);
        $tasks = $this->task_map;
        while(!empty($tasks)){
            $current_task_itterator = 0;
                $can_be_done_today = 0;
            if(!$this->IsCeleb($date) && $this->IsInDay($date)) {
                $can_be_done_today = $this->convert_time($this->day_time[1] . ":00") - $this->convert_time(date("H:i", $date));
                $date = date($date + strtotime('+' .$can_be_done_today . 'seconds', strtotime($date)));
                $current_task = current($tasks);
                $current_task = $current_task -  $can_be_done_today;

                echo date('l jS \of F Y h:i:s A', $date);

                //strtotime('+' . 'day', strtotime($date));
            }
        }

    }
    private function IsCeleb($date){
        foreach ($this->celebs as $celeb) {
            if (date("d.m.Y", strtotime($celeb)) == date("d.m.Y", strtotime($date))) return true;
        }
        return false;
    }
    private function IsInDay($date){
        if (strtotime(date("H:i", $date)) <= strtotime($this->day_time[1] . ":00")
                && strtotime(date("H:i", $date)) >= date("H:i", strtotime($this->day_time[0] . ":00")))
            return true;
        else return false;
    }
    private function convert_time($time)
    { //returns time in seconds
        $var = strtotime("1970-01-01 $time UTC");
        return $var;
    }

}