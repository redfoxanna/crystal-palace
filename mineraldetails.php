<?php
  require_once('pagetitles.php');
  $page_title = ML_DETAILS_PAGE;
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" 
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" 
          crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Arima:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
          font-family: Arima;
        }
    </style>
    <title><?= $page_title ?></title>
  </head>
  <body>
  <?php
    require_once('navmenu.php');
  ?>
    <div class="card">
      <div class="card-body">
        <h1>Collection Details</h1>
        <hr/>
        <?php 
            if (isset($_GET['id'])):

                require_once('dbconnection.php');
                require_once('minerallistingfileconstants.php');
                require_once('queryutils.php');

                $id = $_GET['id'];

                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                        or trigger_error('Error connecting to MySQL server for DB_NAME.', E_USER_ERROR);

                $query = "SELECT * FROM mineral_collection WHERE id = ?";

                $result = parameterizedQuery($dbc, $query, 'i', $id)
                        or trigger_error('Error querying database Mineral', E_USER_ERROR);

                if (mysqli_num_rows($result) == 1):
                    $row = mysqli_fetch_assoc($result);

                    $mineral_image_file = $row['image_file'];

                    if (empty($mineral_image_file)):
                        $mineral_image_file = ML_UPLOAD_PATH . ML_DEFAULT_MINERAL_FILE_NAME;

                    endif;
            ?>
        <h2> <?=$row['mineral_name']?> </h2>
        <div class="row">
          <div class="col-5">
            <img src="<?=$mineral_image_file?>" class="img-thumbnail" style="max-height: 500px;" alt="Mineral image">
          </div>
          <div class="col">
            <table class="table table-striped table-dark">
              <tbody>
                <tr>
                  <th scope="row">Form</th>
                  <td><?=$row['mineral_form']?></td>
                </tr>
                <tr>
                  <th scope="row">Color Description</th>
                  <td><?=$row['color_description']?></td>
                </tr>
                <tr>
                  <th scope="row">Weight (grams)</th>
                  <td><?=$row['weight_in_grams']?></td>
                </tr>
                <tr>
                  <th scope="row">Comments/Notes</th>
                  <td><?=$row['comments']?></td>
                </tr>
              </tbody>
            </table>
            <?php
                if (isset($_SESSION['user_access_privileges']) && $_SESSION['user_access_privileges'] == 'admin'): ?>
                    <div class='nav-link'>*To change any of the details of this collection piece, 
                          <a href='editmineral.php?id_to_edit=<?=$row['id']?>'> edit it here</a></div>
          </div>
        </div>
            
          
        <hr/>
            <?php 
                    endif;
                else:
            ?>
        <h3>No Mineral Details :-(</h3>
        <?php
                endif;
            else:
        ?>
        <h3>No Mineral Details :-(</h3>
        <?php
            endif;
        ?>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" 
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" 
            integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" 
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" 
            integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" 
            crossorigin="anonymous"></script>
  </body>
</html>