<?php

namespace App\Services;

use App\Models\User;
use App\Models\AiTeacher;
use Agence104\LiveKit\AccessToken;
use Agence104\LiveKit\AccessTokenOptions;
use Agence104\LiveKit\VideoGrant;

class LiveKitService
{
    /**
     * Generate a LiveKit token for a specific user and AI teacher.
     *
     * @param User $user
     * @param AiTeacher $teacher
     * @return array
     */
    public function generateToken(User $user, AiTeacher $teacher): array
    {
        // The room name will now be in the format: user_{userId}_teacher_{personaId}
        $roomName = 'user_' . $user->id . '_teacher_' . $teacher->persona_id;

        $tokenOptions = (new AccessTokenOptions())->setIdentity((string)$user->id);

        $videoGrant = (new VideoGrant())
            ->setRoomJoin(true)
            ->setRoomName($roomName);

        $token = (new AccessToken(env('LIVEKIT_API_KEY'), env('LIVEKIT_API_SECRET')))
            ->init($tokenOptions)
            ->setGrant($videoGrant)
            ->toJwt();

        return [
            'room' => $roomName,
            'token' => $token,
        ];
    }
}
