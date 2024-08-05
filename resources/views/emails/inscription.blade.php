<html>

<body>
    <h1>Bonjour,</h1>
    <p>Félicitations ! <br> Votre enfant {{ $eleve->nom }} {{ $eleve->prenoms }} est inscrit avec succès dans notre
        établissement <b>{{ $schoolName }}</b> avec le numéro matricule {{ $eleve->matricule }} en
        {{ $eleveC->level }}
    </p>
    <p><a href="{{ $linkDownload }}">Télécharger ici la fiche d'inscription</a></p>
</body>

</html>
