<?php
require_once 'minerallistingfileconstants.php';

/**
 * Purpose:         Validates an uploaded mineral image file
 *
 * Description:     Validates an uploaded mineral image file is not greater than ML_MAX_FIE (1/2 MB),
 *                  and is either a jpg or png image type, and has no errors. If the image file
 *                  validates to these constraints, an error message containing an empty string is
 *                  returned. If there is an error, a string containing constraints the file failed
 *                  to validate to are returned.
 *
 * @return string   Empty if validation is successful, otherwise error string containing
 *                  constraints the image file failed to validate to.
 */
function validateMineralImageFile()
{
    $error_message = "";

    // Check for $_FILES being set and no errors.
    if (isset($_FILES) && $_FILES['mineral_image_file']['error'] == UPLOAD_ERR_OK)
    {
        // Check for uploaded file < Max file size AND an acceptable image type
        if ($_FILES['mineral_image_file']['size'] > ML_MAX_FILE_SIZE)
        {
            $error_message = "The mineral file image must be less than " . ML_MAX_FILE_SIZE . " Bytes";
        }

        $image_type = $_FILES['mineral_image_file']['type'];

        if ($image_type != 'image/jpg' && $image_type != 'image/jpeg' && $image_type != 'image/pjpeg'
            && $image_type != 'image/png' && $image_type != 'image/gif')
        {
            if (empty($error_message))
            {
                $error_message = "The mineral file image must be of type jpg, png, or gif.";
            }
            else
            {
                $error_message .= ", and be an image of type jpg, png, or gif.";
            }
        }
    }
    elseif (isset($_FILES) && $_FILES['mineral_image_file']['error'] != UPLOAD_ERR_NO_FILE
        && $_FILES['mineral_image_file']['error'] != UPLOAD_ERR_OK)
    {
        $error_message = "Error uploading mineral image file.";
    }

    return $error_message;
}

/**
 * Purpose:         Moves an uploaded mineral image file to the ML_UPLOAD_PATH (images/) folder and
 *                  return the path location.
 *
 * Description:     Moves an uploaded mineral image file from the temporary server location to the
 *                  ML_UPLOAD_PATH (images/) folder IF a mineral image file was uploaded and returns
 *                  the path location of the uploaded file by appending the file name to the
 *                  ML_UPLOAD_PATH (e.g. images/mineral_image.png). IF a mineral image file was NOT
 *                  uploaded, an empty string will be returned for the path.
 *
 * @return string   Path to mineral image file IF a file was uploaded AND moved to the ML_UPLOAD_PATH
 *                  (images/) folder, otherwise and empty string.
 */
function addmineralImageFileReturnPathLocation()
{
    $mineral_file_path = "";

    // Check for $_FILES being set and no errors.
    if (isset($_FILES) && $_FILES['mineral_image_file']['error'] == UPLOAD_ERR_OK)
    {
        $mineral_file_path = ML_UPLOAD_PATH . $_FILES['mineral_image_file']['name'];

        if (!move_uploaded_file($_FILES['mineral_image_file']['tmp_name'], $mineral_file_path))
        {
            $mineral_file_path = "";
        }
    }

    return $mineral_file_path;
}

/**
 * @param $mineral_file_path
 */
function removeMineralImageFile($mineral_file_path)
{
    @unlink($mineral_file_path);
}