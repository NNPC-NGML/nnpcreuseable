<?php

namespace App\Jobs\DesignationAssignment;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Skillz\Nnpcreusable\Models\DesignationUser;

class DesignationAssignmentUpdated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $data;
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    public function handle(): void
    {
        $model = DesignationUser::where(["id" => $this->data["id"]])->first();
        if ($model) {
            $model->update($this->data);
        }
    }

    public function getData(): array
    {
        return $this->data;
    }
}
