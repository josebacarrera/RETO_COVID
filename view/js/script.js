reto_covid.controller('login', function ($scope) {

    $scope.usuario;
    $scope.password;

    $scope.login = function (solicitud) {

        if (solicitud == 'loginTis') {
            console.log( $scope.fecha_nac.getUTCFullYear()+"-"+($scope.fecha_nac.getUTCMonth()+1)+"-"+($scope.fecha_nac.getUTCDate()+1))
            var data = {
                'solicitud': solicitud,
                'tis': $scope.tis,
                'fecha_nac': ($scope.fecha_nac.getUTCFullYear()+"-"+($scope.fecha_nac.getUTCMonth()+1)+"-"+($scope.fecha_nac.getUTCDate()+1))
            };
        } else if (solicitud == 'loginDni') {
            var data = {
                'solicitud': solicitud,
                'dni': $scope.dni,
                'password': $scope.password
            };
        } else if (solicitud == 'logout') {
            var data = {
                'solicitud': solicitud
            };
        }
        console.log(data)

        var url = "controller/cLogin.php";
        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'Content-Type': 'application/json' }

        }).then(res => res.json()).then(async function result () {

            loadContent(await getSession());

        }).catch(error => console.error('Error status:', error));

        return false;
    }

});
// Scroll up

document.getElementById("button-up").addEventListener("click", scrollUp);

function scrollUp(){

    var currentScroll = document.documentElement.scrollTop;

    if (currentScroll > 0){
        window.requestAnimationFrame(scrollUp);
        window.scrollTo (0, currentScroll - (currentScroll / 10));
    }
}

buttonUp = document.getElementById("button-up");

window.onscroll = function(){

    var scroll = document.documentElement.scrollTop;

    if (scroll > 500){
        buttonUp.style.transform = "scale(1)";
    }else if(scroll < 500){
        buttonUp.style.transform = "scale(0)";
    }

}
