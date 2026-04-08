<html>
     <head>
          <meta charset="UTF-8">
          <title>Query Results</title>
          <link rel="stylesheet" href="style.css">
     </head>
     <body class="bodyStyle">
          <?php
               ini_set('display_errors', 1);
               error_reporting(E_ALL);

               include 'get-parameters.php';

               $conn = new mysqli($ep, $un, $pw, $db);

               if ($conn->connect_error) {
                    echo '<div style="color:red; font-weight:bold; margin:20px;">Database connection failed: ' . htmlspecialchars($conn->connect_error) . '</div>';
               } else {
                    $_pick = $_POST['selection'] ?? '';
                    if (empty($_pick)) {
                         echo '<div style="color:red; font-weight:bold; margin:20px;">No query selection received. Please go back and choose an option.</div>';
                    } else {
                         switch ($_pick) {
                              case "Q1":
                                   include 'mobile.php';
                                   break;
                              case "Q2":
                                   include 'population.php';
                                   break;
                              case "Q3":
                                   include 'lifeexpectancy.php';
                                   break;
                              case "Q4":
                                   include 'gdp.php';
                                   break;
                              case "Q5":
                                   include 'mortality.php';
                                   break;
                              default:
                                   echo '<div style="color:red; font-weight:bold; margin:20px;">Invalid selection: ' . htmlspecialchars($_pick) . '</div>';
                                   break;
                         }
                    }
               }
          ?>

          <div id="Copyright" class="center">
               <h5>&copy; 2020, Amazon Web Services, Inc. or its Affiliates. All rights reserved.</h5>
          </div>
     </body>
</html>