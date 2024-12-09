<?php

use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\UpdateLateEvents;

Schedule::command(UpdateLateEvents::class)->dailyAt('00:00')->timezone('America/Sao_Paulo');
