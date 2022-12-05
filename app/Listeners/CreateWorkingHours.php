<?php

namespace App\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Interfaces\HasWorkingDays;
use App\Models\User;

class CreateWorkingHours implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $entity;

    /**
     * Create the event listener.
     *
     * @param HasWorkingDays $entity
     */
    public function __construct(HasWorkingDays $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle()
    {
        if (! method_exists($this->entity ,'working_days')) {
            return;
        }

        $this->entity->working_days()->insert([
            [
                'day' => 'Sun',
                'start_at' => '10:00',
                'end_at' => '15:00',
                'provider_id' => $this->entity instanceof User ? 0 : $this->entity->id,
                'user_id' => $this->entity instanceof User ? $this->entity->id : 0,
                'is_active' => 1,
            ],
            [
                'day' => 'Mon',
                'start_at' => '08:00',
                'end_at' => '18:00',
                'provider_id' => $this->entity instanceof User ? 0 : $this->entity->id,
                'user_id' => $this->entity instanceof User ? $this->entity->id : 0,
                'is_active' => 1,
            ],
            [
                'day' => 'Tue',
                'start_at' => '08:00',
                'end_at' => '18:00',
                'provider_id' => $this->entity instanceof User ? 0 : $this->entity->id,
                'user_id' => $this->entity instanceof User ? $this->entity->id : 0,
                'is_active' => 1,
            ],
            [
                'day' => 'Wed',
                'start_at' => '08:00',
                'end_at' => '18:00',
                'provider_id' => $this->entity instanceof User ? 0 : $this->entity->id,
                'user_id' => $this->entity instanceof User ? $this->entity->id : 0,
                'is_active' => 1,
            ],
            [
                'day' => 'Thu',
                'start_at' => '08:00',
                'end_at' => '18:00',
                'provider_id' => $this->entity instanceof User ? 0 : $this->entity->id,
                'user_id' => $this->entity instanceof User ? $this->entity->id : 0,
                'is_active' => 1,
            ],
            [
                'day' => 'Fri',
                'start_at' => '08:00',
                'end_at' => '18:00',
                'provider_id' => $this->entity instanceof User ? 0 : $this->entity->id,
                'user_id' => $this->entity instanceof User ? $this->entity->id : 0,
                'is_active' => 1,
            ],
            [
                'day' => 'Sat',
                'start_at' => '09:00',
                'end_at' => '16:00',
                'provider_id' => $this->entity instanceof User ? 0 : $this->entity->id,
                'user_id' => $this->entity instanceof User ? $this->entity->id : 0,
                'is_active' => 1,
            ],
        ]);

    }
}
