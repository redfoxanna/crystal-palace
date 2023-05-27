<?php
require_once('authorizeaccess.php');
require_once('pagetitles.php');
$page_title = ML_ADD_MINERAL_PAGE;
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
  <title>
    <?= $page_title ?>
  </title>
</head>

<body>
  <?php
  require_once('navmenu.php');
  ?>
  <div class="card">
    <div class="card-body">
      <h1>Add to the collection</h1>
      <hr />
      <?php
      // Initialization
      $display_add_mineral_form = true;
      $mineral_name = "";
      $color_description = "";
      $weight_in_grams = 0.00;
      $comments = "";
      $mineral_form_text = "";
      $checked_mineral_forms = [];

      $forms = ['Natural', 'Tumbled', 'Polished', 'Shaped', 'Cluster', 'Point', 'Fossil', 'Geode', 'Volcanic', 'Palm', 'Orb', 'Pyramid', 'Other'];

      if (
        isset($_POST['add_mineral_submission'], $_POST['mineral_name'],
        $_POST['color_description'], $_POST['weight_in_grams'],
        $_POST['comments'])
      ) {
        $error = 'HERE!';
        require_once('dbconnection.php');
        require_once('mineralimagefileutil.php');

        $mineral_name = $_POST['mineral_name'];
        $color_description = $_POST['color_description'];
        $weight_in_grams = $_POST['weight_in_grams'];
        $comments = $_POST['comments'];
        $checked_mineral_forms = $_POST['mineral_form_checkbox'];

        $mineral_form_text = "";

        if (isset($checked_mineral_forms)) {
          $mineral_form_text = implode(", ", $checked_mineral_forms);
        }


        /*
        Here is where we will deal with the file by calling validateMineralImageFile().
        This function will validate that the mineral image file is not greater than 128
        characters, is the right image type (jpg/png/gif), and not greater than 512KB.
        This function will return an empty string ('') if the file validates successfully,
        otherwise, the string will contain error text to be output to the web page before
        redisplaying the form.
        */

        $file_error_message = validateMineralImageFile();

        if (empty($file_error_message)) {
          require_once('queryutils.php');

          $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or trigger_error('Error connecting to MySQL server for DB_NAME.', E_USER_ERROR);

          $mineral_image_file_path = addMineralImageFileReturnPathLocation();

          $query = "INSERT INTO mineral_collection (mineral_name, color_description, weight_in_grams, mineral_form, "
            . " comments, image_file) VALUES (?, ?, ?, ?, ?, ?)";

          $results = parameterizedQuery(
            $dbc,
            $query,
           'ssdsss',
            $mineral_name,
            $color_description,
            $weight_in_grams,
            $mineral_form_text,
            $comments,
            $mineral_image_file_path
          );

          if (mysqli_errno($dbc)) {
            trigger_error('Error querying database mineral_collection');
          }

          if (empty($mineral_image_file_path)) {
            $mineral_image_file_path = ML_UPLOAD_PATH . ML_DEFAULT_MINERAL_FILE_NAME;
          }

          $display_add_mineral_form = false;
          ?>
          <h3 class="text-info">The Following Mineral Details were Added:</h3><br />

          <h1>
            <?= $mineral_name ?>
          </h1>
          <div class="row">
            <div class="col-2">
              <img src="<?= $mineral_image_file_path ?>" class="img-thumbnail" style="max-height: 500px;"
                alt="Mineral image">
            </div>
            <div class="col">
              <table class="table table-striped table-dark">
                <tbody>
                  <tr>
                    <th scope="row">Color Description</th>
                    <td>
                      <?= $color_description ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">Weight (grams)</th>
                    <td>
                      <?= $weight_in_grams ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">Form</th>
                    <td>
                      <?= $mineral_form_text ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">Comments</th>
                    <td>
                      <?= $comments ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <hr />
          <p>Would you like to <a href='<?= $_SERVER['PHP_SELF']; ?>'> add another mineral or fossil</a>?</p>
          <?php
        } else {
          // echo error message
          echo "<h5><p class='text-danger'>" . $file_error_message . "</p></h5>";
        }
      } 

      if ($display_add_mineral_form) {
        ?>
        <form enctype="multipart/form-data" style="padding: 40px 240px;" class="needs-validation" novalidate method="POST"
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
                value='<?= $weight_in_grams ?>' placeholder="0.00" required>
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
                    name="mineral_form_checkbox[]" value="<?= $mineral_form ?>">
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
            name="add_mineral_submission">Add Mineral/Fossil</button>
        </form>
        <script>
          // JavaScript for disabling form submissions if there are invalid fields
          (function () {
            'use strict';
            window.addEventListener('load', function () {
              // Fetch all the forms we want to apply custom Bootstrap validation styles to
              var forms = document.getElementsByClassName('needs-validation');
              // Loop over them and prevent submission
              var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
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
        <?php
      } // Display add mineral form
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