<?php
/*
 Template Name: Racing Page
*/
get_header();

?>

<!--<!DOCTYPE html>
<html>
<head>
<link href='http://fonts.googleapis.com/css?family=VT323' rel='stylesheet' type='text/css'>
<meta name="viewport" content="width=device-width, user-scalable=no">
<style>
body {
margin:0;
padding:0;
}
</style>
</head>
<body>

	<!--  
	
	This div didnt "float" over the stage
	
	<div style="float:left" class="header"> <h1>SPEED:<span id="header">000</span></h1> </div>

	-->
	
	<!-- this adds dependicies "<?php echo get_template_directory_uri(); ?>  -->
	
	<div id="stagewrapper">
	<canvas id="stage" style="background-color: #0cf;">
	<img id="Clouds" src="<?php echo get_template_directory_uri(); ?>/images/Clouds.png"/>
	<img id="Roads0001" src="<?php echo get_template_directory_uri(); ?>/images/Road0001.png"/>
	<img id="Roads0002" src="<?php echo get_template_directory_uri(); ?>/images/Road0002.png"/>
	</canvas>	
	</div>
	
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.11.0.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/easeljs.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/js-toolbox.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js"></script>	
	<script type="text/javascript">
			
			WebFont.load({
			google: {
			families: [ 'VT323']
			},
			loading: function() {
			console.log("loading");
			},
			active: function () {
			//window.init();
			},
			inactive: function() {
			console.log("inactive")
			}
			});
			
	</script>
	
	<script>
		
			var Watcher = Toolbox.Base.extend({

			//Depth of the visible road
			roadLines:150,
			//Dimensions of the play area.
			resX:480,
			resY:320,
			//Line of the player's car.
			playerLine:8,
			//All the road lines will be accessed from an Array.
			zMap:new Array(),
			lines:new Array(),
			halfWidth:0,
			lineDepth:0,
			widthStep:1,
			playerZ:0,
			speed:25,
			texOffset:100,
			rx:0, //Each line's x position
			dx:0,//Curve amount per segment
			ddx:0.02, //Curve amount per line
			segmentY:150,
			nextStretch:"Straight",
			ry:0,
			dy:0,
			ddy:0.01,//A little less steep than the curves.
						
			constructor : function() {
				
				
				this.resize();
				
				// sequence sets up rest of animation 81 - 90
				if (window.DeviceOrientationEvent) {
					// Listen for the event and handle DeviceOrientationEvent object
					window.addEventListener('deviceorientation', jQuery.proxy(
							this.showPosition, this), false);
				}
				createjs.Ticker.setFPS(24);
				createjs.Ticker.addEventListener("tick", jQuery.proxy(
				this.race, this));
				
				createjs.Ticker.addEventListener("tick", jQuery.proxy(
						this.clouds, this));
				
				jQuery(window).resize(jQuery.proxy(this.resize, this));
						createjs.Ticker.addEventListener("tick", jQuery.proxy(
						this.speedometer, this));
						
			},
			
			
			
			
			txt: new createjs.Text(),

			cloudimage : new createjs.Bitmap(document.getElementById("Clouds")),
			clouds : function(){
				
				this.cloudimage.x -= 0.6 * this.speed;
				this.cloudimage.y -= this.speed;
				this.cloudimage.alpha = this.resY / (this.cloudimage.y * 8);
				
				
				if (this.cloudimage.x < - this.resX ){
					
					this.cloudimage.x = this.resX - this.resX / 2;
					this.cloudimage.y = this.resY;
						
				}
				
			},

				// resizing for racing div wrapper inside wordpress //
				resize : function(){
				var screenWidth = jQuery("#stagewrapper").width();
				var screenHeight = jQuery(window).height()-jQuery("#stagewrapper").offset().top;
				
				this.resY = this.resX * screenHeight / screenWidth;
							
				document.getElementById("stage").width = this.resX;
				document.getElementById("stage").height = this.resY;
				
				jQuery("#stage").width(screenWidth);
				jQuery("#stage").height(screenHeight);
				
				var stage = new createjs.Stage(document.getElementById('stage'));				
				
				// clouds reference
				stage.addChild(this.cloudimage);
				this.cloudimage.x = this.resX;
				this.cloudimage.y = this.resY;
				
				for (var i = 0; i < this.roadLines; i++)
				{
					this.zMap.push(1 / (i - this.resY / 2));
				}
				
				this.playerZ = 100 / this.zMap[this.playerLine];
				for (i = 0; i < this.roadLines; i++)
				{
					this.zMap[i] *= this.playerZ;
				}

				var img1 = document.getElementById('Roads0001');
				var img2 = document.getElementById('Roads0002');
				var img3 = document.getElementById('Clouds');
				
				
				var sheet = new createjs.SpriteSheet({
				    // image to use
				    
				    images: [img1,img2,img3],
	
				    frames: [
				            // x, y, width, height, imageIndex, regX, regY
				            [0,0,img1.width,img1.height,0,img1.width / 2,img1.height / 2],
				            [0,0,img2.width,img2.height,1,img2.width / 2,img2.height / 2],
				            [0,0,img3.width,img3.height,2,img3.width / 2,img3.height / 2]			            
				        	],

				});
								
				// starting clouds after the children are already on the stage
				this.lineDepth = stage.getNumChildren();
				for (i = 0; i < this.roadLines; i++)
				{
					var line = new createjs.Sprite(sheet);
					this.lines.push(line);
					stage.addChildAt(line, this.lineDepth);
					line.x = this.resX / 2;
					line.y = this.resY - i;
				}
				
				this.halfWidth = this.resX / 2;
				for (i = 0; i < this.roadLines; i++)
				{
					this.lines[i].scaleX = this.halfWidth / 60 - 1.2;
					this.halfWidth -= this.widthStep;
				}
				createjs.Ticker.addEventListener("tick", stage);
				this.txt.font = "72px VT323";
				this.txt.color = "#FF7700"; 
				this.txt.textAlign = "center"; 
				this.txt.x = this.resX / 2; 
				stage.addChild(this.txt);
				// add another child to stage to modify
				
				
				

			},
			// accelerometer
			showPosition : function(oOrientation) {
				    if(oOrientation.gamma > 0 ){
						this.speed++;
					}else if(oOrientation.gamma < 0 )
					
					{
						this.speed--;
					}
				    if(this.speed < 0){
				    	this.speed = 0;
				    }
				    else if (this.speed > 255)				    
				    {
				    	this.speed = 255;
				    } 
				},
			
			race : function(){				
				this.rx = this.resX / 2;
				this.ry = this.resY;
				this.dx = 0;
				this.dy = 0;
				for (var i = 0; i < this.roadLines; i++)
				{
					// this animates the road
					if ((this.zMap[i] + this.texOffset) % 100 > 50){
						
						this.lines[i].gotoAndStop(0);
					}else{
						this.lines[i].gotoAndStop(1);
					}
						
					this.lines[i].x = this.rx;
					this.lines[i].y = this.ry;
					
					if (this.nextStretch == "Straight")
					{
						if (i >= this.segmentY)
						{
							this.dx += this.ddx;
							this.dy -= this.ddy;
						}
						else
						{
							this.dx -= this.ddx / 64;
							this.dy += this.ddy;
						}
					}
					else if (this.nextStretch == "Curved")
					{
						if (i <= this.segmentY)
						{
							this.dx += this.ddx;
							this.dy -= this.ddy;
						}
						else
						{
							this.dx -= this.ddx / 64;
							this.dy += this.ddy;
						}
					}
					this.rx += this.dx;
					this.ry += this.dy - 1;
				}
				this.texOffset = this.texOffset + this.speed;
				while (this.texOffset >= 100)
				{
					this.texOffset -= 100;
				}
				this.segmentY -= 1;
				while (this.segmentY < 0)
				{
					this.segmentY += this.roadLines;
					if (this.nextStretch == "Curved")
						this.nextStretch = "Straight";
					else
						this.nextStretch = "Curved";
				}
			},
				
				speedometer:function (){
					jQuery("#header").html(this.speed);
					this.txt.text = "SPEED:" + this.speed;
					
				}

			
		});

		jQuery(document).ready(function() {
			

			new Watcher();

		});
	</script>
	
<?php get_footer();
?>