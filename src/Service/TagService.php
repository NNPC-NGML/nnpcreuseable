<?php

namespace Skillz\Nnpcreusable\Service;

use Skillz\Nnpcreusable\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class TagService
{

    /**
     * Create a new Tag.
     *
     * @param \Illuminate\Http\Request $request The request containing the data for the new Tag.
     *
     * @return \Skillz\Nnpcreusable\Models\Tag \ Illuminate\Support\MessageBag The created Tag model & MessageBag when there is an error.
     */
    public function createTag(Request $request): Tag | MessageBag
    {
        $model = new Tag();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'tag_class' => 'required',
            'tag_class_method' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return $model->create($request->all());
    }

    /**
     * Retrieve a Tag by its ID.
     *
     * @param int $id The ID of the Tag to retrieve.
     *
     * @return \Skillz\Nnpcreusable\Models\Tag | null The retrieved Tag, or null if not found.
     */

    public function getTag(int $id): Tag | null
    {
        return Tag::find($id);
    }

    /**
     * Update an existing Tag.
     *
     * @param int $id The ID of the Tag to update.
     * @param \Illuminate\Http\Request $request The HTTP request containing the updated data.
     *
     * @return \Skillz\Nnpcreusable\Models\Tag The updated Tag instance.
     *
     * @throws \Exception If validation fails or if an error occurs during the update.
     */

    public function updateTag(int $id, Request $request): Tag
    {
        $model = Tag::find($id);
        // validation

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|unique:tags',
            'tag_class' => 'sometimes',
            'tag_class_method' => 'sometimes',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors());
        }

        if ($model) {
            if ($model->update($request->all())) {
                return $model;
            }
            throw new \Exception('Something went wrong.');
        }
        throw new \Exception('Something went wrong.');
    }

    /**
     * Delete a Tag by its ID.
     *
     * @param int $id The ID of the Tag to delete.
     *
     * @return bool True if the deletion is successful, false otherwise.
     */

    public function deleteTag(int $id): bool
    {
        $model = Tag::find($id);
        if ($model) {
            if ($model->delete()) {
                return true;
            }
        }
        return false;
    }
}
