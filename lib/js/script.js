
$( document ).ready(function(){

    $velden = 1;
    
    $(".user_count").keyup(function(){
        var amount = $(".user_count").val();
        for ($velden;$velden<amount;$velden++){
            
            $tussenprijs = '<div class="field dates"> <div class="input_label"> <label for="dates">Datum student '+($velden+1)+': </label> <input id="dates" name="dates[]" type="date" /> </div> </div>';
            $(".field-extra").before($tussenprijs);
        }

        
    });

});