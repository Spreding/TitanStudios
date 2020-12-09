var nbIte = 1;
$(document).ready(function() {
    $("#refreshBut").on("click", function(event) {
        $.ajax({
            url: '/',
            type: 'POST',
            data: { data: nbIte },
            dataType: 'json',
            async: true,

            success: function(data, status) {
                for (let index = 0; index < data.length; index++) {

                    var actu = $(`<div class="containActu col-12 col-md-6 "> <a href="/actualite/${data[index]["slug"]}" class="linkActu"><div class="Actu"> <div class="article row"><img src="\\uploads\\${data[index]["image"]}" class="insideArticle col-5"/><div class="col-7"><h4>${data[index]["title"]}</h4><p class="txtActu">${data[index]["description"]}</p></div></div></div> </a></div>`);
                    $('#actuContainer').append(actu);

                    if (data[index]['last']) {
                        $("#refreshBut").hide();
                    }

                }
                nbIte++;

            },
            error: function(xhr, textStatus, errorThrown) {
                alert('Ajax request failed.');
            }
        });
    });
});







// var maxIte = 4;
// function RefreshActualite() {
//     console.log("refresh");
//     //    var elem = document.getElementsByClassName("Invisible");
//     //    console.log(elem.length);

//     var elem = $(".Invisible");
//     var ite = 0;
//     if (elem.length < maxIte) {
//         ite = elem.length;

//     } else {
//         ite = maxIte;
//     }

//     elem.slice(0, ite).removeClass("Invisible");
//     var elem2 = elem.slice(ite);

//     if (elem2.length == 0) {
//         $("#refreshBut").hide();
//     }
//     //    for (let i = 0; i < 4; i++) {
//     //  elem[i]
//     //}
// }