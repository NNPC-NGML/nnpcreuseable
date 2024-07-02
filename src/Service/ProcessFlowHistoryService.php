<?php

namespace Skillz\Nnpcreusable\Service;

use Skillz\Nnpcreusable\Models\ProcessFlowHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProcessFlowHistoryService
{
    /**
     * Retrieve all Processflow histories.
     *
     * This method retrieves all Processflow histories from the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Skillz\Nnpcreusable\Models\ProcessFlowHistory[]
     *
     * @throws \Exception If an error occurs while retrieving the Processflow histories.
     */
    public function getProcessflowHistories()
    {
        // return ProcessFlowHistory::where(["status" => 1])->get();
        return $model = (new ProcessFlowHistory())->where(["status" => 1])->get();
    }

    /**
     * This Method is used to create a new Processflow history in the database .
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool True if the Processflow history is created successfully, false otherwise.
     * @throws bool False  has an error.
     */

    public function createProcessFlowHistory(Request $request): object
    {
        $model = new ProcessFlowHistory();

        $validator = Validator::make($request->all(), [

            "user_id" => "required",
            "task_id" => "required",
            "step_id" => "required",
            "process_flow_id" => "required",
            "status" => "required",
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return $model->create($request->all());
    }

    /**
     * Retrieve a ProcessFlowHistory by its ID.
     *
     * @param int $id The ID of the ProcessFlowHistory to retrieve.
     *
     * @return \Skillz\Nnpcreusable\Models\ProcessFlowHistory|null The retrieved ProcessFlowHistory, or null if not found.
     */

    public function getProcessFlowHistory(int $id): ?ProcessFlowHistory
    {

        return ProcessFlowHistory::findOrFail($id);
    }

    /**
     * Update an existing Processflow History.
     *
     * @param Request $request The request containing the updated data
     * @param int $id The ID of the Processflow history to update
     * @return object The updated Processflow History model
     * @throws ModelNotFoundException If no Processflow History with the given ID is found
     */
    public function updateProcessFlowHistory(Request $request, int $id): ProcessFlowHistory
    {
        $processFlowHistory = $this->getProcessFlowHistory($id);

        if (!$processFlowHistory) {
            throw new ModelNotFoundException("ID $id not found");
        }

        $validator = Validator::make($request->all(), [
            'user_id'            => 'sometimes|integer',
            'task_id'            => 'sometimes|integer',
            'step_id'            => 'sometimes|integer',
            'process_flow_id'    => 'sometimes|integer',
            'status'             => 'sometimes|boolean',
        ]);



        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $processFlowHistory->update($request->all());

        return $processFlowHistory;
    }

    /**
     * Delete a ProcessFlowHistory by its ID.
     *
     * @param int $id The ID of the ProcessFlowHistory to delete.
     *
     * @return bool True if the deletion is successful, false otherwise.
     */

    public function deleteProcessFlowHistory(int $id): bool
    {
        $model = ProcessFlowHistory::find($id);
        if ($model) {
            if ($model->delete()) {
                return true;
            }
        }
        return false;
    }
}
