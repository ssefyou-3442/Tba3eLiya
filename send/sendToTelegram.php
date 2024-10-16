<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $deliveryOption = $_POST['deliveryOption'] ?? '';
    $address = $_POST['address'] ?? '';

    
    $message = "Nom: $name\n";
    $message .= "Numéro de téléphone: $phone\n";
    $message .= "Option de livraison: $deliveryOption\n";
    if ($deliveryOption === 'deliver') {
        $message .= "Adresse: $address\n";
    }

   
    $telegramToken = "7614727765:AAGNe1me4S8qzIQKa87_fQQg5NwKdl5b2fw"; 
    $chatId = "1993035125"; 
    
    $filePath = $_FILES['document']['tmp_name'];
    $fileName = $_FILES['document']['name'];

    
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

    
    $url = "https://api.telegram.org/bot$telegramToken/sendDocument";

    $documentData = [
        'chat_id' => $chatId,
        'document' => new CURLFile(realpath($filePath), 'application/pdf', $fileName),
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $documentData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    
    if ($result && $response) {
        echo "<script>
                alert('تم إرسال الطلب بنجاح');
                window.location.href = 'send.html'
              </script>";
    } else {
        echo "<script>
                alert('حدث خطأ أثناء إرسال الطلب');
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
