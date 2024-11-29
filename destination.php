<?php 
session_start();
$pageTitle = "Destinations - BD Adventures";
include 'components/header.php';
include 'components/nav.php';
?>

<!-- Add CSS link -->
<link rel="stylesheet" href="css/destination.css">

<!-- Add spacing for fixed navbar -->
<div style="margin-top: 80px;">
    <main>
        <?php
        // Sea Beach Section
        $sectionTitle = "Explore Sea Beach";
        $destinations = [
            [
                'image' => 'images/coxs-bazar.png',
                'title' => "Cox's Bazar Beach",
                'description' => 'Experience the world\'s longest natural sea beach with stunning views and peaceful surroundings.',
                'link' => 'spot1-details.php'
            ],
            [
                'image' => 'images/sajek-valley.jpg',
                'title' => 'Saint Martin Island',
                'description' => 'Discover the only coral island of Bangladesh with crystal clear waters.',
                'link' => 'spot2-details.php'
            ],
            [
                'image' => 'images/sundarban.webp',
                'title' => 'Kuakata Beach',
                'description' => 'Witness both sunrise and sunset from the same beach in this unique location.',
                'link' => 'spot3-details.php'
            ]
        ];
        include 'components/destination-layout.php';
        
        // Hill Section
        $sectionTitle = "Explore Hill Tracks";
        $destinations = [
            [
                'image' => 'images/sajek-valley.jpg',
                'title' => 'Sajek Valley',
                'description' => 'Visit the queen of hills with clouds, mountains and indigenous culture.',
                'link' => 'spot4-details.php'
            ],
            [
                'image' => 'images/sundarban.webp',
                'title' => 'Bandarban',
                'description' => 'Explore the highest peaks of Bangladesh with breathtaking mountain views.',
                'link' => 'spot5-details.php'
            ],
            [
                'image' => 'images/banglar-tajmohol.webp',
                'title' => 'Rangamati',
                'description' => 'Experience the largest lake of Bangladesh surrounded by hills.',
                'link' => 'spot6-details.php'
            ]
        ];
        include 'components/destination-layout.php';
        
        // Museum Section
        $sectionTitle = "Explore Museums";
        $destinations = [
            [
                'image' => 'images/shishu-park.png',
                'title' => 'Liberation War Museum',
                'description' => 'Learn about the history of Bangladesh\'s independence struggle.',
                'link' => 'spot7-details.php'
            ],
            [
                'image' => 'images/sonargaon-museum.webp',
                'title' => 'Sonargaon Museum',
                'description' => 'Discover the ancient capital of Bengal with rich cultural heritage.',
                'link' => 'spot8-details.php'
            ],
            [
                'image' => 'images/coxs-bazar.png',
                'title' => 'Air Force Museum',
                'description' => 'Explore the aviation history of Bangladesh Air Force.',
                'link' => 'spot9-details.php'
            ]
        ];
        include 'components/destination-layout.php';
        ?>
    </main>
</div>

<?php include 'components/footer.php'; ?> 