<?php

namespace App\Services;

use App\Models\User;
use Agence104\LiveKit\AccessToken;
use Agence104\LiveKit\AccessTokenOptions;
use Agence104\LiveKit\VideoGrant;

class LiveKitService
{
    public function generateToken(User $user): array
    {
        $roomName = 'user_' . $user->id;

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
