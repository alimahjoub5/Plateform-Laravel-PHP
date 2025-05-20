<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vérification de votre adresse email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4F46E5;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <h2>Bonjour {{ $user->Username }},</h2>
    
    <p>Merci de vous être inscrit sur notre plateforme. Pour activer votre compte, veuillez cliquer sur le bouton ci-dessous :</p>
    
    <a href="{{ $verificationUrl }}" class="button">Vérifier mon adresse email</a>
    
    <p>Si le bouton ne fonctionne pas, vous pouvez copier et coller le lien suivant dans votre navigateur :</p>
    <p>{{ $verificationUrl }}</p>
    
    <p>Ce lien expirera dans 60 minutes.</p>
    
    <div class="footer">
        <p>Si vous n'avez pas créé de compte, aucune action n'est requise.</p>
        <p>© {{ date('Y') }} Mon Application. Tous droits réservés.</p>
    </div>
</body>
</html> 