<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <title>Mesaj nou de contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background: #f9f9f9;
            padding: 20px;
        }

        .container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        h2 {
            color: #444;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .section-title {
            margin-top: 20px;
            font-size: 18px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            font-weight: bold;
        }

        .message-box {
            background: #f2f2f2;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
            white-space: pre-wrap;
            /* Pastreaza formatarea liniilor (enter-urile) din mesaj */
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Ai primit un mesaj nou de contact!</h2>

        <p><strong>Data trimiterii:</strong> {{ $contactMessage->created_at->format('d.m.Y H:i') }}</p>

        <div class="section-title">Detalii Expeditor</div>
        <p><strong>Nume complet:</strong> {{ $contactMessage->name }}</p>
        <p><strong>Email:</strong> {{ $contactMessage->email }}</p>
        <p><strong>Telefon:</strong> {{ $contactMessage->phone ?? 'Nu a fost specificat' }}</p>

        <div class="section-title">Mesaj</div>
        <div class="message-box">
            {{ $contactMessage->message }}
        </div>
    </div>
</body>

</html>
