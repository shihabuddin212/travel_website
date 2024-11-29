<?php 
session_start();
$pageTitle = "About Us - BD Adventures";
include 'components/header.php';
include 'components/nav.php';
?>

<style>
.about-section {
    padding: 80px 0;
    background: linear-gradient(to bottom, #ffffff, #f8f9fa);
}

.about-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.about-header {
    text-align: center;
    margin-bottom: 50px;
}

.about-header h1 {
    font-size: 2.5rem;
    color: #2A9D8F;
    margin-bottom: 20px;
    position: relative;
    display: inline-block;
}

.about-header h1:after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background-color: #FFB703;
}

.about-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-bottom: 50px;
}

.about-text {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.about-text p {
    line-height: 1.8;
    margin-bottom: 20px;
    color: #264653;
}

.about-text b {
    color: #2A9D8F;
}

.declaration-section {
    background: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin-top: 40px;
}

.declaration-section h2 {
    color: #2A9D8F;
    margin-bottom: 25px;
    font-size: 1.8rem;
}

.declaration-list {
    background: #f8f9fa;
    padding: 25px 40px;
    border-radius: 8px;
    margin: 20px 0;
}

.declaration-list li {
    margin-bottom: 15px;
    color: #264653;
    position: relative;
    padding-left: 20px;
}

.declaration-list li:before {
    content: '•';
    color: #FFB703;
    position: absolute;
    left: 0;
    font-size: 1.2em;
}

.home-button {
    text-align: center;
    margin-top: 40px;
}

.home-button .btn {
    display: inline-block;
    padding: 15px 30px;
    background-color: #2A9D8F;
    color: white;
    text-decoration: none;
    border-radius: 30px;
    transition: all 0.3s ease;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.home-button .btn:hover {
    background-color: #264653;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(42,157,143,0.3);
}

@media (max-width: 768px) {
    .about-content {
        grid-template-columns: 1fr;
    }
    
    .about-header h1 {
        font-size: 2rem;
    }
    
    .declaration-section {
        padding: 25px;
    }
}
</style>

<section class="about-section">
    <div class="about-container">
        <div class="about-header">
            <h1>About Us</h1>
        </div>
        
        <div class="about-content">
            <div class="about-text">
                <p>
                    আমি <b>বিখ্যাত বিডি</b> ওয়েবসাইটটির একমাত্র মালিক।আমি ঘুরতে পছন্দ করি এবং মাতৃভাষায়
                    দেশের দর্শনীয় স্থান, বিভিন্ন জেলা এবং বাংলাদেশের সকল মার্কেট নিয়ে লিখালিখি
                    করি। দেশ সম্পর্কে পড়ুন, জানুন, শিখুন, মতামত দিন। সর্বোপরি সাথেই থাকুন। জানার
                    ইচ্ছাকে সহজ, সরল করে তুলতে নির্ভুল তথ্য দিয়ে সহযোগিতা করে একযুগে এগিয়ে যাওয়াই
                    আমাদের লক্ষ্য।কারন আপনার চাহিদা আমাদের জন্য মূল্যবান।
                </p>
            </div>
            
            <div class="about-text">
                <p>
                    I am the sole owner of the BikkhatoBD website. I love to travel and write
                    about the country's attractions, different districts and all the markets of
                    Bangladesh in mother tongue. Read, know, learn, comment about the country. By
                    all means stay tuned. My mission is to advance in the era by collaborating
                    with accurate information to make the desire to know easy, simple. Because
                    your needs are valuable to us.
                </p>
            </div>
        </div>

        <div class="declaration-section">
            <h2>My Website Declaration</h2>
            <p>
                আমার এই ওয়েবসাইটে( bikkhatobd.com) কোন ব্যক্তি, সমাজ, ধর্ম ও সম্প্রদায় কে
                কটাক্ষ, ব্যঙ্গ-বিদ্রূপ ও হেয় প্রতিপন্ন করে কিছু পাবলিশ হয় না। এই ধরনের কোন
                কনটেন্ট যদি ভুলবসত প্রকাশিত হয়ে থাকে এবং তা আপনার কাছে এরকম মনে হয় যে এই তথ্য
                ইন্টারনেট থাকলে
            </p>
            
            <ol class="declaration-list">
                <li>ব্যক্তিগত সমস্যা</li>
                <li>সামাজিক অরাজকতা</li>
                <li>ধর্মীও অনুভুতিতে আঘাত</li>
                <li>রাষ্ট্রীয় উত্তেজনা।</li>
            </ol>
            
            <p>
                এই সমস্যা গুলোর তৈরি করতে পারে তাহলে আমাকে অবহিত করার জন্য বিনীত অনুরোধ রইলো।
                এই ওয়েবসাইট এর <a href="contact_us.php" style="color: #2A9D8F; font-weight: bold;">Contact Us</a>
                পেজের মাধ্যমে অথবা আমাদের সামাজিক যোগাযোগ মাধ্যম গুলোতে সরাসরি ম্যাসেজ করে
                আমাকে জানাতে পারবেন। আমি অবশ্যই বিষয়টি পুনরায় যাচাই করে যথাযথ ও সঠিক পদক্ষেপ
                নিতে চেষ্টা করবো।
            </p>
        </div>

        <div class="home-button">
            <a href="index.php" class="btn">Go to Homepage</a>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?> 