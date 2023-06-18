<?php
session_start();
// if (isset($_COOKIE['user_id'])){
// $_SESSION['user_id']=$_COOKIE['user_id'];
// }
include ("../common.inc.php");
include ("../utility.php");
$con=connection();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>My Website</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="stylesheet" href="Home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../Pictures/ScoutsLogo.gif" type="image/png">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400&display=swap" 
  rel="stylesheet">
  </head>

  <body>  
<!-- facebook embedd -->

<div class="sidebar">
    <div class="logo">
        <img src="../Icons/menu-svgrepo-com.svg" alt="sds">
        <img src="../Icons/arrow-right-svgrepo-com.svg" alt="sdsd">
        <img src="../Icons/close-md-svgrepo-com.svg" alt="dsd">
    </div>
    <div class="links">

        <button class="active" onclick="scrollToSection('hero')">
            <img src="../Icons/home-alt-svgrepo-com.svg">Home
        </button>
        <?php
        // Assuming you have established a database connection
        if(isset($_SESSION['user_id'])){
            // Step 1: Retrieve feature names using a single SQL query with INNER JOIN
            $userID = $_SESSION['user_id'];
            $query = "SELECT f.description AS featureName
                      FROM unitrankhistory urh
                      INNER JOIN rankfeature rf ON urh.rankId = rf.rankid
                      INNER JOIN features f ON rf.featureid = f.feature_id
                      WHERE urh.userId = $userID AND urh.end_date IS NULL";

            $result = mysqli_query($con, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $transactionButtonDisplayed = false; // Flag to track if transaction button has been displayed

                while ($row = mysqli_fetch_assoc($result)) {
                    $featureName = $row['featureName'];

                    // Display the corresponding part based on the feature name
                    if ($featureName === "generate code") {
                        echo '<button onclick="window.location.href=\'../ScoutManagementSystem/ScoutCode.php#code-section\'">';
                        echo '<img src="../Icons//icons8-password.svg">Code/Pass Generator';
                        echo '</button>';
                    } elseif ($featureName === "search scout") {
                        echo '<button onclick="window.location.href=\'../ScoutManagementSystem/ScoutCode.php#search-section\'">';
                        echo '<img src="../Icons/search-refraction-svgrepo-com.svg">Search Scout';
                        echo '</button>';
                    } elseif ($featureName === "create unit") {
                        echo '<button onclick="window.location.href=\'../ScoutManagementSystem/ScoutCode.php#create-section\'">';
                        echo '<img src="../Icons/add-svgrepo-com.svg">Create Unit';
                        echo '</button>';
                    } elseif ($featureName === "make request") {
                        echo '<button onclick="window.location.href=\'../Request/request.php\'">';
                        echo '<img src="../Icons/git-pull-request-svgrepo-com.svg">Requests';
                        echo '</button>';
                    } elseif ($featureName === "make transaction") {
                        // Check if "view transaction" has already been displayed
                        if (!$transactionButtonDisplayed) {
                            echo '<button onclick="window.location.href=\'../views/transactionView.php\'">';
                            echo '<img src="../Icons/finance-currency-dollar-svgrepo-com.svg">Finance';
                            echo '</button>';
                            $transactionButtonDisplayed = true; // Set the flag to true
                        }
                    } elseif ($featureName === "view transaction") {
                        // Check if "make transaction" has already been displayed
                        if (!$transactionButtonDisplayed) {
                            echo '<button onclick="window.location.href=\'../views/transactionView.php\'">';
                            echo '<img src="../Icons/finance-currency-dollar-svgrepo-com.svg">Finance';
                            echo '</button>';
                            $transactionButtonDisplayed = true; // Set the flag to true
                        }
                    }
                }
            }
        }
        ?>
        <!-- Add other static buttons here -->
        <button onclick="scrollToSection('Scout-gallery')">
            <img src="../Icons/world-1-svgrepo-com.svg">Social Media
        </button>
        <button class="" onclick="scrollToSection('testimonials')">
            <img src="../Icons/system-help-svgrepo-com.svg">About Us
        </button>
        <button class="" onclick="window.location.href='../views/contactUsView.php'">
            <img src="../Icons/phone-svgrepo-com.svg">Contact Us
        </button>
    </div>
