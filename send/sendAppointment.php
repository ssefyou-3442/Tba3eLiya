<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $date = $_POST['date'] ?? '';

 
    $message = "Nom: $name\n";
    $message .= "Numéro de téléphone: $phone\n";
    $message .= "Date du rendez-vous: $date\n";

 
    $telegramToken = "7614727765:AAGNe1me4S8qzIQKa87_fQQg5NwKdl5b2fw";
    $chatId = "1993035125"; 

  
    $url = "https://api.telegram.org/bot$telegramToken/sendMessage";

    $data = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'HTML',
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    
    if ($result) {
        echo "<script>
                alert('تم إرسال الموعد بنجاح');
                window.location.href = 'send.html'; 
              </script>";
    } else {
        echo "<script>
                alert('حدث خطأ أثناء إرسال الموعد');
                window.location.href = 'send.html';
              </script>";
    }
} else {
    echo "<script>
            alert('طلب غير صحيح');
            window.location.href = 'send.html'; 
          </script>";
}
?>
