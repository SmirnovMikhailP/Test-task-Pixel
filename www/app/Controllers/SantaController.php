<?php
namespace App\Controllers;

use App\Services\EmailSender;
use App\Services\SantaService;

class SantaController
{
    private $service;
    private $emailSender;

    public function __construct(EmailSender $emailSender)
    {
        $this->service = new SantaService();
        $this->emailSender = $emailSender;
    }

    public function run()
    {
        $participants = $_POST['participants'];
        $pairsList = $this->service->generatePairs($participants);

        foreach ($pairsList as $pair) {
            $giver = $pair[0];
            $receiver = $pair[1];

            $message = "Вы выбраны тайным сантой для {$receiver}";
            $this->emailSender->send($giver, $message);
        }

        header('Content-Type: application/json');
        echo json_encode(['pairsList' => $pairsList]);
        exit;
    }
}