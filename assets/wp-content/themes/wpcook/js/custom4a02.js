/*-----------------------------------------------------------------------------------*/
/*	Custom Script
/*-----------------------------------------------------------------------------------*/

jQuery.noConflict();
jQuery(document).ready(function(){

	jQuery('.recipe-search-go-btn').click(function(e) { // run the submit function, pin an event to it
        if (jQuery('input#recipe-search-keyword:text').val().length == 0) { // if s has no value, proceed
            e.preventDefault(); // prevent the default submission
            alert("Your search is empty!"); // alert that the search is empty
            jQuery('#recipe-search-keyword').focus(); // focus on the search input
        }
    });

    jQuery('#print-button').click( function(){
       	jQuery(".toggle").each(function() {
			jQuery(this).find(".togglebox").css("display","block");
			jQuery(this).find(".trigger").addClass( 'active' );
		});

		jQuery(".cbp-so-section").each(function() {
			jQuery(this).css("opacity","1");
			jQuery(this).css("-moz-opacity","1");
			jQuery(this).css("-khtml-opacity","1");
			jQuery(this).css("filter","alpha(opacity=1)");
		});
    });

    jQuery(".partners img").css("opacity","0.5");
	jQuery(".partners img").hover(function () {
		jQuery(this).stop().animate({ opacity: 1.0 }, "fast");  
	}, function () {
		jQuery(this).stop().animate({ opacity: 0.5 }, "fast");  
	});

    jQuery(".colored-area").each(function() {
		
			var $thisItemSlider = jQuery(this);
			var $thisWidthSlider = $thisItemSlider.parents().width();
			var $thisItemLeftSlider = $thisWidthSlider/2 - jQuery(window).width()/2;
				
			jQuery(this).css("width", jQuery(window).width());
			jQuery(this).css("margin-left",$thisItemLeftSlider);
			
	});

	jQuery("#home-testimonials").each(function() {
		
		var $thisItemSlider = jQuery(this);
		var $thisWidthSlider = $thisItemSlider.parents().width();
		var $thisItemLeftSlider = $thisWidthSlider/2 - jQuery(window).width()/2;
				
		jQuery(this).css("width", jQuery(window).width());
		jQuery(this).css("margin-left",$thisItemLeftSlider);
			
	});

	jQuery("#action-box").each(function() {
		
		var $thisItemSlider = jQuery(this);
		var $thisWidthSlider = $thisItemSlider.parents().width();
		var $thisItemLeftSlider = $thisWidthSlider/2 - jQuery(window).width()/2;
				
		jQuery(this).css("width", jQuery(window).width());
		jQuery(this).css("margin-left",$thisItemLeftSlider);
			
	});

	jQuery("#home-price-plans").each(function() {
		
		var $thisItemSlider = jQuery(this);
		var $thisWidthSlider = $thisItemSlider.parents().width();
		var $thisItemLeftSlider = $thisWidthSlider/2 - jQuery(window).width()/2;
				
		jQuery(this).css("width", jQuery(window).width());
		jQuery(this).css("margin-left",$thisItemLeftSlider);
			
	});

	// Tooltip
    jQuery('[data-rel]').each(function() {
      jQuery(this).attr('rel', jQuery(this).data('rel'));
  	});
    
    var targets = jQuery( '[rel~=tooltip]' ),
        target  = false,
        tooltip = false,
        title   = false;
 
    targets.bind( 'mouseenter', function()
    {
        target  = jQuery( this );
        tip     = target.attr( 'title' );
        tooltip = jQuery( '<div id="tooltip"></div>' );
 
        if( !tip || tip == '' )
            return false;
 
        target.removeAttr( 'title' );
        tooltip.css( 'opacity', 0 )
               .html( tip )
               .appendTo( 'body' );
 
        var init_tooltip = function()
        {
            if( jQuery( window ).width() < tooltip.outerWidth() * 1.5 )
                tooltip.css( 'max-width', jQuery( window ).width() / 2 );
            else
                tooltip.css( 'max-width', 340 );
 
            var pos_left = target.offset().left + ( target.outerWidth() / 2 ) - ( tooltip.outerWidth() / 2 ),
                pos_top  = target.offset().top - tooltip.outerHeight() - 20;
 
            if( pos_left < 0 )
            {
                pos_left = target.offset().left + target.outerWidth() / 2 - 20;
                tooltip.addClass( 'left' );
            }
            else
                tooltip.removeClass( 'left' );
 
            if( pos_left + tooltip.outerWidth() > jQuery( window ).width() )
            {
                pos_left = target.offset().left - tooltip.outerWidth() + target.outerWidth() / 2 + 20;
                tooltip.addClass( 'right' );
            }
            else
                tooltip.removeClass( 'right' );
 
            if( pos_top < 0 )
            {
                var pos_top  = target.offset().top + target.outerHeight();
                tooltip.addClass( 'top' );
            }
            else
                tooltip.removeClass( 'top' );
 
            tooltip.css( { left: pos_left, top: pos_top } )
                   .animate( { top: '+=10', opacity: 1 }, 50 );
        };
 
        init_tooltip();
        jQuery( window ).resize( init_tooltip );
 
        var remove_tooltip = function()
        {
            tooltip.animate( { top: '-=10', opacity: 0 }, 50, function()
            {
               	jQuery( this ).remove();
            });
 
            target.attr( 'title', tip );
        };
 
        target.bind( 'mouseleave', remove_tooltip );
        tooltip.bind( 'click', remove_tooltip );
    });

	//When page loads...
	jQuery(".tab_content").hide(); //Hide all content
	jQuery("ul.tabs li:first").addClass("active").show(); //Activate first tab
	jQuery(".tab_content:first").show(); //Show first tab content

	//On Click Event
	jQuery("ul.tabs li").click(function() {

		jQuery("ul.tabs li").removeClass("active"); //Remove any "active" class
		jQuery(this).addClass("active"); //Add "active" class to selected tab

		return false;
	});

	// setup ul.tabs to work as tabs for each div directly under div.panes
	jQuery("ul.tabs").tabs("> .pane", {effect: 'fade', fadeIn: 200});




	// Add tag icon
	jQuery('a[class^="tag-link-"]').each(function() {
        alttxt = jQuery(this).text();
        linkhref = jQuery(this).attr('href');

        jQuery(this).replaceWith(function() { return '<a title="tag: ' +alttxt+ '" href="' +linkhref+ '"><i class="fa fa-tag"></i>'+alttxt+'</a>'; });
    });
	 
	jQuery(window).load(function(){

		jQuery('.page-container .page-content').fadeTo( 300 , 1);

		jQuery('#featured-ads').fadeTo( 300 , 1);

		jQuery('#featured-ads-author').fadeTo( 300 , 1);

		jQuery('#featured-ads-category').fadeTo( 300 , 1);

		jQuery('li.has-submenu > a').each(function(i, ojb) {
	        jQuery(this).addClass('main-has-submenu');
	    });

	    jQuery('ul.sub-menu li.has-submenu > a').each(function(i, ojb) {
	        if ( jQuery(this).hasClass('main-has-submenu') ) {
	            jQuery(this).removeClass('main-has-submenu').addClass('child-has-submenu');
	        } else {
	        	jQuery(this).addClass('child-has-submenu');
	        }
	    });

		jQuery("li a.main-has-submenu").append("<i class='fa fa-chevron-down'></i>");

		jQuery("li a.child-has-submenu").append("<i class='fa fa-chevron-right'></i>");
		

	});

	jQuery(window).bind('resize', function () {



	});

	jQuery('ul.dish-menu-info-odd li').each(function(i) {
		var $li = jQuery(this);
		setTimeout(function() {
		    $li.addClass('wpcrown-start-animation');
		}, i*150); // delay 100 ms
	});

	jQuery('#thumbs a').each(function(i) {
		var $li = jQuery(this);
		setTimeout(function() {
		    $li.addClass('wpcrown-start-animation');
		}, i*150); // delay 100 ms
	});

	jQuery('#thumbs-wrapper-feat-recipes a').each(function(i) {
		var $li = jQuery(this);
		setTimeout(function() {
		    $li.addClass('wpcrown-start-animation');
		}, i*150); // delay 100 ms
	});


	jQuery('.remImage').live('click', function() {

		jQuery(this).parent().parent().fadeOut();
		jQuery(this).parent().find('input').attr('name', 'att_remove[]' );

    });

    jQuery(document).ready(function() {
	    jQuery(".target-blank").attr({"target" : "_blank"})
	});

	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() > 200) {
			jQuery('.backtop').fadeIn(200);
		} else {
			jQuery('.backtop').fadeOut(200);
		}
	});

	// scroll body to 0px on click
	jQuery(".backtop a").click(function () {
		jQuery("body,html").animate({
			scrollTop: 0
		}, 800);
		return false;
	});

	jQuery('#tag-index-page').isotope({
		itemSelector: '.tag-group',
		layoutMode: 'masonry'
	});


    function wrapStart(textHolder) { 
	    var node = jQuery(textHolder).contents().filter(function () { return this.nodeType == 3 }).first(),
	        text = node.text(),
	        first = text.split(" ", 1).join(" ");

	    if (!node.length)
	        return;
	    
	    node[0].nodeValue = text.slice(first.length);
	    node.before('<span class="light">' + first + '</span>');
	};

	wrapStart(jQuery(".wpcrown-title h2"));
	wrapStart(jQuery(".page-title"));
	wrapStart(jQuery(".related-ads h2"));

	jQuery('.block-title').each(function(i, ojb) {
	    var node = jQuery(this).contents().filter(function () { return this.nodeType == 3 }).first(),
	        text = node.text(),
	        first = text.split(" ", 1).join(" ");

	    if (!node.length)
	        return;
	    
	    node[0].nodeValue = text.slice(first.length);
	    node.before('<span class="light">' + first + '</span>');
	});


	jQuery('.custom-pane h3').each(function(i, ojb) {
	    var node = jQuery(this).contents().filter(function () { return this.nodeType == 3 }).first(),
	        text = node.text(),
	        first = text.split(" ", 1).join(" ");

	    if (!node.length)
	        return;
	    
	    node[0].nodeValue = text.slice(first.length);
	    node.before('<span class="light">' + first + '</span>');
	});



	function wrapStart2(textHolder) { 
	    var node = jQuery(textHolder).contents().filter(function () { return this.nodeType == 3 }).first(),
	        text = node.text(),
	        first = text.split(" ", 3).join(" ");

	    if (!node.length)
	        return;
	    
	    node[0].nodeValue = text.slice(first.length);
	    node.before('<span class="light">' + first + '</span>');
	};

	wrapStart2(jQuery(".comments-title"));


	// Menu filter
	// actiavte menu sorting
	elem = jQuery("#menu-sort-container");
	if (elem.is (".menu-sort-container")) {
	    jQuery.extend( jQuery.Isotope.prototype, {
	    _customModeReset : function() { 
	      
	        this.fitRows = {
	            x : 0,
	            y : 0,
	            height : 0
	          };
	      
	    },
	    _customModeLayout : function( $elems ) { 
	      
	    	var instance    = this,
	        containerWidth  = this.element.width(),
	        props       = this.fitRows,
	        margin      = 30, //margin based on %
	        extraRange  = 2; // adds a little range for % based calculation error in some browsers
	      
	        $elems.css({visibility:'visible'}).each( function() {
	            var $this = jQuery(this),
	            atomW = $this.outerWidth(),
	            atomH = $this.outerHeight(true);
	            
	            if ( props.x !== 0 && atomW + props.x > containerWidth + extraRange ) {
	              	// if this element cannot fit in the current row
	              	props.x = 0;
	              	props.y = props.height;
	            } 
	          
	        	//webkit gets blurry elements if position is a float value
	        	props.x = Math.round(props.x);
	        	props.y = Math.round(props.y);
	         
	            // position the atom
	            instance._pushPosition( $this, props.x, props.y );
	          
	            props.height = Math.max( props.y + atomH, props.height );
	            props.x += atomW + margin;
	        
	        	jQuery('#menu-sort-container').css({visibility:"visible", opacity:1});
	        	jQuery('#filters').css({visibility:"visible", opacity:1});
	        
	        
	          	});
	      
	      	},
	      	_customModeGetContainerSize : function() { 
	      
	        	return { height : this.fitRows.height };
	      
	     	 	},
	      		_customModeResizeChanged : function() { 
	      
	        		return true;
	        
	       		}
	    	});
	    
	      	var $container = jQuery('#menu-sort-container').css({visibility:"visible", opacity:0});

	    	$container.isotope({
	          	itemSelector : '.isotope-item',
	      		layoutMode : 'customMode'
	        });
	        
	        
	        var $optionSets = jQuery('#blog-post .sort_by_cat'),
	            $optionLinks = $optionSets.find('a');

	        $optionLinks.click(function(){
	          	var $this = jQuery(this);
	          	// don't proceed if already selected
	        if ( $this.hasClass('active_sort') ) {
	            return false;
	        }
	        var $optionSet = $this.parents('.sort_by_cat');
	        $optionSet.find('.active_sort').removeClass('active_sort');
	        $this.addClass('active_sort');
	    
	        // make option object dynamically, i.e. { filter: '.my-filter-class' }
	        var options = {},
	            key = $optionSet.attr('data-option-key'),
	            value = $this.attr('data-option-value');
	        // parse 'false' as false boolean
	        value = value === 'false' ? false : value;
	        options[ key ] = value;
	        if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
	            // changes in layout modes need extra logic
	            changeLayoutMode( $this, options )
	        } else {
	           	// otherwise, apply new options
	          	$container.isotope( options );
	        }
	          
	        return false;
	    });
	};

	elem = jQuery("#carousel-wrapper");
	if (elem.is (".carousel-wrapper")) {

		jQuery('#carousel').carouFredSel({
			responsive: true,
			circular: false,
			auto: false,
			items: {
				visible: 1
			},
			scroll: {
				fx: 'directscroll'
			}
		});

		jQuery('#thumbs').carouFredSel({
			responsive: true,
			circular: false,
			infinite: false,
			auto: false,
			prev: '#prev',
			next: '#next',
			items: {
				visible: {
					min: 1,
					max: 5
				}
			}
		});

		jQuery('#thumbs a').click(function() {
			jQuery('#carousel').trigger('slideTo', '#' + this.href.split('#').pop() );
			jQuery('#thumbs a').removeClass('selected');
			jQuery(this).addClass('selected');
			return false;
		});

	};


	elem = jQuery("#carousel-wrapper-feat-recipes");
	if (elem.is (".carousel-wrapper-feat-recipes")) {

		jQuery('#carousel-feat-recipes').carouFredSel({
			responsive: true,
			circular: false,
			auto: false,
			direction: "up",
			items: {
				visible: 1
			},
			scroll: {
				fx: 'directscroll'
			}
		});

		jQuery('#thumbs-feat-recipes').carouFredSel({
			responsive: false,
			circular: false,
			infinite: false,
			auto: false,
			prev: '#prev',
			next: '#next',
			direction: "up",
			height: "98",
			items: {
				visible: {
					min: 1,
					max: 5
				}
			}
		});

		jQuery('#thumbs-feat-recipes a').click(function() {
			jQuery('#carousel-feat-recipes').trigger('slideTo', '#' + this.href.split('#').pop() );
			jQuery('#thumbs-feat-recipes a').removeClass('selected');
			jQuery(this).addClass('selected');
			return false;
		});

	};

	jQuery("ul.recipe-ingredients li").click(function (){
     	jQuery(this).toggleClass('active');
	});



	//Toggle
	jQuery(".togglebox").hide();
	//slide up and down when click over heading 2
	
	jQuery("h4.trigger").click(function(){
		
		// slide toggle effect set to slow you can set it to fast too.
		jQuery(this).toggleClass("active").next(".togglebox").slideToggle("slow");
	
		return true;
	
	});

	// slide toggle effect set to slow you can set it to fast too.
	jQuery("h4.trigger.first-element").toggleClass("active").next(".togglebox").slideToggle("slow");



	// Add Step
	jQuery('#template_criterion').hide();
	jQuery('#submit_add_criteria').on('click', function() {		
		$newItem = jQuery('#template_criterion .option_item').clone().appendTo('#review_criteria').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id').replace("block-", "")) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var criterionText = (id+1);
		$newItem.children('span:eq(0)').text(criterionText);

		var nameText = 'wpcrown_recipe_step_option[' + id + '][0]';
		$newItem.find('.criteria_name').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpcrown_recipe_step_option[' + id + '][1]';
		var nameTextEmpty = '';
		$newItem.find('.recipe-desc').attr('id', nameText).attr('name', nameText).val(nameTextEmpty);

		var nameText = 'your_image_url_img' + id + '2';
		var nameTextEmpty = '';
		$newItem.find('img.criteria-image').attr('id', nameText).attr('src', nameTextEmpty);

		var nameText = 'your_image_url' + id + '2';
		var nameTextTwo = 'wpcrown_recipe_step_option[' + id + '][2]';
		$newItem.find('input.criteria-image-url').attr('id', nameText).attr('name', nameTextTwo);

		var nameText = 'your_image_url_button_remove' + id + '2';
		$newItem.find('input.criteria-image-button-remove').attr('id', nameText);

		var nameText = 'your_image_url_button' + id + '2';
		$newItem.find('input.criteria-image-button').attr('id', nameText);

		var nameText = 'wpcrown_recipe_step_option[' + id + '][3]';
		$newItem.find('.criteria-duration').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpcrown_recipe_step_option[' + id + '][4]';
		var nameTextEmpty = '';
		$newItem.find('.recipe-video').attr('id', nameText).attr('name', nameText).val(nameTextEmpty);

		//event handler for newly created element
		$newItem.children('.button_del_criteria').on('click', function () {
			jQuery(this).parent('.option_item').remove();
		});

	});
	
	// Delete Step
	jQuery('.button_del_criteria').on('click', function() {
		jQuery(this).parent('.option_item').remove();
	});




	// Add Ingredient
	jQuery('#template_ingredients_criterion').hide();
	jQuery('#submit_add_ingredient').on('click', function() {		
		$newItem = jQuery('#template_ingredients_criterion .option_item').clone().appendTo('#ingredients_criteria').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id')) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var nameText = 'wpcrown_recipe_ingredient_option[' + id + '][0]';
		$newItem.find('.ingredient_name').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpcrown_recipe_ingredient_option[' + id + '][1]';
		$newItem.find('.ingredient_amount').attr('id', nameText).attr('name', nameText);

		//event handler for newly created element
		$newItem.children('.button_del_ingredient').on('click', function () {
			jQuery(this).parent('.option_item').remove();
		});

	});
	
	// Delete Ingredient
	jQuery('.button_del_ingredient').on('click', function() {
		jQuery(this).parent('.option_item').remove();
	});




	// Add Ingredient
	jQuery('#template_nutrition_criterion').hide();
	jQuery('#submit_add_nutrition').on('click', function() {		
		$newItem = jQuery('#template_nutrition_criterion .option_item').clone().appendTo('#nutrition_criteria').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id')) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var nameText = 'wpcrown_recipe_nutrition_option[' + id + '][0]';
		$newItem.find('.ingredient_name').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpcrown_recipe_nutrition_option[' + id + '][1]';
		$newItem.find('.ingredient_amount').attr('id', nameText).attr('name', nameText);

		//event handler for newly created element
		$newItem.children('.button_del_nutrition').on('click', function () {
			jQuery(this).parent('.option_item').remove();
		});

	});
	
	// Delete Ingredient
	jQuery('.button_del_nutrition').on('click', function() {
		jQuery(this).parent('.option_item').remove();
	});



	// Portfolio filter
	// actiavte portfolio sorting
	elem = jQuery("#recipe-sort-container");
	if (elem.is (".recipe-sort-container")) {
	    jQuery.extend( jQuery.Isotope.prototype, {
	      _customModeReset : function() { 
	      
	        this.fitRows = {
	            x : 0,
	            y : 0,
	            height : 0
	          };
	      
	       },
	      _customModeLayout : function( $elems ) { 
	      
	        var instance 		= this,
		        containerWidth 	= this.element.width(),
		        props 			= this.fitRows,
		        margin 			= 32, //margin based on %
		        extraRange		= 0; // adds a little range for % based calculation error in some browsers
	      
	          $elems.css({visibility:'visible'}).each( function() {
	            var $this = jQuery(this),
	                atomW = $this.outerWidth(),
	                atomH = $this.outerHeight(true);
	            
	            if ( props.x !== 0 && atomW + props.x > containerWidth + extraRange ) {
	              // if this element cannot fit in the current row
	              props.x = 0;
	              props.y = props.height;
	            } 
	          
	          //webkit gets blurry elements if position is a float value
	          props.x = Math.round(props.x);
	          props.y = Math.round(props.y);
	         
	            // position the atom
	            instance._pushPosition( $this, props.x, props.y );
	          
	            props.height = Math.max( props.y + atomH, props.height );
	            props.x += atomW + margin;
	        
	        jQuery('#recipe-sort-container').css({visibility:"visible", opacity:1});
	        jQuery('#filters').css({visibility:"visible", opacity:1});
	        
	        
	          });
	      
	      },
	      _customModeGetContainerSize : function() { 
	      
	        return { height : this.fitRows.height };
	      
	      },
	      _customModeResizeChanged : function() { 
	      
	        return true;
	        
	       }
	    });
	    
	    var $container = jQuery('#recipe-sort-container').css({visibility:"visible", opacity:0});

	    $container.isotope({
	       	itemSelector : '.isotope-item',
	     	layoutMode : 'customMode'
	    });
	        
	        
	    var $optionSets = jQuery('#portfolio .sort_by_cat'),
	        $optionLinks = $optionSets.find('a');

	   $optionLinks.click(function(){
		    var $this = jQuery(this);
		    // don't proceed if already selected
		    if ( $this.hasClass('active_sort') ) {
		        return false;
		    }
		    var $optionSet = $this.parents('.sort_by_cat');
		    $optionSet.find('.active_sort').removeClass('active_sort');
		    $this.addClass('active_sort');
		    
		    // make option object dynamically, i.e. { filter: '.my-filter-class' }
		    var options = {},
		        key = $optionSet.attr('data-option-key'),
		        value = $this.attr('data-option-value');
		    // parse 'false' as false boolean
		    value = value === 'false' ? false : value;
		    options[ key ] = value;
		    if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
		        // changes in layout modes need extra logic
		        changeLayoutMode( $this, options )
		    } else {
		        // otherwise, apply new options
		        $container.isotope( options );
		    }
		          
		return false;

	    });
	};

	if (document.getElementById( 'recipe-block' )) {
		new cbpScroller( document.getElementById( 'recipe-block' ), {
			minDuration : 0.4,
			maxDuration : 0.7,
			viewportFactor : 0.2
		} );
	}

});