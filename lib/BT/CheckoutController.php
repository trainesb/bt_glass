<?php


namespace BT;


class CheckoutController extends Controller {

    private $us_state_abbrevs = array('AL', 'AK', 'AS', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FM', 'FL', 'GA', 'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MH', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'MP', 'OH', 'OK', 'OR', 'PW', 'PA', 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'VA', 'WA', 'WV', 'WI', 'WY', 'AE', 'AA', 'AP');
    private $cart;
    private $billing;
    private $payment;
    private $shipping;
    private $user = null;

    public function __construct(Site $site, $post, &$session) {
        parent::__construct($site);

        $this->cart = $session['cart_item'];
        $this->billing = $post['billing'];
        $this->payment = $post['payment'];
        $this->shipping = $post['shipping'];

        $orders = new Orders($site);
        $order_num = $orders->getNxtOrderNum();

        $shippingTable = new ShippingTable($site);
        $billingTable = new BillingTable($site);
        $cardTable = new CardTable($site);
        $mapTable = new OrderUserMapTable($site);

        if(isset($session[User::SESSION_NAME])) {
            $this->user = $_SESSION[User::SESSION_NAME]->getId();
            $mapTable->add($order_num, $this->user);
        }


        $orders->add($order_num, $this->cart);
        $shippingTable->add($order_num, $this->shipping);
        $billingTable->add($order_num, $this->billing);
        $cardTable->add($order_num, $this->payment);

        $session['cart_item'] = null;

        $this->result = json_encode(["ok" => true, "order" => $order_num]);
    }

    public function validate_street_address($string) {
        $check_pattern = '/\d+ [0-9a-zA-Z ]+/';
        $has_error = !preg_match($check_pattern, $string);
// Returns boolean:
// 0 = False/ No error
// 1 = True/ Has error
        return $has_error;
    }

    protected function ValidCreditcard($number) {
        $card_array = array(
            'default' => array(
                'length' => '13,14,15,16,17,18,19',
                'prefix' => '',
                'luhn' => TRUE,
            ),
            'american express' => array(
                'length' => '15',
                'prefix' => '3[47]',
                'luhn' => TRUE,
            ),
            'diners club' => array(
                'length' => '14,16',
                'prefix' => '36|55|30[0-5]',
                'luhn' => TRUE,
            ),
            'discover' => array(
                'length' => '16',
                'prefix' => '6(?:5|011)',
                'luhn' => TRUE,
            ),
            'jcb' => array(
                'length' => '15,16',
                'prefix' => '3|1800|2131',
                'luhn' => TRUE,
            ),
            'maestro' => array(
                'length' => '16,18',
                'prefix' => '50(?:20|38)|6(?:304|759)',
                'luhn' => TRUE,
            ),
            'mastercard' => array(
                'length' => '16',
                'prefix' => '5[1-5]',
                'luhn' => TRUE,
            ),
            'visa' => array(
                'length' => '13,16',
                'prefix' => '4',
                'luhn' => TRUE,
            ),
        );

        // Remove all non-digit characters from the number
        if (($number = preg_replace('/\D+/', '', $number)) === '')
            return FALSE;

        // Use the default type
        $type = 'default';

        $cards = $card_array;

        // Check card type
        $type = strtolower($type);

        if (!isset($cards[$type]))
            return FALSE;

        // Check card number length
        $length = strlen($number);

        // Validate the card length by the card type
        if (!in_array($length, preg_split('/\D+/', $cards[$type]['length'])))
            return FALSE;

        // Check card number prefix
        if (!preg_match('/^' . $cards[$type]['prefix'] . '/', $number))
            return FALSE;

        // No Luhn check required
        if ($cards[$type]['luhn'] == FALSE)
            return TRUE;

        return $this->luhn($number);

    }

    protected function luhn($number) {
        // Force the value to be a string as this method uses string functions.
        // Converting to an integer may pass PHP_INT_MAX and result in an error!
        $number = (string)$number;

        if (!ctype_digit($number)) {
            // Luhn can only be used on numbers!
            return FALSE;
        }

        // Check number length
        $length = strlen($number);

        // Checksum of the card number
        $checksum = 0;

        for ($i = $length - 1; $i >= 0; $i -= 2) {
            // Add up every 2nd digit, starting from the right
            $checksum += substr($number, $i, 1);
        }

        for ($i = $length - 2; $i >= 0; $i -= 2) {
            // Add up every 2nd digit doubled, starting from the right
            $double = substr($number, $i, 1) * 2;

            // Subtract 9 from the double where value is greater than 10
            $checksum += ($double >= 10) ? ($double - 9) : $double;
        }

        // If the checksum is a multiple of 10, the number is valid
        return ($checksum % 10 === 0);
    }
}