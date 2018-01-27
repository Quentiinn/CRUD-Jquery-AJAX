<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Document</title>
    <style type="text/css">
        .form-group row col-xs-6{
            border: 1px solid;
        }
    </style>
</head>
<body>


<form method="post" action="" id="recherche">
    ID : <input type="text" name="id">
    <input type="hidden" name="nomFonction" value="search">
    <input type="submit" value="OK">
</form>

<div id="tableau"></div>

<!--Modal de suppression de user-->
<div class="modal fade" id="delete_user_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Etes-vous sur de supprimer cet utilisateur ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="button_supp">Oui</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Détails</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="info"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>






    <form method="post" action="" id="form_submit">
        <h2>Ajouter un utilisateur :</h2>
            <div class="form-group row col-xs-6">
                <label for="nom" class="col-2 col-form-label">Nom</label>
                <div class="col-4">
                    <input type="text" name="nom" class="form-control">
                </div>
            </div>
            <div class="form-group row col-xs-6">
                <label for="prenom" class="col-2 col-form-label">Prénom</label>
                <div class="col-4">
                    <input type="text" name="prenom" class="form-control">
                </div>
            </div>
            <div class="form-group row col-xs-6">
                <label for="ville" class="col-2 col-form-label">Ville</label>
                <div class="col-4">
                    <input type="text" name="ville" class="form-control">
                </div>
            </div>
            <div class="form-group row col-xs-6">
                <label for="date" class="col-2 col-form-label">Date de naissance</label>
                <div class="col-4">
                    <input type="text" name="date" id="datepicker" class="form-control">
                </div>
            </div>
            <input type="hidden" name="nomFonction" value="add">
            <input type="submit" class="btn btn-default">
    </form>


<script>
    $( function() {
        var id_user_suppression;

        tableau()
        $.datepicker.regional['fr'] = {
            closeText: 'Fermer',
            prevText: '<Préc',
            nextText: 'Suiv>',
            currentText: 'Courant',
            monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin',
                'Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
            monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun',
                'Jul','Aoû','Sep','Oct','Nov','Déc'],
            dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
            dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
            dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['fr']);
        $( "#datepicker" ).datepicker($.datepicker.regional["fr"]) ;



        $("#recherche").submit(function (e) {
            e.preventDefault();
            $.ajax({
                type:"POST",
                url: "ajax.php",
                data: $(this).serialize()
            }).done(function(msg){
                var infos = JSON.parse(msg)
                $("#info").html("Prénom : " + infos.firstname + '<br/>Nom : ' + infos.lastname + '<br/>Date de naissance : ' + infos.birthdate + '<br/>Ville : ' + infos.city)
                $('#exampleModal').modal('show');
            })

        })


        $("#form_submit").submit(function (e) {
            e.preventDefault();
            $.ajax({
                type:"POST",
                url: "ajax.php",
                data: $(this).serialize()
            }).done(function(msg){
                console.log(msg);
                alert("Element ajouté")
                tableau();
            })
        })

        $(document).on("click", "button.supp" , function(){
            id_user_suppression = $(this).attr('data-id');
            $("#delete_user_modal").modal('show')
        })
    
    
        $("#button_supp").on("click" , function () {
            console.log("oazoeazoeoazoeoeazo")
            $.ajax({
                type:"POST",
                url: "ajax.php",
                data: {nomFonction : "delete" , id: id_user_suppression}
            }).done(function (msg) {
                console.log(msg)
                tableau()
                $("#delete_user_modal").modal('hide')
            })
        })

    } );





    function tableau(){
        $.ajax({
            type:"POST",
            url: "ajax.php",
            data: {nomFonction : "getAll"}
        }).done(function(msg){
            var elt = $("<table>");
            elt.attr({name: 'tab',id : 'tab', class : 'table table-striped'});
            var thead = $("<thead>");
            elt.append(thead);
            var tr = $("<tr>");
            var td = $("<th>" , {html : 'ID'});
            var td2 = $("<th>" , {html : 'Prénom'});
            var td3 = $("<th>" , {html : 'Nom'});
            var td4 = $("<th>" , {html : 'Ville'});
            var td5 = $("<th>" , {html : 'Date de naissance'});
            var td6 = $("<th>" , {html : 'Supprimer'});

            tr.append(td).append(td2).append(td3).append(td4).append(td5).append(td6);
            thead.append(tr);
            var tbody = $("<tbody>")
            elt.append(tbody);
            $.each(JSON.parse(msg),function(key,value){
                var trvar = $("<tr>" );
                var th = $("<th>", {scope : 'row' , html :value.id_user});
                var td = $("<td>"  , {html : value.firstname});
                var td2 = $("<td>"  , {html : value.lastname});
                var td3 = $("<td>"  , {html : value.city});
                var date = value.birthdate.split("-")
                var date = date[2] + "/" + date[1] + "/" + date[0]
                var td4 = $("<td>"  , {html : date});
                var td5 = $("<td>");
                var button = $("<button>" , {html : "Supprimer" , "data-id" : value.id_user , class : "btn btn-danger supp" })
                td5.append(button)
                trvar.append(th).append(td).append(td2).append(td3).append(td4).append(td5);
                tbody.append(trvar)
            });
            $("#tableau").html(elt);
        })
    }

</script>
</body>
</html>