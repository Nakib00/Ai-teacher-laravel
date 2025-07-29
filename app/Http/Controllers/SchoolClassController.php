<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass; // Import the SchoolClass model
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Import Rule for unique validation

class SchoolClassController extends Controller
{
    /**
     * Add a new school class.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addClass(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'class_name' => [
                    'required',
                    'string',
                    'max:255',
                    // Ensure class_name is unique in the school_classes table
                    Rule::unique('school_classes', 'class_name'),
                ],
                'is_active' => 'boolean', // Optional, defaults to true in migration
            ]);

            // Create a new SchoolClass instance
            $schoolClass = SchoolClass::create([
                'class_name' => $validatedData['class_name'],
                'is_active' => $validatedData['is_active'] ?? true, // Use validated value or default
            ]);

            // Return a success response
            return response()->json([
                'status' => 200,
                'message' => 'School class added successfully',
                'data' => $schoolClass,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'status' => 422,
                'message' => 'Validation Error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Handle other potential errors
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while adding the class.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get all school classes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getClass()
    {
        try {
            // Retrieve all school classes from the database
            $schoolClasses = SchoolClass::all();

            // Return a success response with the list of classes
            return response()->json([
                'status' => 200,
                'message' => 'School classes retrieved successfully',
                'data' => $schoolClasses,
            ], 200);

        } catch (\Exception $e) {
            // Handle any errors during retrieval
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while retrieving classes.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}