</div>

          <div class="profile-icon">
          <?php if (isset($_SESSION['user_id'])): ?>
        <!-- User is logged in, show relevant content -->
        <div class="welcome-message">
            <p>Welcome, <?php echo $_SESSION['name']; ?></p>
            <!-- <button onclick="window.location.href='logout.php'">Logout</button> -->
        </div>
    <?php else: ?>
        <!-- User is not logged in, show login button -->
        <div class="login-btn">
            <button onclick="window.location.href='../Login/Login.php'">Login</button>
        </div>
    <?php endif; ?>
    <img src="../Pictures/ScoutsLogo.gif" alt="scoutslogo">
          </div>
    
          
          <div class="hero">
        <img src="../Pictures/WhatsApp Image 2023-05-10 at 4.32.21 PM.jpeg" alt="scout pic">
      </div>

<!-- sliders part -->
<section class="slider">
  <div class="slide active">
    <div class="image-containerr">
    <img src="../Pictures/ScoutPic4.jpg" alt="ScoutPic4"></div>
    <div class="slide-content">
      <h1>Hello!!</h1>
      <p>Welcome to the National Orthodox Scouts and Guides! Our community is dedicated to helping young people develop their character, leadership skills, and love for God and country. Join us on this adventure!</p>
    </div>
  </div>
  <div class="slide">
    <div class="image-containerr">
      <img src="../Pictures/ScoutPic5.jpg" alt="ScoutPic5"></div>
    <div class="slide-content">
      <h1>Discover Your Talents</h1>
      <p>Explore the great outdoors and discover new talents with the National Orthodox Scouts and Guides. Whether you're interested in camping, hiking, cooking, or art, we have something for you. Come and see what you can achieve!</p>
    </div>
  </div>
  <div class="slide">
    <div class="image-containerr">
      <img src="../Pictures/ScoutPic6_auto_x2.jpg" alt="ScoutPic5"></div>
          <div class="slide-content">
      <h1>Be a Changemaker and More!</h1>
      <p>Are you ready to make a difference in your community and beyond? The National Orthodox Scouts and Guides are committed to serving others and promoting peace, justice, and sustainability. Join us and become a changemaker today!</p>
    </div>
  </section>

<!-- end of sliders part -->

<div class="container">
<div class="container1">
  <img src="../Pictures/ScoutPic2.jpg" alt="">
  <h2><?php 
  if(isset($_SESSION['email'])){
    echo $_SESSION['email'];
   }
   if(isset($_SESSION['user_id'])){
    echo $_SESSION['user_id'];
   }
   print_r($_SESSION);
   ?>Values and Principles of Scouts and Guides National Orthodox</h2>
  <p>Explore the core values and principles that guide the Scout et Guide National Orthodoxe (SNO) community. 
    Discover how SNO programs instill Orthodox Christian values such as faith, compassion,
     integrity, and service. Learn about the emphasis on personal and spiritual development, fostering a sense of morality, and promoting virtues that shape the character of SNO members.
     Delve into the unique blend of religious teachings, traditions, and outdoor experiences that form the foundation of the SNO movement.</p>
</div>
<div class="container2">
  <img src="../Pictures/ScoutPic6.png" alt="">
  <h2>Programs and Activities of Scouts and Guides National Orthodox</h2>
  <p>Discover the diverse range of programs and activities offered by the Scout et Guide National Orthodoxe (SNO) community. Explore the exciting adventures and challenges that SNO members undertake, including camping, hiking, leadership development, community service, and environmental conservation. Learn about the integration of Orthodox Christian teachings
    , rituals, and practices into the SNO programs, providing a holistic approach to personal growth, cultural preservation, and spiritual enrichment.</p>
</div>
<div class="container3">
  <img src="../Pictures/ScoutPic1.png" alt="">
  <h2>Inclusivity and Community in the Scouts and Guides National Orthodox</h2>
  <p>Explore the inclusive nature of the Scout et Guide National Orthodoxe (SNO) community and its commitment 
    to fostering a sense of belonging. Learn how SNO embraces individuals from diverse backgrounds, cultures, and abilities,
     creating a supportive and accepting environment. Discover the efforts made to promote gender equality, empower girls and boys, and encourage leadership opportunities within the SNO community. Explore the sense of unity, friendship, and shared values that define the SNO experience.</p>
  </div>
</div>

