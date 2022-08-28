<?php
include "imageRGB.php";

if (isset($_POST['submit'])) {
  $newImg = new imageRGB($_POST['submit']);
  $fivePercentageValue = $newImg->getPercentage();
  $fiveRgbColor = $newImg->getRgbColor();
}
function debug_to_console($data)
{
  $output = $data;
  if (is_array($output))
    $output = implode(',', $output);

  echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}



?>
<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body,
    html {
      height: 100%;
      margin: 0;

    }

    .bg {
      /* The image used */
      background-image: url(<?php echo $newImg->getLocation(); ?>);
      /* Full height */
      height: 100%;

      /* Center and scale the image nicely */
      background-position: center;
      background-repeat: no-repeat;

    }

    .top-left {
      position: absolute;
      top: 8px;
      left: 16px;
    }

    .top-right {
      position: absolute;
      top: 8px;
      right: 16px;
    }
  </style>
</head>

<body>

  <div class="bg"></div>
  <?php
  echo "<table class='top-left' border='1' style='width:40%'>";
  $keys = array_values($fiveRgbColor);
  $i = 0;
  foreach ($keys as $key) {


    echo "<tr>";
    $color = explode(',', $key);
    $color1 = $color[0];
    $color2 = $color[1];
    $color3 = $color[2];

    echo "<td style='background-color:rgb($color1,$color2,$color3); color:black; font-weight:bold';>R=$color1,G=$color2,B=$color3 </td>";
    echo "</tr>";
    echo "<tr>";
    $percentageValue = $fivePercentageValue[$i];
    echo "<td  style='font-weight:bold; '> $percentageValue% </td>";
    echo "</tr>";
    $i++;
  }

  ?>

  </table>

</body>

</html>


?>