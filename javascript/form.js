$(document).ready(function(){
    $("form").submit(function(event){
        /*Si la longueur de la valeur du champ #prenom est 0 (c'est-à-dire si
        le champ n'a pas été rempli), on affiche un message et on empêche l'envoi*/
        if($("#prenom").val().length === 0){
            $("#prenom").after("<span>Merci de remplir ce champ</span>");
            event.preventDefault();
        }else{
            //On effectue nos requêtes Ajax, sérialise, etc...
            let chaine = $("form").serialize();
        }
        if($("#nom").val().length === 0){
          $("#nom").after("<span>Merci de remplir ce champ</span>");
          event.preventDefault();
      }else{
          //On effectue nos requêtes Ajax, sérialise, etc...
          let chaine = $("form").serialize();
      }
        if($("#pseudo").val().length === 0){
        $("#pseudo").after("<span>Merci de remplir ce champ</span>");
        event.preventDefault();
    }else{
        //On effectue nos requêtes Ajax, sérialise, etc...
        let chaine = $("form").serialize();
    }
    if($("#ville").val().length === 0){
        $("#ville").after("<span>Merci de remplir ce champ</span>");
        event.preventDefault();
    }else{
        //On effectue nos requêtes Ajax, sérialise, etc...
        let chaine = $("form").serialize();
    }
    if($("#pays").val().length === 0){
        $("#pays").after("<span>Merci de remplir ce champ</span>");
        event.preventDefault();
    }else{
        //On effectue nos requêtes Ajax, sérialise, etc...
        let chaine = $("form").serialize();
    }
    if($("#cp").val().length === 0){
        $("#cp").after("<span>Merci de remplir ce champ</span>");
        event.preventDefault();
    }else{
        //On effectue nos requêtes Ajax, sérialise, etc...
        let chaine = $("form").serialize();
    }
      //............
    });
});