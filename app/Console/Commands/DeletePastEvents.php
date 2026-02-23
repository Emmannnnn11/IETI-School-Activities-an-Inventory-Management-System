<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;

class DeletePastEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:delete-past';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all events that have passed their event date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();
        
        $pastEvents = Event::where('event_date', '<', $today)->get();
        $count = $pastEvents->count();
        
        if ($count === 0) {
            $this->info('No past events to delete.');
            return 0;
        }
        
        // Delete past events
        foreach ($pastEvents as $event) {
            $event->delete();
        }
        
        $this->info("Successfully deleted {$count} past event(s).");
        
        return 0;
    }
}