<div class="Scout-Creator">
  <h1>Robert Stephenson Smyth Lord Baden-Powell  - The Scouts Founder</h1>
  <div class="image">
    <img src="../Pictures/Lord Baden Powell.gif" alt="Baden Powell">
  </div>
  <p>
    Baden Powell was a British Army officer, writer, and founder of the Scout Movement. He was born on February 22, 1857, in London, England. Powell's passion for outdoor activities and his military background inspired him to develop a youth program that focused on character development, teamwork, and self-reliance.
  </p>
  <div class="image">
    <img src="../Pictures/brownseascout.gif" alt="">
  </div>
  <p>
    In 1907, Powell organized the first experimental camp on Brownsea Island, which marked the beginning of the Scout Movement. His book, "Scouting for Boys," became a bestseller and laid the foundation for the worldwide scouting movement. Powell's contributions to youth development have had a lasting impact, promoting values of integrity, leadership, and service.
    <div class="image">
      <img src="../Pictures/girlguides.webp" alt="">
    </div>
  </p>
  <p>
    Robert Baden-Powell recognized the need for scouting activities for girls, leading to the establishment of the Girl Guide and Girl Scout Movement. With the support of his sister, Agnes Baden-Powell, the Girl Guides were formed in 1910. This initiative rapidly grew, providing girls with opportunities to develop leadership skills, engage in outdoor activities, and contribute to their communities. Baden-Powell's inclusive approach emphasized that character development and practical skills were not limited by gender. The inclusion of girls in the scouting movement marked a significant milestone in advancing gender equality, empowering them to actively shape their lives and make a positive impact in their communities.</p>
</div>
 

<!-- baden powell quotes -->

<div class="quotes-container">
  <h1>Our founder's most touching quotes:</h1>
  <h3>Dedicated to the Leaders</h3>
  <div class="image-container">
    <img src="../Pictures/ScoutLeaders.jpg" alt="Leaders">
    </div>
<div class="quote-container">
  <div class="quote">
  "في منظمة كبيرة وحركة كبيرة مثل الحركة الكشفية ، لا يوجد مكان للأنانية والجهود الفردية .. علينا جميعًا أن نتعاون معًا ونعمل معًا مع بعضنا البعض بشكل فعال لتحقيق الهدف المنشود".

  </div>
  <div class="author">- Baden Powell</div>
</div>

<div class="quote-container">
  <div class="quote">
  "في حياتي الخاصة ، هناك ثلاث طرق يمكنني من خلالها مواجهة المشاكل بنجاح .. هذه الطرق هي: العمل ، والعدالة ، وأهم سلاح وهو الحب".

  </div>
  <div class="author">- Baden Powell</div>
</div>

<div class="quote-container">
  <div class="quote">
  "لن يكون الإنسان صالحًا ما لم يكن لديه إيمان صادق بالله ويطيع أوامره .. لذلك يجب أن يلتزم الكشاف دائمًا بالدين".
  </div>
  <div class="author">- Baden Powell</div>
</div>
<h3>Dedicated to the Scouts:</h3>
<div class="image-container">
  <img src="../Pictures/Scoutss.jpg" alt="Scouts">
</div>
<div class="quote-container">
  <div class="quote">
  "يتميز الكشافة بابتسامته المستمرة التي تمنحه الفرح والسعادة .. وتجعل من حوله يشعر بالمثل خاصة في وقت إدارة الأزمات والمخاطر".
  </div>
  <div class="author">- Baden Powell</div>
</div>

<div class="quote-container">
  <div class="quote">
  "أعتقد أنه من الأفضل ترك الأولاد يقودون العالم .. يجب أن يكون لدينا عالم مليء بالمرح والمثابرة والجدية والصداقة."
  </div>
  <div class="author">- Baden Powell</div>
</div>

<div class="quote-container">
  <div class="quote">
  "يجب أن تعتمد دائمًا على نفسك ولا تعتمد على ما يمكن للآخرين القيام به من أجلك."
  </div>
  <div class="author">- Baden Powell</div>
</div>

</div>
<!-- end of quotes -->

