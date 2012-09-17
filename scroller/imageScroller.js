$(function() {

	// remove js-disabled class
	$("#viewer").removeClass("js-disabled");

	var all_width = 0;

	$(".img_scroll").each(function() {
		all_width += 225;
	});
	// create new container for images
	$("<div>").attr("id", "container").css({
		position : "absolute"
	}).width(all_width).height(170).appendTo("div#viewer");

	// add images to container
	$(".wrapper").each(function() {
		$(this).appendTo("div#container");
	});

	// work out duration of anim based on number of images (1 second for each
	// image)
	var duration = $(".wrapper").length * 3000;

	// store speed for later (distance / time)
	var speed = (parseInt($("div#container").width()) + parseInt($("div#viewer").width())) / duration;

	// set direction
	var direction = "rtl";

	// set initial position and class based on direction
	(direction == "rtl") ? $("div#container").css("left", $("div#viewer").width()).addClass("rtl") : $("div#container").css("left",
			0 - $("div#container").width()).addClass("ltr");

	// animator function
	var animator = function(el, time, dir) {

		// which direction to scroll
		if (dir == "rtl") {

			// add direction class
			el.removeClass("ltr").addClass("rtl");

			// animate the el
			el.animate({
				left : "-" + el.width() + "px"
			}, time, "linear", function() {

				// reset container position
				$(this).css({
					left : $("div#imageScroller").width(),
					right : ""
				});

				// restart animation
				animator($(this), 24000, "rtl");

				// hide controls if visible
				($("div#controls").length > 0) ? $("div#controls").slideUp("slow").remove() : null;

			});
		} else {

			// add direction class
			el.removeClass("rtl").addClass("ltr");

			// animate the el
			el.animate({
				left : $("div#viewer").width() + "px"
			}, time, "linear", function() {

				// reset container position
				$(this).css({
					left : 0 - $("div#container").width()
				});

				// restart animation
				animator($(this), 24000, "ltr");

				// hide controls if visible
				($("div#controls").length > 0) ? $("div#controls").slideUp("slow").remove() : null;
			});
		}
	}
//console.log(duration);
	// start anim
	animator($("div#container"), 24000, direction);

	// pause on mouseover
	$("a.wrapper").live(
			"mouseover",
			function() {
				html = '<a href="' + $(this).attr('href') + '"><img src="' + $(this).attr('rel') + '" width="400"/></a>'
				$.colorbox({
                                        scrolling : false,
					html : html,
					width : "400px",
					opacity : 0.75,
					onOpen : function() {
						$("div#container").stop(true);
					},
					onClosed : function() {
	/*					var totalDistance = parseInt($("div#container").width()) + parseInt($("div#viewer").width());

						// work out distance left to travel
						var distanceLeft = ($("div#container").hasClass("ltr")) ? totalDistance
								- (parseInt($("div#container").css("left")) + parseInt($("div#container").width())) : totalDistance
								- (parseInt($("div#viewer").width()) - (parseInt($("div#container").css("left"))));

						// new duration is distance left /
						// speed)
						var newDuration = distanceLeft / speed;*/

						// restart anim
						animator($("div#container"), 24000, $("div#container").attr("class"));
					}
				});

				$("div#container").stop(true);
			});

});