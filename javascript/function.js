function mudaFoto(foto) {
    document.getElementById("icone").src = foto;
}

function dateDuJour(fmt){
    // Fonction qui renvoie la date du jour formattée
    // Number fmt : 1=jj/mm/aaaa, 2=aaaa-mm-jj, 3=jjjj j mmmm aaaa
        // Variables locales
        var oDJ = new Date(); // Date du jour
        var iSem = oDJ.getDay(); // Jour de la semaine : 0=Dim à 6=Sam
        var iJour = oDJ.getDate(); // Jour du mois
        var iMois = oDJ.getMonth(); // Mois : 0=Jan à 11=Déc
        var iAnnee = oDJ.getFullYear(); // Année avec millésime
        var aMois = new Array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
        var aSem = new Array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi',
                'Vendredi', 'Samedi');
        // Selon le format demandé
        switch (fmt) {
        case 1:
            iMois++;
            return ajoutZero(iJour) + '/' + ajoutZero(iMois) + '/'
                    + iAnnee.toString();
        case 2:
            iMois++;
            return iAnnee.toString() + '-' + ajoutZero(iMois) + '-'
                    + ajoutZero(iJour);
        case 3:
            return aSem[iSem] + ' ' + iJour.toString() + ' ' + aMois[iMois] + ' '
                    + iAnnee.toString();
        default:
            return oDJ.toString();
        }
    };