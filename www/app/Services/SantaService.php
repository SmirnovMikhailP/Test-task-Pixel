<?php
namespace App\Services;

class SantaService
{
   public function generatePairs($participants)
    {
        $participants = explode(',', $participants);

        $participantsCount = count($participants);

        shuffle($participants);

        $pairs = [];

        for ($i = 0; $i < $participantsCount; $i++) {
            $pairs[] = [$participants[$i], $participants[($i + 1) % $participantsCount]];
        }

        return $pairs;
    }
}
