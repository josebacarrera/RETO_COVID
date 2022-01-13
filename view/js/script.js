
var reto_covid = angular.module('reto_covid', []);
reto_covid.controller('loginController', function ($scope) {

    $scope.usuario;
    $scope.password;

    $scope.login = function () {

        var url = "controller/cLogin.php";
        var data = {
                        'solicitud':'loginDni',
                        'usuario':$scope.usuario,
                        'password':$scope.password
                    };

        fetch(url, {
              method: 'POST',
              body: JSON.stringify(data),
              headers:{'Content-Type': 'application/json'}  
              
        }).then(res => res.json()).then(result => {
    
            console.log(result);
    
        }).catch(error => console.error('Error status:', error));
        
        return false;    
    };
});

reto_covid.controller('carouselController', ($scope) => {

    var arrCard = new Array(1,2,3,4,5,6,7,8,9,10);
    var activeArr = new Array();
    var numItem = 3;
    var currentPrimaryCard = 0;

    for (var i = 0; i < numItem; i++) {
        activeArr.push(arrCard[i]);
    }

    $scope.nextSlide = () => {

    }

    $scope.prevSlide = () => {
        
    }

    console.log(activeArr);
    
});






$(document).ready(test);

var numItems = 3;
var currentPrimaryElement = 0;



function test() {
    
    for (var i = 0; i < numItems; i++) {
        $('.item')[i].classList.add("active");   
    }

    hideItem();

    document.querySelectorAll(".carousel-control").forEach(element => {
        element.addEventListener("click", changeSlide);
    });

}

function limpiarSlide(){ //LIMPIA EL SLIDE
    for (var i = 0; i < $('.item').length; i++) {
        $('.item')[i].classList.remove("active");
        $('.item')[i].style.order = -1;        
    }
}

function changeSlide() {

    var changeType = $(event.target).attr('data-slide'); // PREV OR NEXT
    limpiarSlide();
    if (changeType == "next") {
        currentPrimaryElement++;
        var slidetimes = currentPrimaryElement + numItems;
        var oversize = slidetimes -  $('.item').length; //num slides que se ha pasado
        if (slidetimes > $('.item').length) { //Cuando se pasa de...
            
            if (oversize == numItems) {
                currentPrimaryElement = 0;
                slidetimes = numItems;
                oversize = -1;
                limpiarSlide();
                
            } else {
                for (var i = 0; i < oversize; i++) {
                $('.item')[i].classList.add("active");
                $('.item')[i].style.order = i;
                console.log("order: " + i)                    
                }
            }
  
        }
        console.log("Sobresale:" + oversize);
        console.log("Posicion: " + currentPrimaryElement);

        if (oversize < 1) {
            for (var i = currentPrimaryElement; i < slidetimes; i++) {
                $('.item')[i].classList.add("active");     
            }
        } else {
            for (var i = currentPrimaryElement; i < $('.item').length; i++) {
                $('.item')[i].classList.add("active");     
            }
        }


        
    } else if (changeType == "prev") {
        limpiarSlide();
        currentPrimaryElement--;
        if (currentPrimaryElement < 0) {currentPrimaryElement = $('.item').length;} //Evita que se rompa
        
        var oversize = currentPrimaryElement - numItems;

        if (oversize > 0){
            for (var i = 0; i < oversize; i++) {
                $('.item')[i].classList.add("active");     
            }
            for (var i = 0; i < (numItems - oversize); i++) {
                $('.item').get().reverse()[i].classList.add("active");     
            }
            
        }

        if (oversize == 0) {
            for (var i = 0; i < numItems; i++) {
                $('.item').get().reverse()[i].classList.add("active");     
            }
        }

        if (oversize < 0) {
            for (var i = currentPrimaryElement; i < (currentPrimaryElement + numItems); i++) {
                $('.item').get().reverse()[i].classList.add("active");     
            }
        }


        console.log("Positon: " + currentPrimaryElement);
        console.log("Slides: " + oversize);
        
    }

    hideItem();

}

function hideItem() {
    Array.from($('.item')).forEach(element => {
        element.style.display = 'none';
    });
    Array.from($('.item.active')).forEach(element => {
        element.style.display = 'block';
    });
}




