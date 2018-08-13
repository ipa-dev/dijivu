<?php /* Template Name: Plan Buy */ ?>
<?php if(is_user_logged_in()) { ?>
<?php if(get_field('price', $_GET['palnid']) != 0) { ?>
<?php get_header(); ?>
<?php global $user_ID; ?>
<?php $user_info = get_userdata($user_ID); ?>
<div id="my_account">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_2_of_12">
                <?php get_sidebar('accnav'); ?>                                      
	        </div>
	        <div class="col span_10_of_12"> 
<?php
$price = get_field('price', $_GET['palnid']);
require TEMPLATEPATH.'/stripelib/Stripe.php';
if ($_POST) {
  Stripe::setApiKey('sk_test_Wpbzd7anzuZefMrGUHdAk5Db');
  $error = '';
  $success = '';
  try {
    if (!isset($_POST['stripeToken']))
      throw new Exception("The Stripe Token was not generated correctly");
    $charge = Stripe_Charge::create(array("amount" => ($price*100),
                                "currency" => "usd",
                                "card" => $_POST['stripeToken']));
    $success = 'Your payment was successful.';
  }
  catch (Exception $e) {
    $error = $e->getMessage();
  }
  //print_r($charge);
  if ($charge->paid == true) {
    //echo $charge->paid;
    echo "Success";
    header("Location: ".get_bloginfo('url')."/payment-success/?planid=".$_GET['palnid']);
  } else {    
    header("Location: ".get_bloginfo('url')."/payment-failure/");
  }
}
?>
                <div id="acc_section">
                    <!-- to display errors returned by createToken -->
                    <span class="payment-errors"><?php $error ?></span>
                    <span class="payment-success"><?php $success ?></span>
                    <form action="" method="POST" id="payment-form">
                        <p>
                            <label>Card Number</label>
                            <input type="text" size="20" autocomplete="off" class="card-number" />
                        </p>
                        <p>
                            <label>CVC</label>
                            <input type="text" size="4" autocomplete="off" class="card-cvc" placeholder="CVC" />
                        </p>
                        <p>
                            <label>Expiration (MM/YYYY)</label>
                            <input type="text" size="2" class="card-expiry-month" placeholder="MM" maxlength="2"/>
                            <span> / </span>
                            <input type="text" size="4" class="card-expiry-year" placeholder="YY" maxlength="2"/>
                        </p>
                        <p>
                        <button type="submit" class="submit-button more_btn">Submit Payment</button>
                        </p>
                    </form>
                </div>                   
	        </div>
	    </div>
	</div>
</div>
<?php get_footer(); ?>
<?php } else {
    update_user_meta($user_ID, 'plan', $_GET['palnid']);
    header('Location: '.get_bloginfo('home').'/my-account'); 
} ?>
<?php } else {
   header('Location: '.get_bloginfo('home').'/login'); 
} ?>