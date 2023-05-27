<?php
  require_once('authorizeaccess.php');
  require_once('pagetitles.php');
  $page_title = ML_REMOVE_MINERAL_PAGE;
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?= $page_title ?></title>
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
  </head>
  <body>
  <?php
    require_once('navmenu.php');
  ?>
    <div class="card">
      <div class="card-body">
        <h1 style="font-family: Arima";>Remove a Mineral</h1>
        <?php
            require_once('dbconnection.php');
            require_once('mineralimagefileutil.php');
            require_once('queryutils.php');

            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or trigger_error('Error connecting to MySQL server for DB_NAME.', E_USER_ERROR);

            if (isset($_POST['delete_mineral_submission']) && isset($_POST['id'])):

                $id = $_POST['id'];

                // Query image file from DB
                $query = "SELECT image_file FROM mineral_collection WHERE id = ?";

                $result = parameterizedQuery($dbc, $query, 'i', $id)
                        or trigger_error('Error querying database Mineral', E_USER_ERROR);

                if (mysqli_num_rows($result) == 1)
                {
                    $row = mysqli_fetch_assoc($result);

                    $mineral_image_file = $row['image_file'];

                    if (!empty($mineral_image_file))
                    {
                        removeMineralImageFile($mineral_image_file);
                    }
                }
                
                $query = "DELETE FROM mineral_collection WHERE id = ?";

                $result = parameterizedQuery($dbc, $query, 'i', $id)
                        or trigger_error('Error querying database movieListing', E_USER_ERROR);

                header("Location: " . dirname($_SERVER['PHP_SELF']));

            elseif (isset($_POST['do_not_delete_mineral_submission'])):

                header("Location: " . dirname($_SERVER['PHP_SELF']));

            elseif (isset($_GET['id_to_delete'])):
        ?>
                <h3 class="text-danger">Confirm Deletion of the Following Mineral:</h3><br/>
        <?php
                $id = $_GET['id_to_delete'];

                $query = "SELECT * FROM mineral_collection WHERE id = ?";

                $result = parameterizedQuery($dbc, $query, 'i', $id)
                        or trigger_error('Error querying database movieListing', E_USER_ERROR);

                if (mysqli_num_rows($result) == 1)
                {
                    $row = mysqli_fetch_assoc($result);

                    $mineral_image_file = $row['image_file'];

                    if (empty($mineral_image_file))
                    {
                        $mineral_image_file = ML_UPLOAD_PATH . ML_DEFAULT_MINERAL_FILE_NAME;
                    }

            ?>
            <h1><?=$row['mineral_name']?></h1>
            <div class="row">
              <div class="col-2">
                <img src="<?=$mineral_image_file?>" class="img-thumbnail" style="max-height: 200px;" alt="Minerals image">
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
                      <th scope="row">Comments/notes</th>
                      <td><?=$row['comments']?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <p>
            <form method="POST" action="<?=$_SERVER['PHP_SELF'];?>">
              <div class="form-group row">
                <div class="col-sm-2">
                  <button class="btn btn-danger mr-2" type="submit" name="delete_mineral_submission">Delete Mineral</button>
                </div>
                <div class="col-sm-2">
                  <button class="btn btn-success" type="submit" name="do_not_delete_mineral_submission">Don't Delete</button>
                </div>
                <input type="hidden" name="id" value="<?= $id ?>">
              </div>
            </form>
            <?php
                }
                else
                {
                ?>
            <h3>No Mineral Details :-(</h3>
                <?php
                }

            else: // Unintended page link -  No movie to remove, link back to index

                header("Location: " . dirname($_SERVER['PHP_SELF']));

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