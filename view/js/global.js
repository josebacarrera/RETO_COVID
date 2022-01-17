function getSession() { //RECOGE LAS VARIABLES DE SESSION
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