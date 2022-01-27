
var reto_covid = angular.module('reto_covid', []);

reto_covid.controller('main', async function ($scope) {

    let session = await getSession();
    if (session)
        (session.sanitario) ? $scope.usuario = session.sanitario : $scope.usuario = session.paciente;

    loadContent(session);

    $scope.$digest();
});


function loadContent(session) {

    if (session) { // TIENE SESSION
        $('#formLogin').css('display', 'none')

        if (session.sanitario) { // SANITARIO
            $('#loggedSanitario').removeClass('d-none')
            $('#intranetCorporativa').removeClass('d-none')

        } else if (session.paciente) { // PACIENTE
            $('#loggedUser').removeClass('d-none')
            $('#carpetaSalud').removeClass('d-none')
        }
        else {
            $('#formLogin').css('display', 'block')
            $('#loggedSanitario').addClass('d-none')
            $('#loggedUser').addClass('d-none')
            $('#intranetCorporativa').addClass('d-none')
            $('#carpetaSalud').addClass('d-none')
        }
    } else { // NO TIENE SESSION
        $('#formLogin').css('display', 'block')
        $('#loggedSanitario').addClass('d-none')
        $('#loggedUser').addClass('d-none')
        $('#intranetCorporativa').addClass('d-none')
        $('#carpetaSalud').addClass('d-none')
    }
}


function getSession() { //RECOGE LAS VARIABLES DE SESSION

    $("#navbar").load("view/shared/navbar.html");
    $("#footer").load("view/shared/footer.html");

    return new Promise((resolve, reject) => {
        $.ajax({
            url: "controller/cSession.php",
            method: "GET",
            dataType: 'json',
            success: function (response) {
                console.log(response);
                resolve(response['SESSION']);
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
                reject();
            }
        })
    })
}


$(window).on('load', function () {
    setTimeout(function () {
        $(".loader-page").css({ visibility: "hidden", opacity: "0" })
    }, 500);
});


window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    $('#myBtn').css('display', 'block')

  } else {
    $('#myBtn').css('display', 'none')
  }
}

function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}