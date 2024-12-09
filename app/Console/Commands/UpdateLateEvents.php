<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event\Event;
use Carbon\Carbon;

class UpdateLateEvents extends Command
{
    protected $signature = 'events:update-late';
    protected $description = 'Atualiza status dos eventos que estãoa trasados.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        Event::withoutGlobalScopes()->where('when', '<', $now)
            ->where('status', 'pending')
            ->update(['status' => 'late']);

        $this->info('Eventos atualizados com sucesso.');
    }
}
