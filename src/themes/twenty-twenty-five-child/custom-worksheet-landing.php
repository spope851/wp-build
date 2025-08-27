<?php /* Template Name: Custom Worksheet Landing */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/custom-worksheet-landing.css?ver=2">
    <?php wp_head(); ?>
</head>


<?php
function exclude_body_classes($classes) {
    $exclude_classes = [
        'page-template-custom-worksheet-landing',
        'page-template-custom-worksheet-landing-php',
        'wp-theme-storefront',
        'wp-child-theme-storefront-child',
        'theme-storefront',
        'bs-cache-staging-mode',
        'right-sidebar',
        'woocommerce-active',
        'page-template-template-fullwidth-php',
        'page-template-template-fullwidth',
        'dfs_site',
    ];

    return array_diff($classes, $exclude_classes);
}

add_filter('body_class', 'exclude_body_classes');

$placeholderPath  = get_stylesheet_directory_uri() . '/images/custom-worksheet-landing/placeholder.svg';

$check = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
<path opacity="0.05" fill-rule="evenodd" clip-rule="evenodd" d="M15 30C23.2843 30 30 23.2843 30 15C30 6.71573 23.2843 0 15 0C6.71573 0 0 6.71573 0 15C0 23.2843 6.71573 30 15 30Z" fill="#6E3F91"/>
<path d="M13.7466 20C13.5221 20 13.2981 19.9157 13.1267 19.7468L9 15.6791L10.2397 14.4567L13.7466 17.9134L20.7603 11L22 12.2224L14.3664 19.7468C14.195 19.9157 13.971 20 13.7466 20Z" fill="#6E3F91"/>
</svg>';
?>


