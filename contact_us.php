<?php 
session_start();
$pageTitle = "Contact Us - BD Adventures";
include 'components/header.php';
include 'components/nav.php';
?>

<!-- Add this line in your header.php or directly here if needed -->
<link rel="stylesheet" href="css/contact.css">

<section class="destination-detail">
    <div class="detail-container">
        <h1>Contact Us</h1>
        <div class="contact-form-widget">
            <div class="form">
                <form name="contact-form">
                    <div style="text-align: center;">
                        <h3 style="font-family: inherit;"><b>Get in Touch</b></h3>
                    </div>
                    <p>
                        <span style="font-family: inherit;">
                            <span>আপনি চাইলে খুব সহজেই আমার সাথে&nbsp;</span>
                            <span>যোগাযোগ করতে পারেন।</span>
                            <span>&nbsp;নানা ভাবেই আমার সাথে যোগাযোগ </span>
                            <span>করতে পারেন যার মধ্যে সহচেয়ে সহজ মাধ্যম হল ইমেইল । ইমেইলের মাধ্যমে আপনার জিজ্ঞাসার উত্তর দেওয়ার চেষ্টা থাকবে।</span>
                        </span>
                    </p>
                    <p>
                        <span style="font-family: inherit;">
                            <span>এছারাও আপনি চাইলে সামাজিক&nbsp;</span>
                            <span>যোগাযোগ মাধ্যমেও</span>
                            <span>&nbsp;</span>
                            <span>আমার সাথে যোগাযোগ করতে পারেন।</span>
                            <span>সোশ্যাল মিডিয়াতে যোগাযোগ করার জন্য নিচে দেওয়া ইমেইল এড্রেস ফর্ম এবং সোশ্যাল মিডিয়া লিংকগুলো অনুসরণ করতে পারেন।</span>
                        </span>
                    </p>
                    
                    <h2 style="text-align: left;">
                        <span style="font-family: inherit; font-size: small;">
                            <span><b>Email Address</b></span>
                        </span>
                    </h2>
                    <p>
                        <a href="mailto:bikkhatobd.blog@gmail.com">admin@bikkhatobd.com</a>
                    </p>

                    <h3 style="text-align: left;">
                        <span style="font-family: inherit; font-size: small;">
                            <span><b>Social links</b></span>
                        </span>
                    </h3>
                    <ul style="text-align: left;">
                        <li>
                            <span style="font-family: inherit;">
                                <span><b><a href="https://www.facebook.com/profile.php?id=100026359747190" target="_blank">Facebook</a>&nbsp;</b></span>
                            </span>
                        </li>
                    </ul>

                    <p>
                        <span style="font-family: inherit;">
                            আমার ওয়েবসাইট&nbsp; "bikkhatobd.com" সম্পর্কে আপনার মন্তব্য, অভিযোগ বা মতামত থাকলে আমাকে
                            জানাতে পারেন, আপনার মতামতের যথাযথ মূল্যায়ন করব।
                        </span>
                    </p>
                    <p>
                        <span style="font-family: inherit;">
                            আমার ওয়েবসাইটের&nbsp;<a href="disclaimer.php">Disclaimer</a> সম্পর্কে এবং
                            <a href="privacy-policy.php">Privacy-Policy</a>&nbsp;আরও জানুন।
                        </span>
                    </p>

                    <hr style="background-color: green; height: 2px;" />
                    
                    <div>
                        <span style="font-family: inherit;">
                            আপনার নাম এবং যোগাযোগ করার বিস্তারিত আলোচনা করে আমাকে ইমেইল বা
                            মেসেজ করুন আপনার নাম ঠিকানা ইমেইল এড্রেস গোপনীয়তা বজায় থাকবে।
                        </span>
                    </div>

                    <div>
                        <h3>
                            <span style="font-family: inherit; font-size: small;">Contact Form</span>
                        </h3>
                    </div>

                    <p><span style="font-family: inherit;">Name</span></p>
                    <input class="contact-form-name" id="ContactForm_contact-form-name" name="name" size="30" type="text" value="" />

                    <p>
                        <span style="font-family: inherit;">Email<span style="font-weight: bolder;">*</span></span>
                    </p>
                    <input class="contact-form-email" id="ContactForm_contact-form-email" name="email" size="30" type="text" value="" />

                    <p>
                        <span style="font-family: inherit;">Message<span style="font-weight: bolder;">*</span></span>
                    </p>
                    <textarea class="contact-form-email-message" cols="25" id="ContactForm_contact-form-email-message" name="email-message" rows="5"></textarea>
                    <input class="contact-form-button contact-form-button-submit" id="ContactForm_contact-form-submit" type="button" value="Send" />

                    <div style="max-width: 222px; text-align: center; width: 100%;">
                        <p class="contact-form-error-message" id="ContactForm_contact-form-error-message"></p>
                        <p class="contact-form-success-message" id="ContactForm_contact-form-success-message"></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-content">
        <a href="index.php" class="btn">Go to Homepage</a>
    </div>
</section>

<?php include 'components/footer.php'; ?> 