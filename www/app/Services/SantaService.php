<?php
namespace App\Services;

class SantaService
{
    public function generatePairs($participants)
    {
        $participants = explode(',', $participants);
        shuffle($participants);

        $pairs = [];
        $participantsCount = count($participants);

        // Создаем замкнутый массив
        $circularParticipants = array_merge($participants, $participants);

        for ($i = 0; $i < $participantsCount; $i++) {
            $pair = [$circularParticipants[$i], $circularParticipants[$i + 1]];
            $pairs[] = $pair;
        }

        return $pairs;
    }
}