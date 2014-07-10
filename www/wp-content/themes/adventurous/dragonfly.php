<?php
/*
 * Template Name: DragonFly Page
 */
get_header ();

?>

<div id="main" class="container">

	<h1>Mike's Dragon Fly</h1>
	<h5>Drag the "Dragonfly" to keep flying. Want to rest? Maneuver onto
		the Lilly Pad</h5>

	<canvas id="mainStage">

        <img src="<?php echo get_template_directory_uri(); ?>/images/DragonFlySpriteSheet.png" />
        <img src="<?php echo get_template_directory_uri(); ?>/images/MarshBackgroundSpriteSheet.png" />

    </canvas>
</div>
<script
	src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.11.0.min.js"></script>
<script
	src="<?php echo get_template_directory_uri(); ?>/js/easeljs.min.js"></script>
<script
	src="<?php echo get_template_directory_uri(); ?>/js/js-toolbox.js"></script>
<script>

    var aLilly = { 18:977, 19:895, 20:809, 21:726, 22: 639, 23:555, 24:469 };

    jQuery(document).ready(function () {

        // Need to integrate mouse control with dragon fly line #124
        var stage = new createjs.Stage(document.getElementById("mainStage"));

        onResize();

        var oX = stage.canvas.width / 2;
        var oY = stage.canvas.height / 2;

        var Bg = new createjs.Shape();
        Bg.graphics.beginFill("rgba(0,0,0,0.8)").drawRect(0, 0, stage.canvas.width, stage.canvas.height);
        stage.addChild(Bg);

        // grey box and start text ticker
        function gameOver() {
            // createjs.Ticker.removeEventListener("tick", tick);
            stage.addChild(Bg);
            var gameOverTxt = new createjs.Text("Play Again", "100px Oswald", "#FFF");
            gameOverTxt.x = 200;
            gameOverTxt.y = 170;
            stage.addChild(gameOverTxt);
            jQuery("#mainStage").click(function () {
                window.location.reload();
            });
        }

        function startScreen() {
            var startTxt = new createjs.Text("Start", "100px Oswald", "#FFF");
            startTxt.x = 300;
            startTxt.y = 170;
            stage.addChild(Bg);
            stage.addChild(startTxt);
            stage.update();
            jQuery("#mainStage").click(function () {
                createjs.Ticker.addEventListener("tick", stage);
                createjs.Ticker.setInterval(24);
                createjs.Ticker.setFPS(24);
                stage.removeChild(startTxt);
                stage.removeChild(Bg);
                playGame();

            });
        }


        function playGame() {

            // background draw

            var data = {
                framerate: 8,
                images: ["<?php echo get_template_directory_uri(); ?>/images/MarshBackgroundSpriteSheet.png"],
                frames: { width: 1024, height: 505 },
                animations: { left: [0, 23] }

            }

            var spriteSheet = new createjs.SpriteSheet(data);
            var backgroundMarsh = new createjs.Sprite(spriteSheet, "left");
            stage.addChild(backgroundMarsh);

            // dragonfly draw
            var data = {
                framerate: 24,
                images: ["<?php echo get_template_directory_uri(); ?>/images/DragonFlySpriteSheet.png"],
                frames: { width: 1024, height: 505 },
                animations: { left: [0, 23] }

            }

            var spriteSheet = new createjs.SpriteSheet(data);
            var animation = new createjs.Sprite(spriteSheet, "left");
            stage.addChild(animation);

            // mouse manipulation registration for centre of dragon fly
            animation.regX = animation.x = 400;
            animation.regY = 355;
            animation.y = 225;


            // mouse manipulation method
            animation.on("pressmove", jQuery.proxy(function (evt) {
                evt.currentTarget.x = evt.stageX;
                evt.currentTarget.y = evt.stageY;
                if (this.currentFrame > 17 && evt.stageY > 320) {
                    console.log(aLilly[this.currentFrame]);
                    gameOver();
                }
                },backgroundMarsh));


        }


        // viewing window resizing
        function onResize() {
            // browser viewport size
            var w = jQuery("#main").width();
            var h = window.innerHeight;

            // stage dimensions
            var ow = 1024; // my stage width
            var oh = 505; // my stage height

            // KEEP ASPECT RATIO
            var scale = Math.min(w / ow, h / oh);
            stage.scaleX = scale;
            stage.scaleY = scale;

            // adjust canvas size
            stage.canvas.width = ow * scale;
            stage.canvas.height = oh * scale;

            stage.update()
            return scale;
        }

        // listener for screen resize
        window.onresize = function () {
            onResize();
        }
        // END RESIZING	

        startScreen();

    }
        );

</script>

<?php

get_footer ();
?>
