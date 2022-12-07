<?php

namespace App\Listeners;

use App\Interfaces\HasWorkingDays;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\WorkingDays;

class UpdateWorkingHours implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $entity;
    private array $data;

    /**
     * Create the event listener.
     *
     * @param HasWorkingDays $entity
     */
    public function __construct(HasWorkingDays $entity, array $data)
    {
        $this->entity = $entity;
        $this->data = $data;
    }

    public function handle()
    {
        if (! method_exists($this->entity ,'working_days')) {
            return;
        }

        foreach ($this->data as $row) {
            WorkingDays::where('id', $row['id'])->update([
                'start_at' => $row['start_at'],
                'end_at' => $row['end_at'],
                'is_active' => $row['is_active'],
            ]);
        }
    }
}
