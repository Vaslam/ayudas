/*
 * -- Shopping cart module
 */

var cartUrl = "ajax/update-cart.php";
var decimalLength = parseInt($("#decimal-length").val()) || 0;

//Thanks to PHPJS.ORG for this wonderful function :)
//Javascript equivalent to number_format PHP function
function number_format(number, decimals, dec_point, thousands_sep) { 
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
      prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
      sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
      dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
      s = '',
      toFixedFix = function(n, prec) {
        var k = Math.pow(10, prec);
        return '' + (Math.round(n * k) / k)
          .toFixed(prec);
      };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
      .split('.');
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
      .length < prec) {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1)
        .join('0');
    }
    return s.join(dec);
}

function updateTotals() {
    var total = 0;
    $(".sub-total-val").each(function() {
        //console.log(parseInt($(this).val())); //Debug
        total += parseInt($(this).val());
    });
    $("#lbl-num-total").html(number_format(total, decimalLength));
    $("#input-total").val(total);
}

function getCartCount() {
    return $.ajax({
        url: cartUrl,
        data: {
            action: "getcount"
        },
        type: "POST"
    });
}

function emptyCart() {
    return $.ajax({
        url: cartUrl,
        data: {
            action: "emptycart"
        },
        type: "POST"
    });
}

$(".cart-qty").on("keyup focus blur" ,function(){
    var rowId = $(this).attr("data-id");
    var productPrice = parseInt($("#product-price-"+rowId).val());
    var qty;
    if(parseInt($(this).val()) == 0) { //Avoids leaving this field in 0
        qty = 1;
        $(this).val("1");
    } else {
        qty = parseInt($(this).val());
    }
    var newValue = productPrice * qty;
    //console.log(productPrice);
    //console.log(qty);
    //console.log(newValue);
    $("#lbl-sub-total-"+rowId).html("$"+number_format(newValue, decimalLength));
    $("#sub-total-"+rowId).val(newValue);
    updateTotals();
});

if(document.getElementById("cart-form")) {
    //$("#save-cart-state").click(function() {
    window.onbeforeunload = function() {
        var prods = {};
        var prodId;
        var qty;
        var i = 0;
        $(".cart-qty").each(function() {
            prodId = $(this).attr("data-id");
            qty = $(this).val();
            prods[i] = {id: prodId, qty: qty}
            i++;
        });
        //console.log(JSON.stringify(prods)); //Debug
        $.post(
            cartUrl, 
            {
                action: "updateqty",
                prods: JSON.stringify(prods)
            });
    };
}

$(".addtocart").click(function() {
    //console.log("Add To Cart clicked"); //Debug
    var productId = $(this).attr("data-id");
    $.post(
        cartUrl,
        {
            action: "add",
            productid: productId
        },
        function(data) {
            //console.log(data);
            if(parseInt(data) == 1) { //Success
                alert("Elemento agregado al carrito!");
                getCartCount().done(function(c) {
                    $("#lbl-cart-count").html(c);
                });
            } else { //Fail
                alert("ERROR: Hubo un problema al intentar agregar el elemento al carrito. Por favor comprobar en un rato.");
            }
        });
});

/*
 * -- TEMPORAL SOLUTION TO AJAX PROBLEMS WITH IE AND CHROME
 */
$(".deletefromcart").click(function(e) {
    e.preventDefault();
    if(confirm("Eliminnar elemento del carrito?")) {
        window.location = $(this).attr("href");
    }
});

$("#emptycart").click(function(e) { 
    e.preventDefault();
    if(confirm("Eliminnar todos los elementos del carrito?")) {
        window.location = $(this).attr("href");
    }
});

/*
$("#emptycart").click(function() {
    var resp = confirm("Eliminar todos los elementos del carrito?");
    //console.log(resp);
    
    if(resp === true) {
        emptyCart().done(function(data) {
            alert(data);
           //location.reload(); 
        });
    }
    
});

$(".deletefromcart").click(function() {
    var resp = confirm("Eliminar elemento del carrito?");
    if(resp === true) {
        var productId = $(this).attr("data-id");
        $.post(
            cartUrl,
            {
                action: "deleteitem",
                id: productId
            }
        ).done(function() {
            //console.log(data);
            location.reload();
        }); 
        
    }
});
*/