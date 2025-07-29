<?php

namespace App\Http\Controllers;

use App\Models\ClassBook; // Import the ClassBook model
use App\Models\SchoolClass; // Import SchoolClass for validation
use App\Models\School; // Import School for validation (if applicable)
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Import Rule for validation

class ClassBookController extends Controller
{
    /**
     * Add a new class book.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addBook(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'book_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'is_active' => 'boolean', // Optional, defaults to true in migration
                'medium' => 'required|string|max:50', // e.g., 'Bengali', 'English'
                'class_id' => 'required|integer|exists:school_classes,id', // Ensure class_id exists
                'school_id' => 'nullable|integer', // Ensure school_id exists if provided
                'image_url' => 'nullable|url|max:2048', // Validate as a URL, max 2MB
            ]);

            // Create a new ClassBook instance
            $classBook = ClassBook::create([
                'book_name' => $validatedData['book_name'],
                'description' => $validatedData['description'] ?? null,
                'is_active' => $validatedData['is_active'] ?? true,
                'medium' => $validatedData['medium'],
                'class_id' => $validatedData['class_id'],
                'school_id' => $validatedData['school_id'] ?? null,
                'image_url' => $validatedData['image_url'] ?? null,
            ]);

            // Return a success response with the created book data
            return response()->json([
                'status' => 200,
                'message' => 'Class book added successfully',
                'data' => $classBook,
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
                'message' => 'An error occurred while adding the book.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get class books. Can fetch all or a specific book by ID.
     * Optionally filters by class_id or medium.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBook(Request $request, $id = null)
    {
        try {
            if ($id) {
                // Fetch a specific book by ID
                $classBook = ClassBook::with(['schoolClass', 'school'])->find($id);

                if (!$classBook) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Class book not found.',
                    ], 404);
                }

                return response()->json([
                    'status' => 200,
                    'message' => 'Class book retrieved successfully',
                    'data' => $classBook,
                ], 200);
            } else {
                // Fetch all books or filter them
                $query = ClassBook::with(['schoolClass', 'school']);

                // Filter by class_id if provided in query parameters
                if ($request->has('class_id')) {
                    $query->where('class_id', $request->input('class_id'));
                }

                // Filter by medium if provided in query parameters
                if ($request->has('medium')) {
                    $query->where('medium', $request->input('medium'));
                }

                // Filter by is_active if provided in query parameters
                if ($request->has('is_active')) {
                    $query->where('is_active', filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN));
                }

                $classBooks = $query->get();

                return response()->json([
                    'status' => 200,
                    'message' => 'Class books retrieved successfully',
                    'data' => $classBooks,
                ], 200);
            }
        } catch (\Exception $e) {
            // Handle any errors during retrieval
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while retrieving class books.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an existing class book.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBook(Request $request, $id)
    {
        try {
            $classBook = ClassBook::find($id);

            if (!$classBook) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Class book not found.',
                ], 404);
            }

            // Validate the incoming request data for update
            $validatedData = $request->validate([
                'book_name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'is_active' => 'boolean',
                'medium' => 'sometimes|string|max:50',
                'class_id' => 'sometimes|integer|exists:school_classes,id',
                'school_id' => 'nullable|integer|exists:schools,id',
                'image_url' => 'nullable|url|max:2048',
            ]);

            // Update the class book with validated data
            $classBook->update($validatedData);

            // Return a success response with the updated book data
            return response()->json([
                'status' => 200,
                'message' => 'Class book updated successfully',
                'data' => $classBook,
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
                'message' => 'An error occurred while updating the book.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a class book.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteBook($id)
    {
        try {
            $classBook = ClassBook::find($id);

            if (!$classBook) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Class book not found.',
                ], 404);
            }

            // Delete the class book
            $classBook->delete();

            // Return a success response
            return response()->json([
                'status' => 200,
                'message' => 'Class book deleted successfully',
            ], 200);

        } catch (\Exception $e) {
            // Handle any errors during deletion
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while deleting the book.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}