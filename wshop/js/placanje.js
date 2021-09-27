$("#card").change(function () {
    let element =
        `<div class = "container">
            <div class = "row">
                <div class="form-group col-md-6">
                    <label for="card_owner">Vlasnik kartice</label>
                    <input required type="text" name="cown" id="card_owner" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group col-md-6">
                    <label for="card_number">Broj kartice</label>
                    <input required type="text" name="cnum" id="card_number" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
            </div>
            <div class="row">
                <div class = "col-md-6">
                    <div class="form-group">
                        <label for="expires">Datum isteka (MM/YY)</label>
                        <input required type="text" name="cexp" id="expires" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>
                </div>
                <div class = "col-md-6">
                    <div class="form-group">
                        <label for="cvc">CVC broj</label>
                        <input required type="text" name="cvc" id="cvc" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>            
                </div>   
            </div>   
        </div>`
    $("#cardInfo").append(element)
})
$("#cash").change(function(){
    $("#cardInfo").empty()
})