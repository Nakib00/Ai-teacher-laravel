<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AiTeacher;
use App\Services\LiveKitService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class AiTeacherController extends Controller
{
    use ApiResponseTrait;

    protected $liveKitService;

    public function __construct(LiveKitService $liveKitService)
    {
        $this->liveKitService = $liveKitService;
    }

    /**
     * Get all AI teachers.
     */
    public function index()
    {
        $teachers = AiTeacher::all();
        return $this->successResponse($teachers, 'AI teachers retrieved successfully');
    }

    /**
     * Generate a LiveKit token for a specific AI teacher.
     */
    public function getLiveKitToken(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:ai_teachers,id',
        ]);

        $user = auth('api')->user();
        $teacher = AiTeacher::find($request->teacher_id);

        $livekit_data = $this->liveKitService->generateToken($user, $teacher);

        $responseData = [
            'user' => [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'livekit_token' => $livekit_data['token'],
                'room' => $livekit_data['room']
            ]
        ];
        return $this->successResponse($responseData, 'LiveKit token generated successfully');
    }
}
