var slugFrom;
var slugTo;

window.onload = function() {
    slugFrom = document.getElementById("actualite_title");
    slugTo = document.getElementById("actualite_slug");

    console.log(slugFrom);
    console.log(slugTo);

    // Si slugFrom == null alors affecter slugfrom & slugto au bon id
    if (slugFrom == null) {
        slugFrom = document.getElementById("realisations_title");
        slugTo = document.getElementById("realisations_slug");
    }

    console.log(slugFrom);
    console.log(slugTo);
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