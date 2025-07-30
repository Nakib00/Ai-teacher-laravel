<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic; // Import the Topic model
use Illuminate\Validation\ValidationException; // Import for validation exceptions
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import for model not found exceptions

class TopicController extends Controller
{
    /**
     * Display a listing of all topics.
     * GET /api/topics
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllTopic()
    {
        try {
            $topics = Topic::all(); // Retrieve all topics
            return response()->json([
                'success' => true,
                'message' => 'Topics retrieved successfully.',
                'data' => $topics
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve topics.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created topic in storage.
     * POST /api/topics
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addTopic(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'topic_title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'is_active' => 'boolean',
                'type' => 'nullable|string|max:50',
                'note' => 'nullable|string',
                'points' => 'integer|min:0',
                'chapter_id' => 'nullable', // Ensure chapter_id exists in chapters table
                'subject_id' => 'nullable', // Ensure subject_id exists in subjects table
                'class_id' => 'nullable', // Ensure class_id exists in school_classes table
            ]);

            // Create a new Topic instance
            $topic = Topic::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Topic created successfully.',
                'data' => $topic
            ], 201); // 201 Created
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422); // 422 Unprocessable Entity
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create topic.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified topic in storage.
     * PUT/PATCH /api/topics/{id}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topic  $topic // Using Route Model Binding
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTopic(Request $request, Topic $topic)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'topic_title' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'is_active' => 'boolean',
                'type' => 'nullable|string|max:50',
                'note' => 'nullable|string',
                'points' => 'integer|min:0',
                'chapter_id' => 'nullable|exists:chapters,id',
                'subject_id' => 'nullable|exists:subjects,id',
                'class_id' => 'nullable|exists:school_classes,id',
            ]);

            // Update the topic instance
            $topic->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Topic updated successfully.',
                'data' => $topic
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Topic not found.',
                'error' => $e->getMessage()
            ], 404); // 404 Not Found
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update topic.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified topic by chapter ID.
     * GET /api/chapters/{chapter_id}/topics
     *
     * @param  int  $chapter_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTopicsByChapter(int $chapter_id)
    {
        try {
            $topics = Topic::where('chapter_id', $chapter_id)->get();

            if ($topics->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No topics found for the given chapter ID.',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Topics for chapter retrieved successfully.',
                'data' => $topics
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve topics for chapter.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified topic from storage.
     * DELETE /api/topics/{id}
     *
     * @param  \App\Models\Topic  $topic // Using Route Model Binding
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Topic $topic)
    {
        try {
            $topic->delete();

            return response()->json([
                'success' => true,
                'message' => 'Topic deleted successfully.'
            ], 200); // 200 OK for successful deletion
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Topic not found.',
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete topic.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
