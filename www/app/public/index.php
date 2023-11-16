<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Тайный Санта</title>
  <!-- Подключение Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<form id="santaForm">
  <div class="form-group">
    <label for="participants">Идентификаторы участников (через запятую):</label>
    <input type="text" class="form-control" id="participants" name="participants" required>
  </div>
  <button type="submit" class="btn btn-primary">Определить тайного Санту!</button>
</form>

<div id="results" class="display: none">
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Обрабатываем отправку формы по кнопке
    $("button[type='submit']").click(function(event) {
      event.preventDefault(); // Предотвратить отправку формы по умолчанию

      // Собираем данные формы
      var participants = $("input[name='participants']").val();

      // Отправляем данные на сервер
      $.ajax({
        url: "santa.php",
        type: "POST",
        dataType: "json",
        data: {
          participants: participants
        },
          success: function(response) {
              // Обновляем результаты
              var pairsList = $("<ul></ul>");
              response.pairsList.forEach(function(pair) {
                  pairsList.append($("<li></li>").text(pair[0] + " - " + pair[1]));
              });
              $("#results").html(pairsList);
              $("#results").show(); // Показать результаты
          },
        error: function(xhr) {
          // Обработка ошибок
          console.error(xhr.responseText);
        }
      });
    });
  });
</script>
</body>
</html>