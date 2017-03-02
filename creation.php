<?php include 'includes/header.php'; ?>

<?php	if ($connected) {	?>
	<div id="creator-left"  class="col-2">
        <div class="camera">
            <video id="video"></video>
        </div>
        <canvas id="canvas">
        </canvas>
		<?php include 'scripts/photo_creation.php'; ?>
	</div>
	<div id="creator-right" class="col-2">
		<div id="layers">
			<form id="create_form" method="post" enctype="multipart/form-data">
				<p>You Don't own a camera ? Send us your photo !* <input type="file" name="pic" accept="image/*"></p>
				<input type="radio" name="front_layer" value="1" checked> <img class="thumb" src="medias/layers/layer_1.png">
				<input type="radio" name="front_layer" value="2"> <img class="thumb" src="medias/layers/layer_2.png">
				<input type="radio" name="front_layer" value="3"> <img class="thumb" src="medias/layers/layer_3.png"><br>
				<input type="submit" name="startbutton" id="startbutton" value="Take your photo!">
				<input id="data_input" type="hidden" name="img_data" value=""/>
			</form>
		</div>
  		<div id="sidelist">
  			<h1>Your last photos</h1>
<?php
    $uid = $G_CNX->getId();
    $u_photos = mysql_getTable('SELECT * FROM cmg_photos WHERE creator_id = ' . $uid . ' ORDER BY creation DESC LIMIT 9', $G_PDO);
    foreach ($u_photos as $key => $value) {
      echo "<a href='single.php?id=" . $value['id'] . "'> <img src='medias/photos/pht_" . $value['id'] . ".png'></a>";
    }
?>


  </div>
	</div>

<?php }	else { //if the user isn't connected ?>
	<h1>You're not connected</h1>
	<p>This page allows you to create your photos, and share them.</p>
	<p><a class="button" href="index.php">Join us !</a></p>

<?php } ?>

    <script>
        function photo_mgr()
        {
            //1) Setup datas
            var me = this;

            this.form = document.getElementById("create_form");
            this.data_input = document.getElementById("data_input");
            //this.canvas = document.getElementById("canvas");

            //2) Setup functions
            this.postImg = function(img)
            {
                me.data_input.value = img;
                me.form.submit();
            }
        }

        var photo_mgr = new photo_mgr();

        (function() {
            var streaming = false,
                video        = document.querySelector('#video'),
                cover        = document.querySelector('#cover'),
                canvas       = document.querySelector('#canvas'),
                photo        = document.querySelector('#photo'),
                startbutton  = document.querySelector('#startbutton'),
                width = 300,
                height = 0;
            navigator.getMedia = ( navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.msGetUserMedia);
            navigator.getMedia(
                {
                    video: true,
                    audio: false
                },
                function(stream) {
                    if (navigator.mozGetUserMedia) {
                        video.mozSrcObject = stream;
                    } else {
                        var vendorURL = window.URL || window.webkitURL;
                        video.src = vendorURL.createObjectURL(stream);
                    }
                    video.play();
                },
                function(err) {
                    console.log("An error occured! " + err);
                }
            );
            video.addEventListener('canplay', function(){
                if (!streaming) {
                    height = video.videoHeight / (video.videoWidth/width);
                    video.setAttribute('width', width);
                    video.setAttribute('height', height);
                    canvas.setAttribute('width', width);
                    canvas.setAttribute('height', height);
                    streaming = true;
                }
            }, false);
            function takepicture() {
                canvas.width = width;
                canvas.height = height;
                canvas.getContext('2d').drawImage(video, 0, 0, width, height);
                var data = canvas.toDataURL('image/png');
                //photo.setAttribute('src', data);
                photo_mgr.postImg(data);
            }
            startbutton.addEventListener('click', function(ev){
                takepicture();
                ev.preventDefault();
            }, false);
        })();
    </script>

<?php include 'includes/footer.php' ?>