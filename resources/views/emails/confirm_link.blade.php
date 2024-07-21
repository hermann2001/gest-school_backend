<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html, charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <div style="background-color: #F77B1E; text-align: center; color: white; margin: 0 auto; padding: 25px;">
        <div style="margin: 0 10px 10px 10px; padding: 15px; background-color: white; font-size: 25px;">
            <a href="#" style="color: #F77B1E; text-decoration: none;">
                Bonjour {{ $name }}
            </a>
        </div>
        </p>
        <p>Voici ci-dessous le nouveau lien pour confirmer l'enregistrement de votre établissement sur notre
            plateforme.</p>
        <p><a
                href='http://localhost:8000/api/confirmCreateSchool/{{ $name_hash }}'>http://localhost:8000/api/confirmCreateSchool/{{ $name_hash }}</a>
        </p>
        <small>Le lien a une validité d'une journée. Ces 24 heures passées, il faudra recontacter l'administrateur de
            la plateforme pour avoir un nouveau lien de confirmation.</small>
        <div style="margin-top: 20px">
            <p>Merci,</p>
            <p>Cordialement</p>
            <p>L'équipe de Gest-School</p>
        </div>
    </div>
</body>

</html>
