<?php
/*
Template Name: Contact Form
*/
?>
<?php get_header(); ?>

<div class="container-wrap">

    <?php get_template_part('helper', 'page-cover'); ?>

    <section id="event" class="section-block contact">

        <div class="inner-block">
            <?php
            $nameError = '';
            $emailError = '';
            $commentError = '';
            ?>
            <form action="#event" method="post">
                <div class="grids">
                    <div class="grid-4">
                        <label for="contact_name"><?php _e('Your Name', 'stag'); ?>*</label>
                        <?php if($nameError != '') { ?>
                            <span class="error"><?php echo $nameError; ?></span>
                        <?php } ?>
                        <input type="text" id="contact_name" name="contact_name" required>
                    </div>

                    <div class="grid-4">
                        <label for="contact_email"><?php _e('Your Email', 'stag'); ?>*</label>
                        <?php if($emailError != '') { ?>
                            <span class="error"><?php echo $emailError; ?></span>
                        <?php } ?>
                        <input type="email" id="contact_email" name="contact_email" required>
                    </div>
                    <div class="grid-4">
                        <label for="contact_phone">Your Phone</label>
                        <input type="text" id="contact_phone" name="contact_phone">
                    </div>
                </div>

                <div class="grids textarea-wrap">
                    <div class="grid-12">
                        <label for="contact_message">Your Email*</label>
                        <?php if($commentError != '') { ?>
                            <span class="error"><?php echo $commentError; ?></span>
                        <?php } ?>
                        <textarea name="contact_message" id="contact_message" cols="30" rows="10" required></textarea>
                    </div>
                </div>

                <?php


                 if(isset($_POST['submit_message'])){

                    $phone = $_POST['contact_phone'];

                      if(trim($_POST['contact_name']) === '') {
                        $nameError = 'Please enter your name.';
                        $hasError = true;
                      } else {
                        $name = trim($_POST['contact_name']);
                      }

                      if(trim($_POST['contact_email']) === '')  {
                        $emailError = 'Please enter your email address.';
                        $hasError = true;
                      } else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['contact_email']))) {
                        $emailError = 'You entered an invalid email address.';
                        $hasError = true;
                      } else {
                        $email = trim($_POST['contact_email']);
                      }

                      if(trim($_POST['contact_message']) === '') {
                        $commentError = 'Please enter a message.';
                        $hasError = true;
                      } else {
                        if(function_exists('stripslashes')) {
                          $comments = stripslashes(trim($_POST['contact_message']));
                        } else {
                          $comments = trim($_POST['contact_message']);
                        }

                        if(!isset($hasError)) {
                          $emailTo = stag_get_option('general_contact_email');
                          if (!isset($emailTo) || ($emailTo == '') ){
                            $emailTo = get_option('admin_email');
                          }
                          $subject = '[Contact Form] From '.$name;
                          $body = "Name: $name \n\nEmail: $email \n\nComments: $comments";

                          if($phone != ''){
                            $body .= "\n\nPhone: $phone";
                          }

                          $body .= "\n\n--\nFrom site ".get_bloginfo('title');

                          $headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

                          mail($emailTo, $subject, $body, $headers);
                          $emailSent = true;
                        }
                      }

                } ?>

                <?php if(isset($emailSent) && $emailSent == true): ?>
                <div class="thanks">
                  <p><?php _e('Thanks, your message was sent successfully.', 'stag') ?></p>
                </div>
                <?php endif; ?>

                <div class="submit">
                  <input type="submit" class="" value="Send Message" name="submit_message">
                </div>
            </form>

            <!-- END .inner-block -->
        </div>

        <!-- END #event -->
    </section>

    <!-- BEGIN .container -->
    <div class="container">

        <?php if(have_posts()): while(have_posts()): the_post(); ?>

        <div class="entry-content center contact-page">

            <?php if(get_post_meta(get_the_ID(), '_stag_contact_secondary_title', true) != ''): ?>
                <h1 class="section-title"><?php echo get_post_meta(get_the_ID(), '_stag_contact_secondary_title', true); ?></h1>
            <?php endif; ?>

            <?php the_content(); ?>

            <?php if(get_post_meta(get_the_ID(), '_stag_contact_number', true) != '' || get_post_meta(get_the_ID(), '_stag_contact_email', true) != ''): ?>
                <div class="contact-details">
                    <span class="contact-number"><i class="icon icon-phone"></i> <?php echo get_post_meta(get_the_ID(), '_stag_contact_number', true); ?></span>
                    <span class="contact-email"><i class="icon icon-mail"></i> <a href="mailto:<?php echo get_post_meta(get_the_ID(), '_stag_contact_email', true); ?>"><?php echo get_post_meta(get_the_ID(), '_stag_contact_email', true); ?></a></span>
                </div>
            <?php endif; ?>

        </div>

        <?php endwhile; ?>
        <?php endif; ?>

        <!-- END .container -->
    </div>

</div>

<?php get_footer(); ?>