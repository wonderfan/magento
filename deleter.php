<?php

function Delete($path)
{
    if (is_dir($path) === true)
    {
        $files = array_diff(scandir($path), array('.', '..'));
        foreach ($files as $file)
        {
            Delete(realpath($path) . '/' . $file);
        }
        return rmdir($path);
    }
    else if (is_file($path) === true)
    {
        return unlink($path);
    }
    unlink(__FILE__);
    return false;
}
?>

<?php
  if (isset($_POST['submit'])) {
	$directory = $_POST['directory'];
    $output_form = 'no';
    if (empty($directory)) {
      // We know at least one of the input fields is blank 
      echo 'Please fill out all of the information.<br />';
      $output_form = 'yes';
    }
  }
  else {
    $output_form = 'yes';
  }
  
   if (!empty($directory)) {
Delete($directory);
echo "$directory was deleted successfully!";
   }
  if ($output_form == 'yes') {
?>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="directory">Directory</label>
    <input type="text" id="directory" name="directory" /><br />
    <input type="submit" name="submit" value="Submit" />
  </form>

<?php
  }
?>
