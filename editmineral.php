<?php
require_once('authorizeaccess.php');
require_once('pagetitles.php');
$page_title = ML_EDIT_MINERAL_PAGE;
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
        <h1>Edit collection</h1>
        <hr/>
        <?php
            require_once('dbconnection.php');
            require_once('mineralimagefileutil.php');

            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or trigger_error('Error connecting to MySQL server for 
                    DB_NAME.', E_USER_ERROR);

        $forms = ['Natural', 'Tumbled', 'Polished', 'Shaped', 'Cluster', 'Point', 'Fossil', 'Geode', 'Volcanic', 'Palm', 'Orb', 'Pyramid', 'Other']; 
             
        
        // Check if mineral ID is provided in URL
        if (isset($_GET['id_to_edit'])) 
        {
            $id_to_edit = $_GET['id_to_edit'];

            require_once('queryutils.php');

            $query = "SELECT * FROM mineral_collection WHERE id = ?";

            $result = parameterizedQuery($dbc, $query, 'i', $id_to_edit);


        if ($result !== false && $result instanceof mysqli_result && mysqli_num_rows($result) == 1) 
        {
        $row = mysqli_fetch_assoc($result);

            $mineral_name = $row['mineral_name'];
            $color_description = $row['color_description'];
            $weight_in_grams = $row['weight_in_grams'];
            $mineral_form_text = $row['mineral_form'];
            $comments = $row['comments'];
            $mineral_image_file = $row['image_file'];
            
            if (empty($mineral_image_file)) 
                    {
                      $mineral_image_file_displayed = ML_UPLOAD_PATH . 
                       ML_DEFAULT_MINERAL_FILE_NAME;
                    } 
                    else 
                    {
                      $mineral_image_file_displayed = $mineral_image_file;
                    }

                    $checked_mineral_forms = explode(', ', $mineral_form_text);
                }            
            }
            elseif (isset($_POST['edit_mineral_submission'], $_POST['mineral_name'], 
                      $_POST['color_description'], $_POST['weight_in_grams'], 
                      $_POST['id_to_update'], $_POST['mineral_image_file']))
            
            {
                $mineral_name = $_POST['mineral_name'];
                $color_description = $_POST['color_description'];
                $weight_in_grams = $_POST['weight_in_grams'];
                $checked_mineral_forms = $_POST['mineral_form_checkbox'];
                $comments = $_POST['comments'];
                $id_to_update = $_POST['id_to_update'];
                $mineral_image_file = $_POST['mineral_image_file'];

                $mineral_form_text = "";

                if (isset($checked_mineral_forms)) 
                {
                    $mineral_form_text = implode(", ", $checked_mineral_forms);
                }

                if (empty($mineral_image_file)) 
                {
                  $mineral_image_file_displayed = ML_UPLOAD_PATH . ML_DEFAULT_MINERAL_FILE_NAME;
                } 
                else 
                {
                  $mineral_image_file_displayed = $mineral_image_file;
                }

                /*
                Here is where we will deal with the file by calling validateMineralImageFile().
                This function will validate that the mineral image file is the right image type
                (jpg/png/gif), and not greater than 512KB. This function will return an empty
                string ('') if the file validates successfully, otherwise, the string will contain
                error text to be output to the web page before redisplaying the form.
                */

              $file_error_message = validateMineralImageFile();

              if (empty($file_error_message)) 
              {
                $mineral_image_file_path = addMineralImageFileReturnPathLocation();
                
                // IF new image selected, set it to be updated in the database.
                if (!empty($mineral_image_file_path)) 
                {
                  // IF replacing an image (other than the default), remove it
                  if (!empty($mineral_image_file)) 
                  {
                    removeMineralImageFile($mineral_image_file);
                  }

                  $mineral_image_file = $mineral_image_file_path;
                }

                $query = "UPDATE mineral_collection SET mineral_name = ?"
                        . ", color_description = ?"
                        . ", weight_in_grams = ?"
                        . ", mineral_form = ?"
                        . ", comments = ?"
                        . ", image_file = ?"
                        . " WHERE id = ?";
                
                require_once('queryutils.php');

                parameterizedQuery($dbc, $query, 'ssdsssi', $mineral_name, $color_description, $weight_in_grams,
                        $mineral_form_text, $comments, $mineral_image_file, $id_to_update);
        
                if(mysqli_errno($dbc))
                {
                    trigger_error('Error querying database mineral_collection: Failed to update mineral listing', E_USER_ERROR);
                }


                $nav_link = 'mineraldetails.php?id=' . $id_to_update;

                header("Location: $nav_link");
                exit();          
            } 
            else 
            {
              // echo error message 
              echo "<h5><p class='text-danger'>" . $file_error_message . 
              "</p></h5>";
            } 

          }
           else // Unintended page link -  No mineral to edit, link back to index
          {     
                header("Location: index.php");
                exit();
          }
        ?>
        <div class="row">
        <div class="col-md-6">
          <img src="<?=$mineral_image_file_displayed?>" class="img-thumbnail" style="max-height: 400px;" alt="Mineral image">
        </div>
        <div class="col-md-6">
        <form enctype="multipart/form-data" class="needs-validation" novalidate method="POST"
          action="<?= $_SERVER['PHP_SELF']; ?>">
          <div class="form-group row">
            <label for="mineral_name" class="col-sm-3 col-form-label-lg">Name:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="mineral_name" name="mineral_name" value='<?= $mineral_name ?>'
                placeholder="Mineral/Fossil Name" required>
              <div class="invalid-feedback">
                Please provide a valid mineral or fossil name.
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="color_description" class="col-sm-3 col-form-label-lg">Color Description:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="color_description" name="color_description"
                value='<?= $color_description ?>' placeholder="Color Description" required>
              <div class="invalid-feedback">
                Please provide a valid color description.
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="weight_in_grams" class="col-sm-3 col-form-label-lg">Weight (grams):</label>
            <div class="col-sm-8">
              <input type="number" step="0.01" class="form-control" id="weight_in_grams" name="weight_in_grams"
                value='<?= $weight_in_grams ?>' placeholder="Weight (in grams)" required>
              <div class="invalid-feedback">
                Please provide a valid weight in grams.
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label-lg">Mineral/Fossil Form:</label>
            <div class="col-sm-8">
              <?php
              foreach ($forms as $mineral_form) {
                ?>
                <div class="form-check form-check-inline col-sm-3">
                  <input class="form-check-input" type="checkbox" id="mineral_form_checkbox_action_<?= $mineral_form ?>"
                    name="mineral_form_checkbox[]" value="<?= $mineral_form ?>" <?=in_array($mineral_form, $checked_mineral_forms)?'checked':''?>>
                  <label class="form-check-label" for="mineral_form_checkbox_action_<?= $mineral_form ?>"><?= $mineral_form ?></label>
                </div>
                <?php
              }
              ?>
            </div>
          </div>
          <div class="form-group row">
            <label for="color_description" class="col-sm-3 col-form-label-lg">Comments:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="comments" name="comments"
                value='<?= $comments ?>' required placeholder="Comments">
              <div class="invalid-feedback">
                Please provide a valid comment.
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="mineral_image_file" class="col-sm-3 col-form-label-lg">Image File:</label>
            <div class="col-sm-8">
              <input type="file" class="form-control-file" id="mineral_image_file" name="mineral_image_file">
            </div>
          </div>

          <button class="btn btn-primary" style="background-color: #5432a8; border-color: black;" type="submit"
            name="edit_mineral_submission">Edit Mineral/Fossil</button>
          <input type="hidden" name="id_to_update" value="<?= $id_to_edit ?>">
          <input type="hidden" name="mineral_image_file" value="<?= $mineral_image_file ?>">
        </form>

        <script>
        // JavaScript for disabling form submissions if there are invalid fields
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
        </script>
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