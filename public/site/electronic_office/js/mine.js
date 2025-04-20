$(document).ready(function(){
  $(".mini-cart").click(function(){
    $(".widget-shopping-cart-content").toggle();
  });
});



$(function() {
    $('#navbarDropdown2').hover(function() { 
        $('#div2').show(); 
    }, function() { 
        $('#div2').hide(); 
    });
});


$(function() {
    $('#navbarDropdown1').hover(function() { 
        $('#div1').show(); 
    }, function() { 
        $('#div1').hide(); 
    });
});



$(document).ready(function(){
  $("#trackorder").click(function(){
    $("#links-navs").hide()&&
            $(".sec-product").hide()&&
        $("#sec-navs").show()
  });
 
});


$(document).ready(function(){
  $("#ShoppingBag").click(function(){
            $(".sec-product").hide()&&
        $("#sec-navs").show()
  });
 
});


$(document).ready(function(){
  $("#SignIn").click(function(){
    $("#links-navs").hide()&&
            $(".sec-product").hide()&&
        $("#sec-navs").show()
  });
 
});

$(document).ready(function(){
  $(".btn-add").click(function(){
    $(".btn-add").hide()&&
            $("#addedd").show()&&
        $("#addmore").show()
        
  });
 
});