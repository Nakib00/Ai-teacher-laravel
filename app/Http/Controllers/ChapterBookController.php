<?php

namespace App\Http\Controllers;

use App\Models\ChapterBook; // Import the ChapterBook model
use App\Models\ClassBook;   // Import ClassBook for validation
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Import Rule for validation

class ChapterBookController extends Controller
{
    /**
     * Add a new chapter to a book.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addChapter(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'chapter_name' => 'required|string|max:255',
                'book_id' => 'required|integer|exists:class_books,id', // Ensure book_id exists in class_books table
                'description' => 'nullable|string',
                'is_active' => 'boolean', // Optional, defaults to true in migration
                'ai_added' => 'boolean',  // Optional, defaults to false in migration
                'image_url' => 'nullable|url|max:2048', // Validate as a URL, max 2MB
            ]);

            // Create a new ChapterBook instance
            $chapterBook = ChapterBook::create([
                'chapter_name' => $validatedData['chapter_name'],
                'book_id' => $validatedData['book_id'],
                'description' => $validatedData['description'] ?? null,
                'is_active' => $validatedData['is_active'] ?? true,
                'ai_added' => $validatedData['ai_added'] ?? false,
                'image_url' => $validatedData['image_url'] ?? null,
            ]);

            // Return a success response with the created chapter data
            return response()->json([
                'status' => 200,
                'message' => 'Chapter added successfully',
                'data' => $chapterBook,
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
                'message' => 'An error occurred while adding the chapter.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get class book chapters. Can fetch all or a specific chapter by ID.
     * Optionally filters by book_id, is_active, or ai_added.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChapter(Request $request, $id = null)
    {
        try {
            if ($id) {
                // Fetch a specific chapter by ID, eager load the associated book
                $chapterBook = ChapterBook::with('book')->find($id);

                if (!$chapterBook) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Chapter not found.',
                    ], 404);
                }

                return response()->json([
                    'status' => 200,
                    'message' => 'Chapter retrieved successfully',
                    'data' => $chapterBook,
                ], 200);
            } else {
                // Fetch all chapters or filter them, eager load the associated book
                $query = ChapterBook::with('book');

                // Filter by book_id if provided in query parameters
                if ($request->has('book_id')) {
                    $query->where('book_id', $request->input('book_id'));
                }

                // Filter by is_active if provided in query parameters
                if ($request->has('is_active')) {
                    $query->where('is_active', filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN));
                }

                // Filter by ai_added if provided in query parameters
                if ($request->has('ai_added')) {
                    $query->where('ai_added', filter_var($request->input('ai_added'), FILTER_VALIDATE_BOOLEAN));
                }

                $chapterBooks = $query->get();

                return response()->json([
                    'status' => 200,
                    'message' => 'Chapters retrieved successfully',
                    'data' => $chapterBooks,
                ], 200);
            }
        } catch (\Exception $e) {
            // Handle any errors during retrieval
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while retrieving chapters.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an existing chapter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateChapter(Request $request, $id)
    {
        try {
            $chapterBook = ChapterBook::find($id);

            if (!$chapterBook) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Chapter not found.',
                ], 404);
            }

            // Validate the incoming request data for update
            $validatedData = $request->validate([
                'chapter_name' => 'sometimes|string|max:255',
                'book_id' => 'sometimes|integer|exists:class_books,id',
                'description' => 'nullable|string',
                'is_active' => 'boolean',
                'ai_added' => 'boolean',
                'image_url' => 'nullable|url|max:2048',
            ]);

            // Update the chapter with validated data
            $chapterBook->update($validatedData);

            // Return a success response with the updated chapter data
            return response()->json([
                'status' => 200,
                'message' => 'Chapter updated successfully',
                'data' => $chapterBook,
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
                'message' => 'An error occurred while updating the chapter.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a chapter.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteChapter($id)
    {
        try {
            $chapterBook = ChapterBook::find($id);

            if (!$chapterBook) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Chapter not found.',
                ], 404);
            }

            // Delete the chapter
            $chapterBook->delete();

            // Return a success response
            return response()->json([
                'status' => 200,
                'message' => 'Chapter deleted successfully',
            ], 200);

        } catch (\Exception $e) {
            // Handle any errors during deletion
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while deleting the chapter.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}