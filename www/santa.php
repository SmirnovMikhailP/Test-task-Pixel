<?php

//Библиотека для реализации отправки email

/*use Illuminate\Support\Facades\Mail;*/

interface MessageSender
{
    public function send($recipient, $message);
}

class SantaApp implements MessageSender
{
    private $participants;
    private $pairs;

    public function __construct($participants)
    {
        $this->participants = explode(',', $participants);
        /*$this->participants = $participants;*/
        $this->pairs = $this->generatePairs();
    }

    /**
    Метод отправляет email, нужно вынести в отдельный класс для гибкости
     */
    public function send($recipient, $message)
    {
        // Реализуем отправку email на Laravel

        /*Mail::raw($message, function ($email) use ($recipient) {
            $email->to($recipient);
            // Здесь также можно указать дополнительные настройки, такие как тема письма и т. д.
        });*/

        // Реализуем отправку email на Bitrix

        /*CEvent::Send(
            "EMAIL_TEMPLATE_CODE",  // Код шаблона письма
            "s1",
            array(
                "EMAIL" => $recipient, // Адрес получателя
                "MESSAGE" => $message // Текст сообщения
            ),
            "N", // Параметр, указывающий на нужно ли отправлять письмо в HTML-формате
            0 // Идентификатор почтового шаблона (может быть не указан)
        );*/

        echo "Сообщение отправлено пользователю {$recipient}: {$message}" . PHP_EOL;
    }

    /**
     * Метод выбирает тайного санту для каждого участника и создает новые пары даритель/получатель
     */
    public function run()
    {
        $newPairs = [];
        foreach ($this->pairs as $pair) {
            $giver = $pair[0];
            $receiver = $pair[1];

            $message = "Вы выбраны тайным сантой для {$receiver}";

            $newPairs[] = [$giver, $receiver];
        }
        $this->pairs = array_merge($this->pairs, $newPairs);
    }

    /**
    Метод отвечает за генерацию пар участников для тайного обмена подарками.
     */
    private function generatePairs()
    {
        // Перемешиваем массив участников
        shuffle($this->participants);

        $pairs = [];
        $participantsCount = count($this->participants);

        // Проверяем наличие четного числа участников
        if ($participantsCount % 2 == 0) {
            for ($i = 0; $i < $participantsCount; $i += 2) {
                $pair = [$this->participants[$i], $this->participants[$i + 1]];
                $pairs[] = $pair;
            }
        } else {
            // Если нечетное количество участников, оставляем последнего участника без пары
            for ($i = 0; $i < $participantsCount - 1; $i += 2) {
                $pair = [$this->participants[$i], $this->participants[$i + 1]];
                $pairs[] = $pair;
            }
        }

        return $pairs;
    }

    public function getPairs()
    {
        return $this->pairs;
    }
}

$participants = ['user1@example.com', 'user2@example.com', 'user3@example.com', 'user4@example.com', 'user5@example.com', 'user6@example.com'];

$app = new SantaApp($_POST['participants']);
$pairs = $app->getPairs();
header('Content-Type: application/json');
echo json_encode(['pairsList' => $pairs]);
