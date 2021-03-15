<?php
namespace CGFEURegister;

interface TaskInterface {}

interface HourlyTask extends TaskInterface
{
    public function hourly();
}

interface DailyTask extends TaskInterface
{
    public function daily();
}

interface WeeklyTask extends TaskInterface
{
    public function weekly();
}

interface MonthlyTask extends TaskInterface
{
    public function monthly();
}
