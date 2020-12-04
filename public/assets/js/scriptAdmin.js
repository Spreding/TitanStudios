var slugFrom;
var slugTo;
var ButtonValidDelete;
var ButtonDelete;

window.onload = function() {

    CheckSlug();
    CheckIfValidateSuppression();
    CheckUrl();

}

function CheckUrl() {
    var url = window.location.pathname;

    var checkUrlArray = [url.substr(7, 15), url.substr(7, 17), url.substr(7, 12)];

    checkUrlArray.forEach(checkUrl => {
        switch (checkUrl) {
            case 'Actualite/Ajout':
                // console.log("required ActuAdd");
                var imgForm = document.getElementById("actualite_image");
                imgForm.required = true;
                break;
            case 'Realisation/Ajout':
                var imgForm = document.getElementById("realisation_image1");
                var imgForm2 = document.getElementById("realisation_image2");
                var imgForm3 = document.getElementById("realisation_image3");
                var imgForm4 = document.getElementById("realisation_image4");
                imgForm.required = true;
                imgForm2.required = true;
                imgForm3.required = true;
                imgForm4.required = true;
                break;
            case 'Equipe/Ajout':
                var imgForm = document.getElementById("equipe_image");
                imgForm.required = true;
                break;
            default:
        }
    });

}

function CheckIfValidateSuppression() {

    ButtonValidDelete = document.getElementById("delete_entity_admin_checkBox");
    ButtonDelete = document.getElementById("delete_entity_admin_submit");

    ButtonValidDelete.addEventListener("input", function() {
        ButtonDelete.disabled = !ButtonValidDelete.checked;
    });
}


function CheckSlug() {
    slugFrom = document.getElementById("actualite_title");
    slugTo = document.getElementById("actualite_slug");

    // Si slugFrom == null alors affecter slugfrom & slugto au bon id
    if (slugFrom == null) {
        slugFrom = document.getElementById("realisations_title");
        slugTo = document.getElementById("realisations_slug");
    }

    // console.log(slugFrom);
    // console.log(slugTo);
    if (slugFrom) {
        slugFrom.addEventListener("input", function() {
            slugTo.value = convertToSlug(slugFrom.value);
        });
    }
}

function convertToSlug(Text) {
    return Text
        .toLowerCase()
        .replace(/ /g, '-')
        .replace(/[^\w-]+/g, '');
}