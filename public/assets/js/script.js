var resMax = window.matchMedia("(max-width: 768px)");
//DisableDropDown(resMax); // Call listener function at run time
//var intervalle = setInterval(DisableDropDownAtStart, 100);
var refreshButtonRef = document.getElementById("refreshBut");

window.onload = function DisableDropDownAtStart() {
    DisableDropDown(resMax);
    //    clearInterval(intervalle);
}
window.onresize = function() { DisableDropDown(resMax) };

function DisableDropDown(x) {
    var div = document.getElementById("dropdownMenu");

    if (x.matches) { // If media query matches
        if (div != null) {
            if (div.classList.contains("dropdown")) {
                div.classList.remove("dropdown");
            }
        }


    } else {
        if (div != null) {
            if (!div.classList.contains("dropdown")) {
                div.classList.add("dropdown");
            }
        }
    }
}

//Contact-Form
// $('#contact-form').submit(function(e) {
//     e.preventDefault();
//     $('.comments').empty();
//     var postdata = $('#contact-form').serialize();
//     console.log("okay");
//     $.ajax({
//         type: 'POST',
//         url: 'contactFormulaire.php',
//         data: postdata,
//         dataType: 'json',
//         success: function(json) {

//             if (json.isSuccess) {
//                 $('#contact-form').append("<p class='thank-you'>Votre message a bien été envoyé. Merci de nous avoir contacté :)</p>");
//                 $('#contact-form')[0].reset();
//             } else {
//                 $('#name + .comments').html(json.firstnameError);
//                 $('#company + .comments').html(json.nameError);
//                 $('#email + .comments').html(json.emailError);
//                 $('#phone + .comments').html(json.phoneError);
//                 $('#message + .comments').html(json.messageError);
//             }
//         }
//     });
// });



//window.onload = function SetElementsInvisible(){
//    var elem = document.getElementsByClassName("Invisible");
//    $(elem).hide();
//
////    elem.forEach(function(item, index, array){
////        item.style.display = "none";
////    });
//    
////    document.getElementsByClassName("Invisible").style.display = "none";
////    alert("Execute Javascript Code");
//    console.log("invisble");
//}

function SetElementsInvisible2() {
    var elem = document.getElementsByClassName("Invisible");
    $(elem).hide();

    //    elem.forEach(function(item, index, array){
    //        item.style.display = "none";
    //    });

    //    document.getElementsByClassName("Invisible").style.display = "none";
    //    alert("Execute Javascript Code");
    console.log("invisble");
}