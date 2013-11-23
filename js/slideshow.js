/*
	Author:Parker Smith
	Date: Nov 15 2013
	Course: PROJ216 Team 6
	Assignment: Threaded workshop phase I 
				Travel Experts Web Site
 
 This page enables the slideshow displayed on index.php.
*/

var count=0;

		
		//creates an array of objects to hold info on packages to be displayed
		var isImageHolder = [
			{
				src:"./images/caribbean.png", 
				hold:"./images/slideHold.png",
				id:"1"
				},
			{
				src:"./images/polypara.png", 
				hold:"./images/slideHold.png",
				id:"2"
				},
			{
				src:"./images/chinaVaca.png", 
				hold:"./images/slideHold.png", 
				id:"3"
				},
			{
				src:"./images/eurotrav.png",
				hold:"./images/slideHold.png", 
				id:"4"
				}
		]	
		
		/*This function is called by initialize, on body load.
		It loads all of the on click images to be displayed for every photo on the slideshow.*/
		function loadDesc(){
			
			var v = 0;
			
			while(v<4)
			{
				var tablecontainer = document.getElementById("desc" + v);
				tablecontainer.src = isImageHolder[v].hold;
				v++;
			}
		}
		
		/*This is the main slideshow dislay function, it accepts an int as a parameter to act as an iterator.
		It loads all images to the screen, calls loadDesc to reset all pointer images then displays one as blue.
		It sets variable count to the value of i to keep the image place after user has changed image displayed.*/
		function imageView(i){
			var container = document.getElementById("imageS");
			var slideOn = document.getElementById("desc"+i);
			var holder = isImageHolder[i].src;
			
			container.innerHTML = null;
			container.src = holder;
			
			loadDesc();
			buttonValue(i);
			slideOn.src = "./images/slideOn.png";
			
			count = i;
		}
		
		/*This function sets and keeps track of the timer. It calls imageView every 3 seconds.
		It sets the slideshow play button to display none.*/
		function setTimer(){
			document.getElementById("slideStopper").style.display="none";
			
			if(count == 4)
			{
				count = 0;
			}
			imageView(count);
			count++;
			
			timer = setTimeout(function(){setTimer()},3000);
		}
		
		/*This function stops the slideshow on click.
		It displays the slideshow play button inline on click.
		It clears the timer.*/
		function stopSlide(){
			clearTimeout(timer);
			var divHolder = document.getElementById("slideStopper");
			
			divHolder.style.display="inline";
		}
		
		/*This function sets the value of the order button to be passed based on the image currently displayed.*/
		function buttonValue(i){
			document.getElementById("order").value = isImageHolder[i].id;
		}
		
		/*Sets up the javascript for the index.php page*/
		function initialize(){
			imageView(0); 
			loadDesc();
			setTimer();
		}