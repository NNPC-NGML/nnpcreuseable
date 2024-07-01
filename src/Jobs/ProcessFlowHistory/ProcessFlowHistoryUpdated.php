<?php

namespace App\Jobs\ProcessFlowHistory;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Service\ProcessFlowHistoryService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessFlowHistoryUpdated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The data for updating the ProcessFlowhistory.
     *
     * @var array
     */
    private array $data;
    private int $id;

    /**
     * Create a new job instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->id = $data['id'];
    }

    public function handle(): void
    {
        $service = new  \Skillz\Nnpcreusable\Service\ProcessFlowHistoryService();
        $data = new \Illuminate\Http\Request($this->data);
        $service->updateProcessFlowHistory($data, $this->id);
    }
}
