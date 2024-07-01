<?php

namespace Skillz\Nnpcreusable\Service;

use Skillz\Nnpcreusable\Models\FormBuilder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Skillz\Nnpcreusable\Models\FormData;

class FormService
{
    public function createForm($data): FormBuilder
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'json_form' => 'required|json',
            'field_structure' => 'required|array',
            'field_structure.*.fieldId' => 'required|string',
            'field_structure.*.name' => 'required|string',
            'field_structure.*.label' => 'required|string',
            'field_structure.*.inputType' => 'required|string',
            'field_structure.*.required' => 'required|boolean',
            'field_structure.*.placeholder' => 'nullable|string',
            'access_control' => 'sometimes|array',
            'access_control.*.user' => 'sometimes|integer',
            'access_control.*.role' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return FormBuilder::create($data);
    }

    public function getForm(int $formId): FormBuilder
    {
        return FormBuilder::find($formId);
    }

    /**
     * Update an existing task.
     *
     * @param array $request
     * @param int $id
     * @return bool|null
     */
    public function updateForm(array $request, int $id): ?bool
    {
        $service = $this->getForm($id);
        if ($service) {
            return $service->update($request);
        }
        return false;
    }

    /**
     * Delete a task.
     *
     * @param int $id
     * @return bool
     */
    public function destroyForm(int $id): bool
    {
        $service = $this->getForm($id);
        return $service->delete();
    }


    public function createFormData($data): FormBuilder
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'json_form' => 'required|json',
            'field_structure' => 'required|array',
            'field_structure.*.fieldId' => 'required|string',
            'field_structure.*.name' => 'required|string',
            'field_structure.*.label' => 'required|string',
            'field_structure.*.inputType' => 'required|string',
            'field_structure.*.required' => 'required|boolean',
            'field_structure.*.placeholder' => 'nullable|string',
            'access_control' => 'sometimes|array',
            'access_control.*.user' => 'sometimes|integer',
            'access_control.*.role' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return FormBuilder::create($data);
    }

    public function getFormData(int $id): FormBuilder
    {
        return FormData::find($id);
    }

    /**
     * Update an existing task.
     *
     * @param array $request
     * @param int $id
     * @return bool|null
     */
    public function updateFormData(array $request, int $id): ?bool
    {
        $service = $this->getFormData($id);
        if ($service) {
            return $service->update($request);
        }
        return false;
    }

    /**
     * Delete a task.
     *
     * @param int $id
     * @return bool
     */
    public function destroyFormData(int $id): bool
    {
        $service = $this->getFormData($id);
        return $service->delete();
    }
}