<body <?php body_class(); ?>>
    <main>
        <section class="hero">
                <header class="site-header-cwl">
                      <div class="container">
                    <?php if (function_exists('the_custom_logo')) : ?>
                        <div class="logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php endif; ?>
                    <nav class="main-navigation" role="navigation" aria-label="Main Navigation">
                        <ul class="nav-list">
                            <li><a href="/contact-us/">Help</a></li>
                    
                        </ul>
                    </nav>
                    </div>
                </header>
                
            <div class="container">
                 <div class="intro-container">
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/hero-element-1.svg" alt="" class="hero-element-1">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/hero-element-2.svg" alt="" class="hero-element-2">
                <h1>Djembe Buying Made Simple</h1>
                <p class="subtitle">Simplify and improve the decision-making process with Djembe Buyers Guide and our Interactive Worksheet - everything you need to make informed purchasing decisions with ease</p>
                </div>
                <div class="hero-images">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/hero-left-img.png" alt="Djembe Buyers Worksheet Preview" class="hero-left-img">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/main-hero-image.png" alt="Djembe Buyers Worksheet Preview" class="main-worksheet-img">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/hero-right-img.png" alt="Djembe Buyers Worksheet Preview" class="hero-right-img">
                </div>
            </div>
        </section>

        <section class="toolkit-intro">
            <div class="container">
                <h2>Your Essential Djembe Buying Toolkit</h2>
            </div>
        </section>

        <section class="djembe-buyers-guide">
            <div class="container">
                <div class="text-content">
                    <h3>The Djembe Buyers Guide</h3>
                    <p>If you haven't already, download our Djembe Buyers Guide or open the Flipbook opposite. This will give you immediate access to everything a buyer needs to know about djembes. The Anatomy of a Djembe section at the end of the Guide will be particularly handy for those new to djembe buying.</p>
                <ul class="grid-list">
                    <li><?php echo $check?>Absolute essentials to get right</li>
                    <li><?php echo $check?>Expert tips to maximize budget</li>
                    <li><?php echo $check?>Hidden Pitfalls to avoid</li>
                    <li><?php echo $check?>Key djembe quality indicators</li>
                </ul>
                
                   <!-- Will this Button trigger the scroll? -->
                    <a href="https://docs.google.com/spreadsheets/d/1NIwdqkGcjGYxcVqw6zEVh9XDxKIOg5XJ-yXS-3UWAkM/edit?gid=0#gid=0" class="btn btn-primary" role="button" target="_blank">Download</a>
      
                    
                </div>
                <div class="image-content">
                            <?php echo do_shortcode('[dflip id="68682" type="thumb"]');?>
                </div>
            </div>
        </section>

        <section class="interactive-worksheet">
            <div class="container">
                 <div class="text-content">
                    <h3>The Interactive Worksheet</h3>
                    <p>There are literally hundreds of djembe options out there, and they differ in dozens of different ways, making it almost impossible to compare like with like and make a rational buying decision.</p>
                    <p>This worksheet clears the confusion by letting you systematically compare all the options. It will help you to find the very best djembe for your setting and then document your decision process.</p>
                    <button id="scrollToVideo" class="btn btn-primary btn-watch-tutorial"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/play_icon.png" alt="play icon">Watch tutorial</button>
                
                <script>
                    document.getElementById('scrollToVideo').addEventListener('click', function() {
                    const targetDiv = document.getElementById('watch-tutorial');
                    targetDiv.scrollIntoView({
                        behavior: 'smooth' // This enables smooth scrolling
                    });
                });
                </script>
                
                </div>
                <div class="image-content">
                     <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/specify-requirements.png" alt="Interactive Worksheet Preview">
                </div>
            </div>
        </section>

        <section class="it-will-help-you">
            <div class="container">
                <div class="section-header">
                    <h3>It will <br>help you...</h3>
                    <p>How our Google Worksheet will simplify, optimise and document your djembe decision-making.</p>
                </div>
                <div class="features-grid">
                    <div class="feature-item">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/key-data-icon.svg" alt="Consider ALL the options icon" class="icon-image">
                        <h4>Consider ALL the options</h4>
                        <p>The sheet is built on a database containing key data about all the djembes from all the DfE Framework suppliers</p>
                    </div>
                    <div class="feature-item">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/list-icon.svg" alt="Create a Manageable Short-list icon" class="icon-image">
                        <h4>Create a Manageable Short-list</h4>
                        <p>Based on your specific needs, an intelligent filter will whittle down the hundreds of possibles to just those that meet your requirement</p>
                    </div>
                    <div class="feature-item">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/compare-list-icon.svg" alt="Compare the short-list systematically icon" class="icon-image">
                        <h4>Compare the short-list systematically</h4>
                        <p>The key features and base pricing of each short-listed djembe are presented side by side, so that you can compare like with like, giving you a basis for negotiating pricing with suppliers</p>
                    </div>
                    <div class="feature-item">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/download-list-icon.svg" alt="Make the Best Value Decision icon" class="icon-image">
                        <h4>Make the Best Value Decision</h4>
                        <p>Making the right decision is straightforward when you have the relevant data clearly presented in front of you. Then just save the Worksheet to document the whole process.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="how-it-works">
            <div class="container">
                <h2>How it works</h2>
                <div class="steps-container">
                    <!-- Step 01 (Odd: Content | Number | Image) -->
                    <div class="step-item step-odd">
                        <div class="step-content-block">
                           <div class="step-content">
                                <h4>Read the Guide</h4>
                                <p>Before doing anything, make sure you have The Knowledge. Our Djembe Buyers Guide contains everything you need to know about Djembes and the Djembe buying process. Click below to download or flick through the adjacent Flipbook</p>
                            </div>
                        </div>
                        <div class="step-number-wrapper"><div class="step-number">01</div></div>
                        <div class="step-image-wrapper first">
                            <?php echo do_shortcode('[dflip id="68682" type="thumb"]');?>
                        </div>
                    </div>
                    <!-- Step 02 (Even: Image | Number | Content) -->
                    <div class="step-item step-even">
                        <div class="step-image-wrapper">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/open-worksheet.png" alt="Open the Worksheet">
                        </div>
                        <div class="step-number-wrapper"><div class="step-number">02</div></div>
                        <div class="step-content-block">
                            <div class="step-content">
                                <h4>Open the Worksheet</h4>
                                <p>Get a closer look at how it works and see how it can help you. Click below to open a protected version of the Worksheet.</p>
                                <a href="https://docs.google.com/spreadsheets/d/1NIwdqkGcjGYxcVqw6zEVh9XDxKIOg5XJ-yXS-3UWAkM/edit?gid=0#gid=0" class="btn btn-primary" role="button" target="_blank">View</a>
                                
                            </div>
                        </div>
                    </div>
                    <!-- Step 03 (Odd: Content | Number | Image) -->
                    <div class="step-item step-odd">
                        <div class="step-content-block">
                            <div class="step-content">
                                <h4>Make a copy</h4>
                                <p>Before you do anything, click the "Make a Copy" button. This will give you an editable, working version.</p>
                            </div>
                        </div>
                        <div class="step-number-wrapper"><div class="step-number">03</div></div>
                        <div class="step-image-wrapper">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/copy-google-doc.png" alt="Make a copy dialog">
                        </div>
                    </div>
                    <!-- Step 04 (Even: Image | Number | Content) -->
                    <div class="step-item step-even">
                         <div class="step-image-wrapper">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/specify-requirements.png" alt="Specify your requirement in worksheet">
                        </div>
                        <div class="step-number-wrapper"><div class="step-number">04</div></div>
                        <div class="step-content-block">
                            <div class="step-content">
                                <h4>Specify your requirement</h4>
                                <p>Use the dropdowns in Section 1 to specify what you need - the spreadsheet will then filter all the possible djembes to give you a short-list</p>
                            </div>
                        </div>
                    </div>
                    <!-- Step 05 (Odd: Content | Number | Image Group) -->
                    <div class="step-item step-odd">
                        <div class="step-content-block">
                            <div class="step-content">
                                <h4>Compare the front-runners for Best Value</h4>
                                <p>The Worksheet will present the key features of the short-listed djembes side-by-side, so that you can compare them objectively and negotiate supplier pricing effectively. You can also key in agreed pricing and discounts, enabling you to identify the winner.</p>
                            </div>
                        </div>
                        <div class="step-number-wrapper"><div class="step-number">05</div></div>
                   <div class="step-image-wrapper step-image-group" style="border: 1px solid #f2f2f2; background-color: white; padding: 1rem; border-radius: 20px;">
                       <?php 
                           $base_uri = get_stylesheet_directory_uri() . '/images/custom-worksheet-landing/';
                           $images = [
                               ['src' => 'DSC_3549-AD-djwt1050.png', 'alt' => 'Djembe 1'],
                               ['src' => 'AD-djbuc1050-Djembe-Drum-10in-diameter-50cm-high-deep-carved-wood-Sustainable-angled.png', 'alt' => 'Djembe 2'],
                               ['src' => 'PP6663_a46f7a30-ceae-470c-bf23-b741d07ca2eb.png', 'alt' => 'Djembe 3']
                           ];
                   
                           foreach ($images as $image) {
                               echo '<img src="' . $base_uri . $image['src'] . '" alt="' . $image['alt'] . '">';
                           }
                       ?>
                   </div>
                   
                    </div>
                </div>
            </div>
        </section>
        <section class="watch-tutorial" id="watch-tutorial">
