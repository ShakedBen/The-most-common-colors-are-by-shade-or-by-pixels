<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="style.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Select image</title>
</head>

<body>
	<div class="loader"></div>
	<form action="infoPage.php" method="POST" enctype="multipart/form-data">
		<label class="custom-file-upload" for="file"><i class="material-icons" style="font-size:25px">add_a_photo</i>&nbsp;Choose png/jpeg image
			<br />
			<span id="imageName"></span>
		</label>
		<div style='color:white; font-weight:bold;  background-color: #555;   position: absolute;    border-radius:5px;   padding: 12px 24px;border: none;  top: 64%; left:46%;'>
			</p>amount of colors</p>
			  <input type="radio" id="four1" name="pick" value=11>
			  <label for="four1">11</label><br>
			  <input type="radio" id="three1" name="pick" value=9>
			  <label for="three1">9</label><br>
			  <input type="radio" id="two1" name="pick" value=7>
			  <label for="two1">7</label><br>
			  <input type="radio" id="one1" name="pick" value=5 checked>
			  <label for="one1">5</label><br><br>
		</div>
		<div style='color:white; font-weight:bold;  background-color: #566;   position: absolute;    border-radius:5px;   padding: 12px 24px;border: none;  top: 55%; left:42%;'>
			  <input type="radio" id="one" name="flag" value=1 checked>
			  <label for="one">The most common colors by shade</label><br>
			  <input type="radio" id="two" name="flag" value=0>
			  <label for="two">The most common colors by pixels</label><br>
		</div>
		<input type="file" for="mediaCapture" id="file" name="file">
		<span id="imageName"></span>

		<button type=" submit" name="submit"> UPLOAD<span class="load loading"></span> </button>

	</form>


	<script>
		let input = document.getElementById("file");
		let imageName = document.getElementById("imageName")

		input.addEventListener("change", () => {
			let inputImage = document.querySelector("input[type=file]").files[0];

			imageName.innerText = inputImage.name;
		})






		const btns = document.querySelectorAll('button');
		btns.forEach((items) => {
			items.addEventListener('click', (evt) => {
				evt.target.classList.add('activeLoading');


			})
		})
	</script>
</body>

</html>