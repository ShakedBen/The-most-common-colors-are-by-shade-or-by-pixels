<?php
ini_set('memory_limit', '-1');
set_time_limit(700);
class imageRGB
{
	private $file;
	private  $fileName;
	private  $fileTmpName;
	private  $fileSize;
	private  $fileError;
	private  $fileType;
	private $fileExt;
	private $fileActualExt;
	private $allowed;
	private $location;
	private $width;
	private $height;
	private $pixelColorArray;
	private $pick;
	private $topColors;
	private $pixel_array;
	private $pickPercentage;
	private $flag;
	/*A constructor that initializes all the data from the received file */
	/*Saves the image under a new name in a folder in the project */
	public function __construct()
	{
		if (isset($_POST['submit'])) {
			$this->file = $_FILES['file'];
			$this->fileName = $_FILES['file']['name'];
			$this->fileTmpName = $_FILES['file']['tmp_name'];
			$this->fileSize = $_FILES['file']['size'];
			$this->fileError = $_FILES['file']['error'];
			$this->fileType = $_FILES['file']['type'];
			$this->pick = $_POST['pick'];


			$this->fileExt = explode('.', $this->fileName);
			$this->fileActualExt = strtolower(end($this->fileExt));

			$this->allowed = array('png', 'jpeg');

			if (in_array($this->fileActualExt, $this->allowed)) {
				if ($this->fileError === 0) {
					if ($this->fileSize < 9999999) {

						$this->newFileName = uniqid('', true) . "." . $this->fileActualExt;
						$this->fileDestination = "upload/" . $this->newFileName;
						move_uploaded_file($this->fileTmpName, $this->fileDestination);
						$this->location = "upload/$this->newFileName";
						echo $this->classificationByPixels();
					} else {
						echo '<script>alert("Your file is too big!")</script>';
						echo $this->backIndex();
					}
				} else {
					echo '<script>alert("ther was an error uploading your file!")</script>';
					echo $this->backIndex();
				}
			} else {

				echo '<script>alert("ERROR, you cannot upload files of this type!")</script>';
				echo $this->backIndex();
			}
		}
	}

	/*Returns the location of the folder where the image is saved */
	public function getLocation()
	{
		return $this->location;
	}
	/*A function that returns us to the home page after alert */
	public function backIndex()
	{
		echo '<script type="text/javascript">';
		echo 'window.location= "index.php"';
		echo '</script>';
	}
	/*Measures how much of each value of red green blue alpha there is
by going over each pixel in the image*/
	public function classificationByPixels()
	{

		list($this->width, $this->height) = getimagesize($this->location);
		if ($this->fileActualExt == 'png') {
			/*imagecreatefrompng — Create a new image from file or URL*/
			$imgHand = imagecreatefrompng($this->location);
			if ($imgHand == false) {
				echo '<script>alert("ERROR, you cannot upload files of this type ,the conversion was not performed correctly!")</script>';

				echo $this->backIndex();
			}
		} else if ($this->fileActualExt == 'jpeg') {
			$imgHand = imagecreatefromjpeg($this->location);
			if ($imgHand == false) {
				echo '<script>alert("ERROR, you cannot upload files of this type ,the conversion was not performed correctly!")</script>';
				echo $this->backIndex();
			}
		} else {
			echo "The image was not converted correctly";
			die();
		}


		//matrix of pixels
		$this->pixelColorArray = array();
		$this->pixel_array = array();
		$this->flag = 0;
		$this->flag = $_POST['flag'];
		debug_to_console($this->flag);
		for ($i = 0; $i < $this->height; $i++) {
			$this->pixelColorArray[$i] = array();
			for ($j = 0; $j < 	$this->width; $j++) {
				/*imagecolorat — Get the index of the color of a pixel*/
				$pixelColor = imagecolorat($imgHand, $j, $i);
				/*imagecolorsforindex  Get the colors for an pixel */
		
				$this->pixelColorArray[$i][$j] = imagecolorsforindex(
					$imgHand,
					$pixelColor
				);

				if (
					$this->flag == 1
				) {
					/*Reduces the possibilities of almost identical colors*/
					$colorsReduces['red'] = intval((($this->pixelColorArray[$i][$j]['red']) + 15) / 32) * 32;
					$colorsReduces['green'] = intval((($this->pixelColorArray[$i][$j]['green']) + 15) / 32) * 32;
					$colorsReduces['blue'] = intval((($this->pixelColorArray[$i][$j]['blue']) + 15) / 32) * 32;
					$colorsReduces['alpha'] = intval((($this->pixelColorArray[$i][$j]['alpha']) + 15) / 32) * 32;
					if ($colorsReduces['red'] > 255)
					$colorsReduces['red'] = 240;
					if (
						$colorsReduces['green'] > 255
					)
					$colorsReduces['green'] = 240;
					if (
						$colorsReduces['blue'] > 255
					)
					$colorsReduces['blue'] = 240;
					if (
						$colorsReduces['alpha'] > 255
					)
					$colorsReduces['alpha'] = 240;
				} else {
					$colorsReduces['red'] = $this->pixelColorArray[$i][$j]['red'];
					$colorsReduces['green'] = $this->pixelColorArray[$i][$j]['green'];
					$colorsReduces['blue'] = $this->pixelColorArray[$i][$j]['blue'];
					$colorsReduces['alpha'] = $this->pixelColorArray[$i][$j]['alpha'];
				}
				$st = "";
				$st .= (string)($colorsReduces['red']);
				$st .= ",";
				$st .= (string)($colorsReduces['green']);
				$st .= ",";
				$st .= (string)($colorsReduces['blue']);
				$st .= ",";
				$st .= (string)($colorsReduces['alpha']);

				if (array_key_exists($st, $this->pixel_array)) {
					$this->pixel_array[$st] += 1;
				} else {
					$this->pixel_array[$st] = 1;
				}
			}
		}
		
		echo $this->findMaxIndex();
	}

	/*Returns the index and rgb color of the largest value*/
	public function returIndexWithMaxCount()
	{
		$keyTemp = 0;
		$temp = 0;
		$keys = array_keys($this->pixel_array);
		foreach ($keys as $key) {
			if ($this->pixel_array[$key] > $temp && !in_array($key, $this->topColorsKeys)) {
				$temp = $this->pixel_array[$key];
				$keyTemp = $key;
			}
		}
		if ($keyTemp != 0 || $temp != 0) {
			$this->topColorsKeys[] = $keyTemp;
			$this->topColors[] = $temp;
		}
	}

	/*Looking for the values of the pick biggest shows*/
	public function findMaxIndex()
	{

		$this->topColors = array();
		$this->topColorsKeys = array();
		for ($i = 0; $i < $this->pick; $i++) {
			echo $this->returIndexWithMaxCount();
		}
	}

	/*get  rgb color */
	public function getRgbColor()
	{
		return $this->topColorsKeys;
	}

	/*Percentage calculation*/
	public function calcPercentage()
	{
		$this->sumOfType = 0;
		$keys = array_keys($this->pixel_array);
		foreach ($keys as $key) {
			$this->sumOfType += $this->pixel_array[$key];
		}
		$keys = array_keys($this->topColorsKeys);
		foreach ($keys as $key) {
			$this->pickPercentage[] = ($this->topColors[$key] * 100) / $this->sumOfType;
		}
	}

	/*get percent of most popular color*/
	public function getPercentage()
	{
		echo $this->calcPercentage();
		return $this->pickPercentage;
	}
}