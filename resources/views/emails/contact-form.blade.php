<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau message de contact</title>
</head>
<body>
    <h1>Nouveau message de contact</h1>
    <p><strong>Nom :</strong> {{ $data['name'] }}</p>
    <p><strong>E-mail :</strong> {{ $data['email'] }}</p>
    <p><strong>Message :</strong></p>
    <p>{{ $data['message'] }}</p>
</body>
</html>