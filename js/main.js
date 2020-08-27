$(document).ready(function(){

    //Functions for rating the character after clicking on a star
    $("#characters").on("change", ".rate", function(e, data){
        characterRate(data.to, $(this).attr('alt'));
    });

    $("#portal").on("change", ".rate", function(e, data){
        characterRate(data.to, $(this).attr('alt'));
    });

    //Function for rating (call ajax function)
    function characterRate(rate, character_id) {
        $.ajax({
			url: "components/ajax/rate_character.php",
			method: "post",
			data: {
                rate : rate,
                character_id : character_id
			},
			dataType: "json",
			success: function(res) {
                console.log(res);
			}
        })
    }

    
    //Function for searching characters, called after form is submitted
    $("#search-form").submit(function(){

        //Remove form margin
        $("#search-form").css("margin-top", "0");

        //Ajax call
        $.ajax({
			url: "components/ajax/search_characters.php",
            method: "post",
            
            //Data for searching
			data: {
				content : $("#searchInput").val(),
				status : $("#searchSelectStatus").val(),
				gender : $("#searchSelectGender").val()
			},
            dataType: "json",
            
			success: function(res) {

                console.log(res);

                //Counter for detecting columns
                var counter = 0;

                //String for putting in characters div
                var characters = ""

                //For each character, create HTML data with grid system
				$.each( res, function( key, value ) {
                    var character_div = "";
                    if (counter % 4 == 0) {character_div += "<div class='row'>";}
                    character_div += "<div class='col'>";
                    character_div += "<div class='card mb-3 character rounded-0' style=''>";
                    character_div += "<img src='" + res[key]['image'] + "' class='card-img-top rounded-0'></img>";
                    character_div += "<div class='card-body'>";
                    character_div += "<h5 class='card-title mb-0 mt-2 osr'>" + res[key]['name'] + "</h5>";
                    character_div += "<div class='rate my-0 py-0' data-rate-value="+res[key]['rate']+" alt='"+res[key]['id']+"'></div>";
                    character_div += "</div></div></div>";
                    if (counter % 4 == 3) {character_div += "</div>";}
                    characters += character_div;
                    counter += 1;
                });

                //Putting data to characters div
                $("#characters").html(characters);

                //Creating rate bar for each character
                var options = {
                    max_value: 5,
                    step_size: 1,
                }
                $(".rate").rate(options);
			}
        })
        
        //Disable form refreshing
        return false;
    });


    //Lucky portal button
    $("#searchLucky").click(function(){
        $.ajax({
			url: "components/ajax/search_characters.php",
			method: "post",
			data: {
				content : $("#searchInput").val(),
				status : $("#searchSelectStatus").val(),
				gender : $("#searchSelectGender").val()
			},
			dataType: "json",
			success: function(res) {

                //Show and animate the portal
                $("#portal").show();
                $("#portal img").animate({
                    padding: '0'
                }, "slow");

                //Get random character
                var character = res[Math.floor(Math.random() * res.length)];

                //Put random character to portal
                $("#portal .portal-body div").html("<img src='"+character['image']+"' class='rounded-circle'></img><div class='name mt-3'>" + character['name'] + "</div><div class='rate' data-rate-value="+character['rate']+" alt='"+character['id']+"'></div><div class='btn btn-danger btn-sm'>Close</div>");

                //Another animation
                $("#portal .portal-body div img").animate({
                    width: '300px',
                    height: '300px',
                    margin: '0 0 0 0' 
                }, "slow");

                //Timeout just for visual reasons
                setTimeout(function(){
                    $("#portal .portal-body div div").show();
                    var options = {
                        max_value: 5,
                        step_size: 1,
                    }
                    $(".rate").rate(options);
                }, 600);
                

			}
        })
    });

    //Hide lucky portal
    $("#portal").on("click", ".btn", function(){
        $("#portal").hide();
        $("#portal img").css("padding", "100%");
    });

    //Logout button
    $("#logoutButton").click(function(){
        Cookies.remove('user');
        location.reload();
    });


    //Login form
    $("#login-form").submit(function(){
        $.ajax({
			url: "components/ajax/login.php",
			method: "post",
			data: {
				email : $("#loginEmail").val(),
				password : $("#loginPassword").val()
			},
			dataType: "json",
			success: function(res) {

                //Change input border color if an error occurred
                if (res[0] > 0) {
                    $("#login-form input").addClass("error");
                    alert(res[1]);
                }

                //If everything is ok, refresh page
                if (res[0] == 0) {
                    location.reload();
                }
			}
        })

        //Disable form refreshing
        return false;
    });

    //Change input border color to normal after click
    $("#login-form input").click(function(){
        $(this).removeClass("error");
    });


    //Register form
    $("#register-form").submit(function(){
        $.ajax({
			url: "components/ajax/register.php",    //Plik zwracający dane z dialami w postaci JSON
			method: "post",
			data: {
				email : $("#registerEmail").val(),
				password : $("#registerPassword").val(),
				passwordrepeat : $("#registerRepeatPassword").val()
			},
			dataType: "json",
			success: function(res) {

                //Change input border color if an error occurred
                if (res[0] == 1) {
                    $("#register-form input").addClass("error");
                    alert(res[1]);
                }

                //Change input border color if an error occurred. But only for password repeat field
                if (res[0] == 2) {
                    $("#registerRepeatPassword").addClass("error");
                    alert(res[1]);
                }

                //If everything is ok, refresh page
                if (res[0] == 0) {
                    location.reload();
                }
			}
        })

        //Disable form refreshing
        return false;
    });


});