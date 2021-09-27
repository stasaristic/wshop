let catSelect
$(document).ready(function () {
    catSelect = $("#category")
    console.log(catSelect)
})

function enableManualCatSelect() {
    if($(event.target).val() == -1){
    let element = `<div class="form-group" id="category">
                            <input type="text" class="form-control" id="catname" name="cat">
                            <button type = "button" class = "btn btn-primary my-3 btn-block" onclick = 'enableCatSelect()'>Vrati se na ponudjene kategorije</button>
                            </div>`

    $(event.target).parent().append(element)
    $(event.target).remove()
    console.log("here")
    }
}

function enableCatSelect() {
    let element = catSelect
    $("#catname").remove()
    $(event.target).parent().prepend(element)
    $(event.target).remove()
    console.log("here")
}

function addToCart(product_id) {
    $.ajax({
        "url": "server.php",
        type: "POST",
        dataType: "json",
        data: {
            "product_id": product_id,
            "add_to_cart": 1
        },
        success: function (response) {
            $("#messages").empty()
            $("#messages").append(`<div class="alert alert-primary alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong>Uspeh!</strong> ${response.msg} 
            </div>`)
            $("#cartCount").text(response.count)
        },
        error: function (response) {}
    })
}

function removeFromCart(product_id) {
    $.ajax({
        "url": "server.php",
        type: "POST",
        dataType: "json",
        data: {
            "product_id": product_id,
            "remove_from_cart": 1
        },
        success: function (response) {
            $("#messages").empty()
            $("#messages").append(`<div class="alert alert-primary alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong>Uspeh!</strong> ${response.msg} 
            </div>`)
            $("#cartCount").text(response.count)
            location.reload()

        },
        error: function (response) {}
    })
}

function emptyCart() {
    $.ajax({
        "url": "server.php",
        type: "POST",
        dataType: "json",
        data: {
            "empty_cart": 1
        },
        success: function (response) {
            $("#messages").empty()
            $("#messages").append(`<div class="alert alert-primary alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong>Uspeh!</strong> ${response.msg} 
            </div>`)
            $("#cartCount").text(0)
            location.reload()
        },
        error: function (response) {}
    })
}

function removeProduct(product_id) {
    $.ajax({
        "url": "server.php",
        type: "POST",
        dataType: "json",
        data: {
            "remove_product": 1,
            "product_id": product_id
        },
        success: function (response) {
            $("#messages").empty()
            $("#messages").append(`<div class="alert alert-primary alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong>Uspeh!</strong> ${response} 
            </div>`)
            setTimeout(() => {
                location.reload()
            }, 750);
        },
        error: function (response) {}
    })
}

function showRates(product_id) {
    $("#addProduct").toggle()
    $("#productReviews").toggleClass("d-none")
    if ($("#productReviews").hasClass("d-none")) {
        $(event.target).text("Prikazi")
    } else {
        $(event.target).text("Sakrij")
    }
    $("#productReviews").empty()


    $.ajax({
        url: "server.php",
        type: "POST",
        dataType: "json",
        data: {
            "product_id": product_id,
            "get_reviews": 1
        },
        success: function (response) {
            response.forEach(review => {
                let rate = ""
                for (let i = 0; i < 5; i++) {
                    if (i < review.grade) {
                        rate += "<i class = 'fa fa-star text-primary'></i>"
                    } else {
                        rate += "<i class = 'fa fa-star-o text-primary'></i>"
                    }
                }
                let rw = `<div class="card border-grey my-3">
                                    <div class="card-header d-flex justify-content-between">
                                        <div>
                                            ${review.username} <br>
                                            ${rate}
                                        </div>
                                        ${new Date(review.review_date).toLocaleDateString()}
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">${review.review}</p>
                                    </div>
                                </div>`
                $("#productReviews").append(rw)
            });

        },
        error: function (response) {

        }
    })
}

function removeRating(review_id) {
    $.ajax({
        url: "server.php",
        type: "POST",
        dataType: "json",
        data: {
            "review_id": review_id,
            "remove_review": 1
        },
        success: function (response) {
            $("#deleteResult").append(`<div class="alert alert-primary alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>Uspesno uklonjena ocena.</strong>
            </div>`)
            setTimeout(() => {
                location.reload();
            }, 1000);
        }
    })
}