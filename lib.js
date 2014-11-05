/*   _ _____   _   _            ______ _            _    
| | | |_   _| | \ | |           | ___ \ |          | |   
| | | | | |   |  \| | __ ___   _| |_/ / | ___   ___| | __
| | | | | |   | . ` |/ _` \ \ / / ___ \ |/ _ \ / __| |/ /
| |_| |_| |_  | |\  | (_| |\ V /| |_/ / | (_) | (__|   < 
 \___/ \___/  \_| \_/\__,_| \_/ \____/|_|\___/ \___|_|\_\	
 Copyright 2014 dandavis/University of Illinois at Urbana Champaign [CCBY2.0] or better.
 
 Moodle Block Supporting JavaScript
 uses jQuery to move menu from sidebar to content area and support options like number/text, vertical, caption, etc...

*/

//scope wrapper / psuedo onjQuery event:
(!window.CourseNavConfig ? Boolean : function runCourseNav() {

	if (!window.jQuery) { //no jq? leave now, but check again soon:
		return setTimeout(runCourseNav, 50);
	} /* end if $ */

	function complain(s){
		if(!window.console) return;
		if(console.warn) return console.warn(s);
		console.log(s);
	}
	
	//push the nav placement state to a bodyclass so that css can hit it no matter where it appears:
	jQuery("body").attr("data-nav-placement", CourseNavConfig.placement);
	
	//find where the jump menu will live:
	var target = jQuery(CourseNavConfig.placement ? ".course-content" : "#navblockcontainer")[0],
		div = jQuery("<ul class='nav nav-bonus'>"); // the actual menu div to build upon


	// nothing to do, let's blow this pop stand:
	if (!target) {
		return complain(CourseNavConfig.MSG_NO_TARGET);
	} /* end if */

	
	// page format check:
	// if not in topics or weekly view, don't bother showing the nav block, or doing anything else, just run away:
	if(!( CourseNavConfig.cfg.format=="weeks" || CourseNavConfig.cfg.format=="topics"   ) ){
		return complain(CourseNavConfig.MSG_NO_FORMAT);;
	} /* end if */
	


	// if both titles and numbers turned off, nothing really to do, let's bail:
	if (!CourseNavConfig.titles && !CourseNavConfig.numbers) {
		return complain(CourseNavConfig.MSG_NO_ITEMS);
	} /* end if */
	
	
	var items=jQuery(".section-title, .sectionname");
	
	/*
	 * Ability to link/anchor to a specific tab:	 */
	jQuery.unique(items).map(function(i,a){
		a.id=jQuery(a).text().toLowerCase().replace(/\W+/g,"");
	});


	// go up one to course container if middle layout:
	if (CourseNavConfig.placement) {
		target = target.parentNode;
	} /* end if */

	// inject vertical layout class if needed
	if (CourseNavConfig.vertical) {
		div.addClass("nb-vertical");
	} /* end if */


	// if not editing and not using sidebar placement, hide the whole dang block:
	if (CourseNavConfig.placement && !jQuery("body.editing").length) {
		jQuery(".block_navblock").hide();
	} /* end if */


	jQuery(items).each(function(i, a) {
		var linkText = "";

		var orig = jQuery(a).text();
		
		if (CourseNavConfig.numbers) {
			linkText += Number(jQuery(a).parent().parent().attr("id").split("-").pop()) + 1 + ". ";
		} /* end if */

		if (CourseNavConfig.titles) {
			linkText += orig;
		} /* end if */

		// nothing to say this section? let's bail:
		if(!jQuery.trim(linkText)){return;}
		
		div.append("<li>" + linkText.link("#" + a.id ).replace("<a", "<a class=navlink ") + "</li>");

		//now insert a back to top link after a, if it's 2+ deep
		if (i < 2) return;
		var newNode = jQuery("top".link("#top").replace("<a", "<a class=toplink "))[0];
		
		// add an animation to the navigation action, o ensure user notices the navigation happening:
		jQuery(newNode).click(function() {
			jQuery('html,body').animate({
				scrollTop: 1
			}, 200);
		});//end click() def
		
		// do the hokey-pokey and turn yourself around:
		a.parentNode.insertBefore(newNode, a);
		a.parentNode.insertBefore(a, newNode);

	}); // next section label

	//make clicking a link on the jump menu subtly animate the page, to ensure user notices the navigation happening:
	div.on("click", "a", function(e) {
		var os = jQuery("#" + this.href.split("#")[1]).offset().top;
		jQuery('html,body').animate({
			scrollTop: os
		}, 230, 'linear');
	});

	// now that config and data is gather, build the final jump menu html:
	var box = jQuery("<div id=navbox class=navbox role=navigation></div>");
	box.append("<strong class='pull-left'>" + (CourseNavConfig.caption || "") + "</strong> ");
	box.append(div);
	box.append("<br clear=both /><hr />");

	// add the generated html to the desired page placement :
	jQuery(target).prepend(box);



})(); /* end runCourseNav() */