<div class="container">
    <h2>Watch the Tutorial</h2>
    <p>Watch the (1 minute) tutorial to learn how to use the Google Worksheet effectively.</p>
    <div class="video-responsive" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
        <!-- Poster Image -->
        <img id="poster-image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/poster-image.png" alt="Tutorial Poster" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer;" onclick="playVideo()">
        
        <!-- YouTube Video -->
        <iframe id="youtube-video" src="https://www.youtube.com/embed/AinSz0sT-WI?enablejsapi=1" frameborder="0" allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: none;"></iframe>
    </div>
</div>

<script>
function playVideo() {
    document.getElementById('poster-image').style.display = 'none';
    var video = document.getElementById('youtube-video');
    video.style.display = 'block';
    video.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
}
</script>


    
         
          
        </section>

        <section class="fully-downloadable">
            <div class="container">
                <div class="image-content">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/Screenshot 2025-03-26 at 14.26.23.png" alt="Google Sheets Download Menu">
                </div>
                <div class="text-content">
                    <h2>Fully Downloadable, Sharable & Copyable</h2>
                    <ul>
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/tick.png" alt="Tick Icon">
                            <strong>Downloadable for Offline Use</strong>
                            <p>You can download the Google Sheet and use it offline, allowing you to work without an internet connection. Simply save a local copy to your device and continue your decision-making process wherever you are.</p>
                        </li>
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/tick.png" alt="Tick Icon">
                            <strong>Sharable with Your Team</strong>
                            <p>Easily share your customized sheet with your team members or external collaborators. No need to worry about version control—everyone can access the most up-to-date version at the same time.</p>
                        </li>
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/tick.png" alt="Tick Icon">
                            <strong>Copyable to Customize for Your Own Use</strong>
                            <p>Make the tool your own! Simply click \'Make a Copy\' to create your own version in Google Drive. Tailor it to your specific needs and requirements with ease.</p>
                        </li>
                    </ul>
                    <a href="https://docs.google.com/spreadsheets/d/1NIwdqkGcjGYxcVqw6zEVh9XDxKIOg5XJ-yXS-3UWAkM/edit?gid=0#gid=0"" class="btn btn-primary" role="button" target="_blank">Make a copy</a>
                    
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container footer-top">
            <div class="footer-logo">
<?php the_custom_logo(); ?>            </div>
            <a href="mailto:sales@drumsforschools.co.uk" style="color: white; text-decoration: none;" class="btn btn-primary">Contact Us</a>
            
        </div>
        <div class="container footer-bottom">
            <p>Copyright © 2025 Drums for Schools. All Rights Reserved</p>
            <div class="social-icons">
                <a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/logo_li.png" alt="LinkedIn"></a>
                <a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-worksheet-landing/logo_yt.png" alt="YouTube"></a>
            </div>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>
