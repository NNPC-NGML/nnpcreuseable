<?php

namespace Skillz\Nnpcreusable\Service;


use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Skillz\Nnpcreusable\Models\Unit;
use Skillz\Nnpcreusable\Models\User;
use Skillz\Nnpcreusable\Models\UnitUser;
use Illuminate\Support\Facades\Validator;
use Skillz\Nnpcreusable\Models\Department;
use Skillz\Nnpcreusable\Models\Designation;
use Skillz\Nnpcreusable\Models\LocationUser;
use Skillz\Nnpcreusable\Models\DepartmentUser;
use Skillz\Nnpcreusable\Models\DesignationUser;
use Skillz\Nnpcreusable\Models\Location;

class UserService
{

    /**
     * Create a new user.
     *
     * @param \Illuminate\Http\Request $request The request containing the data for the new user.
     *
     * @return \App\Models\User \ Illuminate\Support\MessageBag The created user model & MessageBag when there is an error.
     */
    public function createUser(Request $request): User | MessageBag
    {
        $model = new User();

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "id" => "required",
            "email" => "required|email|unique:users",
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return $model->create($request->all());
    }

    /**
     * Retrieve a Puder by its ID.
     *
     * @param int $id The ID of the user to retrieve.
     *
     * @return \App\Models\User|null The retrieved user, or null if not found.
     */

    public function getUser(int $id): User | null
    {
        return User::find($id);
    }

    /**
     * Update an existing user.
     *
     * @param int $id The ID of the user to update.
     * @param \Illuminate\Http\Request $request The HTTP request containing the updated data.
     *
     * @return \App\Models\User The updated user instance.
     *
     * @throws \Exception If validation fails or if an error occurs during the update.
     */

    public function updateUser(int $id, Request $request): User
    {
        $model = User::find($id);
        // validation

        $validator = Validator::make($request->all(), [
            "name" => "sometimes",
            "id" => "sometimes",
            "email" => "sometimes|email|unique:users|",
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
     * Delete a User by its ID.
     *
     * @param int $id The ID of the User to delete.
     *
     * @return bool True if the deletion is successful, false otherwise.
     */

    public function deleteUser(int $id): bool
    {
        $model = User::find($id);
        if ($model) {
            if ($model->delete()) {
                return true;
            }
        }
        return false;
    }

    /**     * Get a paginated list of users for a specific page.
     *
     * @param int $page The page number.
     * @param int $perPage The number of users to display per page.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getUsersForPage(int $page = 1, int $perPage = 10)
    {
        return User::paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Assign a user to a particular department.
     *
     * @param int $userId       The ID of the user.
     * @param int $departmentId The ID of the department.
     *
     * @return bool Returns true on success, false on failure.
     */
    public function assignUserToDepartment(int $userId, int $departmentId): bool
    {
        $user = User::find($userId);
        $department = Department::find($departmentId);

        if (!$user || !$department) {
            return false;
        }


        // Check if the user already belongs to the unit
        if ($user->department && $user->department->id == $department->id) {
            return false;
        }

        $departmentUser = new DepartmentUser();
        $departmentUser->department_id = $department->id;
        $departmentUser->user_id = $user->id;
        $departmentUser->save();

        return true;
    }

    /**
     * Assign a user to a unit.
     *
     * @param int $userId The ID of the user.
     * @param int $unitId The ID of the unit.
     *
     * @return bool Returns true on success, false on failure.
     */
    public function assignUserToUnit(int $userId, int $unitId): bool
    {
        $user = User::find($userId);
        $unit = Unit::find($unitId);

        if (!$user || !$unit) {
            return false;
        }


        // Check if the user already belongs to the unit
        if ($user->unit && $user->unit->id == $unit->id) {
            return false;
        }

        $unitUser = new UnitUser();
        $unitUser->unit_id = $unit->id;
        $unitUser->user_id = $user->id;
        $unitUser->save();

        return true;
    }


    /**
     * The function assigns a user to a location if they are not already assigned.
     *
     * @param int userId The `userId` parameter is an integer that represents the unique identifier of
     * the user to be assigned to a location.
     * @param int locationId The `locationId` parameter in the `assignUserToLocation` function
     * represents the unique identifier of the location to which you want to assign a user. This
     * parameter is used to retrieve the specific location from the database based on its ID so that
     * the user can be assigned to that location.
     *
     * @return bool The function `assignUserToLocation` returns a boolean value. It returns `true` if
     * the user is successfully assigned to the location, and `false` in the following cases:
     * 1. If the user or location is not found (if `` or `` is null).
     * 2. If the user already belongs to the location (if the user's locations collection contains the
     * specified location
     */
    public function assignUserToLocation(int $userId, int $locationId): bool
    {
        $user = User::find($userId);
        $location = Location::find($locationId);
        if (!$user || !$location) {
            return false;
        }
        if ($user->location && $user->location->id == $location->id) {
            return false;
        }

        $locationUser = new LocationUser();
        $locationUser->location_id = $location->id;
        $locationUser->user_id = $user->id;
        $locationUser->save();

        return true;
    }


    /**
     * The function assigns a user to a designation if they are not already assigned.
     *
     * @param int userId The `userId` parameter is an integer that represents the unique identifier of
     * the user to be assigned to a designation.
     * @param int designationId The `designationId` parameter in the `assignUserToDesignation` function
     * represents the unique identifier of the designation to which you want to assign a user. This
     * parameter is used to retrieve the specific designation from the database based on its ID so that
     * the user can be assigned to that designation.
     *
     * @return bool The function `assignUserToDesignation` returns a boolean value. It returns `true` if
     * the user is successfully assigned to the designation, and `false` in the following cases:
     * 1. If the user or designation is not found (if `` or `` is null).
     * 2. If the user already belongs to the designation (if the user's designations collection contains the
     * specified designation
     */

    public function assignUserToDesignation(int $userId, int $designationId): bool
    {
        $user = User::find($userId);
        $designation = Designation::find($designationId);
        if (!$user || !$designation) {
            return false;
        }
        if ($user->$designation && $user->designation->id == $designation->id) {
            return false;
        }

        $designationUser = new DesignationUser();
        $designationUser->designation_id = $designation->id;
        $designationUser->user_id = $user->id;
        $designationUser->save();

        return true;
    }
}
