<?php
require_once('pagetitles.php');
$page_title = ML_HOME_PAGE;
?>
<!DOCTYPE html>
<html>

<head>
  <title>
    <?= $page_title ?>
  </title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
    integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

  <style>
    .fa-trash-alt {
      color: white;
    }

    a.nav-link {
      color: white;
      text-decoration: underline;

    }

    a {
      font-size: 22px;
    }
    h1 {
      text-align: center;
    }
  </style>
</head>

<body>
  <?php
  require_once('navmenu.php');
  ?>
  <div class="card">
    <div class="card-body">
      <h1> <img src="resources/mineral.png" width="100" height="100" class="d-inline-block align-top" alt=""><br/>
        <?= $page_title ?>
      </h1>
      <?php
      require_once('dbconnection.php');
      require_once('minerallistingfileconstants.php');

      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or trigger_error('Error connecting to MySQL server for'
          . DB_NAME, E_USER_ERROR);

      $query = "SELECT id, mineral_name, image_file FROM mineral_collection ORDER BY mineral_name";

      $result = mysqli_query($dbc, $query)
        or trigger_error(
          'Error querying database Mineral',
          E_USER_ERROR
        );

      if (mysqli_num_rows($result) > 0):
        ?>
        <table class="table table-striped table-hover table-dark">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
              $mineral_image_file = $row['image_file'];

              if (empty($mineral_image_file)) {
                $mineral_image_file = ML_UPLOAD_PATH . ML_DEFAULT_MINERAL_FILE_NAME;
              }

              echo "<tr><td><img src=" . $mineral_image_file . " class='img-thumbnail'" .
                "style='max-height: 175px; border-color: #5432a8;' alt='Mineral image'></td>" .
                "<td class='align-middle'><a class='nav-link' href='mineraldetails.php?id=" .
                $row['id'] . "'>" . $row['mineral_name'] . "</a></td>" .
                "<td  class='align-middle'><a class='nav-link' href='removemineral.php?id_to_delete=" .
                $row['id'] . "'><i class='fas fa-trash-alt'></i></a></td></tr>";
            }
            ?>

          </tbody>
        </table>
        <?php
      else:
        ?>
        <h3>No Minerals Found :-(</h3>
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