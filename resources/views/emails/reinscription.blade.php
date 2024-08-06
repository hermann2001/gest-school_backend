<html>

<body>
    <h1>Bonjour,</h1>
    <p>Félicitations ! <br> Votre enfant {{ $eleve->nom }} {{ $eleve->prenoms }} est réinscrit avec succès dans notre
        établissement <b>{{ $schoolName }}</b> en {{ $eleveC->level }}
    </p>
    <p><a href="{{ $linkDownload }}">Télécharger ici la fiche de réinscription</a></p>
</body>

</html>