<section class="Scout-gallery">
  <h2>Our Recent Events</h2>
  <div class="image-grid" id="post-container">
    <?php
    require_once '../sdk/php-graph-sdk-5.x/src/Facebook/autoload.php';
    $app_id = '1250484182494643';
    $app_secret = 'ce9dfe54a8f90b0230f61871e3045236';
    $access_token = 'EAARxTwlZBrbMBAGySJZC8VfOkdf114IqTLgZAp9AVG4rE8j38XmRF3FUvLJ4tZCPwTtwJp84ZCSgJ76JRQeW2sZByGBWzPsjyeNpuwwvcd2symsBZAAww9VdsJtjOv97Xr1uK1ZBmZC3dtkLIW33ZBaPETIcdjYWJ6z1eeqabN05CjQXb4ZAZBHITo1j';

    $fb = new Facebook\Facebook([
      'app_id' => $app_id,
      'app_secret' => $app_secret,
      'default_graph_version' => 'v17.0',
    ]);

    $fb->setDefaultAccessToken($access_token);

    try {
      $response = $fb->get('/me/posts?fields=id,message,created_time,attachments{media}');
      $posts = $response->getGraphEdge();

      // Process the retrieved posts
      foreach ($posts as $post) {
        $postId = $post['id'];
        $message = isset($post['message']) ? $post['message'] : '';
        $createdTime = isset($post['created_time']) ? $post['created_time']->format('Y-m-d H:i:s') : '';

        // Check if the post has attachments
        $attachments = isset($post['attachments']) ? $post['attachments'] : [];
        $hasAttachments = !empty($attachments);

        // Wrap each post in a div
        echo '<div class="post">';
        // Display the attached images if available
        if ($hasAttachments) {
          foreach ($attachments as $attachment) {
            if (isset($attachment['media']) && isset($attachment['media']['image'])) {
              if (!isset($attachment['media']['video'])) {
                $imageSrc = $attachment['media']['image']['src'];
                // Display the image
                echo '<div class="picture">';
                echo '<img src="' . $imageSrc . '" alt="Post Picture">';
                echo '</div>'; // Close picture div
              }
            }
          }
        }

        // Output the post message and created time
        echo '<div class="post-content">';
        echo '<p>' . $message . '</p>';
        echo '<p>Posted Date: ' . $createdTime . '</p>';

        // Add link to the post on Facebook
        echo '<a href="https://www.facebook.com/' . $postId . '" target="_blank">Click here for more details</a>';

        echo '</div>'; // Close post-content div

        echo '</div>'; // Close post div
      }
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
      // Handle API errors
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
      // Handle SDK errors
    }
    ?>
  </div>
</section>










  
      <section class="testimonials">
        <h2>Our Scouts and Guides Experience</h2>
        <div class="testimonial">
          <img src="../Pictures/scoutportrait.jpg" alt="Customer 1">
          <blockquote>"The National Orthodox Scouts has changed my life. It taught me leadership, teamwork, and a love for nature. I've made lifelong friends and had incredible adventures. I'm grateful for the impact it has had on me."</blockquote>
          <cite>- John</cite>
        </div>
        <div class="testimonial">
          <img src="../Pictures/scoutportrait1.jpg" alt="Customer 2">
          <blockquote>"The Scouts empowered me to break stereotypes and pursue my passions. I gained confidence, resilience, and made lasting friendships. Scouting taught me skills and a love for the outdoors. It's been an amazing journey."</blockquote>
          <cite>- Sarah</cite>
        </div>
        <div class="testimonial">
          <img src="../Pictures/scoutportrait2.jpg" alt="Customer 3">
          <blockquote>"The Scouts taught me teamwork, self-reliance, and the joy of giving back. It challenged me and helped me discover my potential. The friendships and adventures I've had are priceless. Scouting made me who I am today."</blockquote>
          <cite>- David</cite>
        </div>
      </section>
    </main>
    <footer>
      <p>تأسست على أراضي الجمهورية اللبنانية جمعية كشفية تدعى جمعية "الكشّاف الوطني الأرثوذكسي" بموجب علم وخبر من وزارة الداخلية رقم 90/أ.د. تاريخ 24/1/1970.<br>
       وهي تابعة لاتحاد كشاف لبنان وعضو في المكتب الكشفي العالمي وفي الرابطة الكشفية الأرثوذكسية DESMOS 

أما جمعية مرشدات الكشاف الوطني الارثوذكسي فقد تأسست سنة 1971 واصبحت عضوا في ال WAGGGS سنة 2005</p>
      <p>&copy; 2023 National Orthodox Scout and Guides of Lebanon. All rights reserved.</p>
    </footer>
  <script src="Home.js"></script> 
  </body>
</html>
