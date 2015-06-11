<?php
include_once(BASE_PATH."/modules/class-ShoppingCart.php");
?>
<div class="container cart-container">
    <form id="cart-form" class="form-inline" action="checkout#checkout-form" method="post">
        <input type="hidden" id="decimal-length" value="<?php echo DECIMAL_LENGTH; ?>"/>
        <?php
        if(!empty($_SESSION["cart"])) {
            $items = ShoppingCart::getCartItems();
        }
        if(!empty($items)) {
            ?>
                <h2 class="page-header">
                    <span class="fa fa-fw fa-shopping-cart"> </span> Carrito de Compras
                </h2>
                <div class="cartmenu">
                    <a href="ajax/update-cart.php?action=emptycart" class="btn btn-danger" id="emptycart" data-toggle="tooltip" data-placement="bottom" title="Vaciar Carrito">
                        <span class="fa fw fa-trash-o"> </span>
                    </a>
                    <a class="btn btn-primary" href="cart" data-toggle="tooltip" data-placement="bottom" title="Refrescar">
                        <span class="fa fw fa-refresh"> </span>
                    </a>      
                    <!--<a id="save-cart-state" class="btn btn-success pull-right"><span class="fa fa-fw fa-save"> </span> Guardar cambios y seguir comprando</a>-->
                    <button class="btn btn-success" type="submit">
                        <span class="fa fa-fw fa-send"> </span> Continuar con el Pago
                    </button>
                </div>
                <hr/>
                <table class="table table-hover table-bordered">
                    <tr>
                        <th class="hidden-xs" style="width: 90px;">

                        </th>
                        <th>
                            Producto
                        </th>
                        <th class="hidden-xs">
                            Price
                        </th>
                        <th style="width: 90px;">
                            Cant
                        </th>
                        <th>
                            Sub - Total
                        </th>
                        <th style="width: 32px;">

                        </th>
                    </tr>
                <?php
                $total = 0;
                foreach($items as $product) {
                    $picture = $product["image"];
                    ?>	
                    <tr>
                        <td class="hidden-xs">
                            <?php 
                            if(!empty($picture)) {
                                ?>
                                <div class="image cart-list-picture" style="background-image: url('<?php echo $picture; ?>')"></div>
                                <?php
                            } else {
                                $picture = "../img/nopic.png";
                                ?>
                                <div class="image admin-product-list-picture" style="background-image: url('<?php echo $picture; ?>')"></div>
                                <?php
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo $product["title"]; ?>
                        </td>
                        <td class="hidden-xs">
                            $<?php echo number_format($product["price"], DECIMAL_LENGTH); ?>
                        </td>
                        <td>
                            <input type="text" name="qty[]" class="cart-qty number form-control" data-id="<?php echo $product["id"]; ?>" value="<?php echo $product["qty"]; ?>" size="4" maxlength="4">
                        </td>
                        <td>
                            <span id="lbl-sub-total-<?php echo $product["id"]; ?>">
                                <?php 
                                $sub =  floatval($product["price"]) * (int)$product["qty"];
                                $total += $sub;
                                echo "$".number_format($sub, DECIMAL_LENGTH);
                                ?>
                            </span>
                        </td>
                        <td>
                            <a href="ajax/update-cart.php?action=deleteitem&id=<?php echo $product["id"]; ?>" class="deletefromcart btn btn-sm btn-danger" data-id="<?php echo $product["id"]; ?>">
                                <span class="fa fa-fw fa-trash-o"> </span>
                            </a>
                        </td>
                    </tr>
                    
                    <input type="hidden" name="id[]" value="<?php echo $product["id"]; ?>"/>
                    <input type="hidden" id="product-price-<?php echo $product["id"]; ?>" value="<?php echo $product["price"]; ?>"/>
                    <input class="sub-total-val" type="hidden" id="sub-total-<?php echo $product["id"] ?>" value="<?php echo $sub; ?>"/>
                    
                    <?php
                }
                ?>
                </table>
                <div style="float: right; display: inline-block;">
                    <span id="lbl-cart-total"><b>Total:</b> $<span id="lbl-num-total"><?php echo number_format($total, DECIMAL_LENGTH)?></span></span>
                    <span id="lbl-cart-currency"><?php echo CURRENCY; ?></span>
                </div>
                <input id="input-total" type="hidden" name="total" value="<?php echo $total; ?>"/>
            <?php
        } else {
            ?>
            <div class="top-50 alert alert-warning text-center">
                <span class="fa fa-fw fa-shopping-cart"> </span> El carrito de compras esta vac&iacute;o en este momento
            </div>
            <?php
        }
        ?>
    </form>
</div>