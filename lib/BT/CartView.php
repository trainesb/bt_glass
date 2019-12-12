<?php


namespace BT;


class CartView extends View {

    private $cart;

    public function __construct(Site $site, &$session) {
        parent::__construct($site);

        if(isset($session['cart_item'])) {
            $this->cart = $session['cart_item'];
        } else {
            $this->cart = null;
        }

        $this->setTitle("Cart");
    }

    public function present() {
        echo $this->presentCart();
        echo $this->presentBillingAddress();
        echo $this->presentPayment();
        echo $this->presentShippingOption();
        echo $this->presentShipping();
        echo $this->presentTerms();
        echo $this->presentFinish();
    }

    public function presentCart() {
        $html = <<<HTML
<h1>CART</h1>
<div class="table-wrapper">
<table>
<thead>
    <tr>
        <th>Delete</th>
        <th>Code</th>
        <th>Name</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
</thead>
<tbody>
HTML;
        $total = 0;
        if($this->cart){
            foreach ($this->cart as $item) {
                $price = (int)($item['qty']*$item['price']);
                $total += $price;
                $code = $item["code"];
                $name = $item["name"];
                $url = $item["url"];
                $price = number_format($price, 2);
                $qty = $item["qty"];
                $html .= <<<HTML
<tr>
<td><i class="fa fa-trash" aria-hidden="true"></i></td>
<td>$code</td>
<td><p><a class="product-link" href="$url">$name</a></p></td>
<td><p><input id="qty" type="number" name="qty" value="$qty"></p></td>
<td>$$price</td>
</tr>
HTML;
            }
        }

        $total = number_format($total, 2);
        $html .= <<<HTML
</tbody>
<tfoot>
<tr id="total">
<th colspan="4">Total :</th>
<td>$$total</td>
</tr>
</tfoot>
</table>
</div>
<p><input id="checkout" type="button" value="Checkout"></p>
<p><input id="clear-cart" type="button" value="Clear"></p>
HTML;

        return $html;
    }

    public function presentBillingAddress() {
        return <<<HTML
<div class="billing-address-wrapper">
    <form class="billing-address-form" id="billing-address" hidden>
        <fieldset>
            <legend>Billing Address</legend>
            
            <p><label>First Name</label><br>
            <input required class="first-name" type="text" name="first-name" placeholder="First Name"></p>
            
            <p><label>Last Name</label><br>
            <input required class="last-name" type="text" name="last-name" placeholder="Last Name"></p>
            
            <p><label>M.I.</label><br>
            <input required class="mi" type="text" name="mi" minlength="1" maxlength="1" size="1" placeholder="M.I."></p>
            
            <p><label>Address</label><br>
            <input required class="address" type="text" name="address" placeholder="Address"></p>
            
            <p><label>City</label><br>
            <input required class="city" type="text" name="city" placeholder="City"></p>
            
            <p><label>State</label><br>
            <input required class="state" type="text" name="state" minlength="2" maxlength="2" size="2" placeholder="State"></p>
            
            <p><label>Zip Code</label><br>
            <input required class="zip" type="text" name="zip" minlength="5" maxlength="5" size="5" placeholder="Zip Code"></p>
            
        </fieldset>
    </form>
</div>
HTML;
    }

    public function presentPayment() {
        return <<<HTML
<div class="payment-wrapper">
    <form class="payment-form" id="payment" hidden>
        <fieldset>
            <legend>Payment</legend>
            
            <p><label>Name on Card</label><br>
            <input required class="name" type="text" name="name" placeholder="Name on Card"></p>
            
            <p><label>Card Number</label><br>
            <input required class="card-number" type="text" name="card-number" placeholder="Card Number"></p>
            
            <p><label>Exp.</label><br>
            <input required class="exp" type="text" name="exp" placeholder="MM-YY"></p>
            
            <p><label>CVV</label><br>
            <input required class="cvv" type="text" name="cvv" placeholder="CVV"></p>
            
        </fieldset>
    </form>
</div>
HTML;

    }

    public function presentShippingOption() {
        return <<<HTML
<div class="shipping-option-wrapper" hidden>
<p><input type="checkbox" id="shipping-option">Shipping Address is Different then Billing</p>
</div>
HTML;

    }

    public function presentShipping() {
        return <<<HTML
<div class="shipping-wrapper">
    <form class="shipping-form" id="shipping" hidden>
        <fieldset>
            <legend>Shipping Address</legend>
            
            <p><label>First Name</label><br>
            <input class="first-name" type="text" name="first-name" placeholder="First Name"></p>
            
            <p><label>Last Name</label><br>
            <input class="last-name" type="text" name="last-name" placeholder="Last Name"></p>
            
            <p><label>M.I.</label><br>
            <input class="mi" type="text" name="mi" minlength="1" maxlength="1" size="1" placeholder="M.I."></p>
            
            <p><label>Address</label><br>
            <input class="address" type="text" name="address" placeholder="Address"></p>
            
            <p><label>City</label><br>
            <input class="city" type="text" name="city" placeholder="City"></p>
            
            <p><label>State</label><br>
            <input class="state" type="text" name="state" minlength="2" maxlength="2" size="2" placeholder="State"></p>
            
            <p><label>Zip Code</label><br>
            <input class="zip" type="text" name="zip" minlength="5" maxlength="5" size="5" placeholder="Zip Code"></p>
            
        </fieldset>
    </form>
</div>
HTML;
    }

    public function presentTerms() {
        return <<<HTML
<div class="terms-wrapper" hidden>
<p><input type="checkbox" class="terms-chk">I agree to the <a class="terms-link" href="../bt/terms.php">Terms & Use</a>.</p>
</div>
HTML;
    }

    public function presentFinish() {
        return <<<HTML
<div class="finish-wrapper" hidden>
<div class="g-recaptcha" data-sitekey="6LdTyK8UAAAAAEYWwzq6qU7n6-v96YS06hBrIstS"></div>
<p><input type="button" id="finish" value="Pay"></p>
</div>
HTML;

    }
}