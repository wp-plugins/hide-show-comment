/**
 * Hide Show Comment
 *
 * @author 	Haris Ainur Rozak
 * @since 	0.1
 */
;(function($) {

	$.WPHSC = function(el, opt) 
	{
		var base = this;

		base.el = el;
        base.$el = $(base.el);

        base.$wpComment = base.$el.find('.hsc-comment-class');
        base.count = base.$wpComment.length;

        base.$wpComment.parent('ol').first().wrap('<div class="hsc-comment-container" />');
        base.$container = base.$wpComment.parent('ol').parent('.hsc-comment-container');

		base.initialize = function()
		{
			if (window.location.hash) 
			{
    			base.hash = window.location.hash.substring(1);
    		}
    		else
    		{
    			base.hash = 'undefined';
    		}

			if(opt.hideShow) base.hideShow();
			if(opt.loadMore) 
			{
				if(base.hash == 'undefined' || base.hash == 'comments') base.loadMore();
			}
		}

		base.hideShow = function()
		{
			if(opt.hideShowIdentifierMode == 'auto')
			{
				$(opt.hideShowHtml).insertBefore(base.$container);
			}
			else
			{
				base.$hideShowIdentifier = $(opt.hideShowIdentifier);
				base.$hideShowIdentifier.wrapInner('<div class="hsc-comment-container" />');

				base.$containerIdentifier = base.$hideShowIdentifier.children('.hsc-comment-container');

				$(opt.hideShowHtml).insertBefore(base.$containerIdentifier);
			}			

			base.$btnHideShow = $('#hsc-btn-hideshow');
			base.$countHideShow = $('#hsc-count-hideshow');

			// collecting all .hsc-comment-container
			base.$containerAll = $('.hsc-comment-container');

			// show if hash defined
			if(base.hash == 'undefined')
			{
				base.$containerAll.css('display','none');				
			}
			else
			{
				base.$btnHideShow.html('<span>' + opt.hideShowTextHide + '</span>');
				base.$btnHideShow.addClass('active');
				base.$countHideShow.addClass('active');
			}

			// button
			base.$btnHideShow.click(function(){				
				if($(this).hasClass('active'))
				{
					base.$btnHideShow.html('<span>' + opt.hideShowTextShow + '</span>');
					hideContainer();
				}
				else
				{
					base.$btnHideShow.html('<span>' + opt.hideShowTextHide + '</span>');
					showContainer();
				}
			})

			// count
			base.$countHideShow.click(function(){
				if($(this).hasClass('active'))
				{
					hideContainer();
				}
				else
				{
					showContainer();		
				}
			})

			function showContainer()		
			{
				var animation = opt.hideShowAnimation;

				base.$btnHideShow.addClass('active');
				base.$countHideShow.addClass('active');

				if(animation == 'slide')
				{
					base.$containerAll.slideDown();
				}
				else if(animation == 'fade')
				{
					base.$containerAll.fadeIn();
				}
				else
				{
					base.$containerAll.show();
				}	
			}

			function hideContainer()
			{
				var animation = opt.hideShowAnimation;

				base.$btnHideShow.removeClass('active');
				base.$countHideShow.removeClass('active');

				if(animation == 'slide')
				{
					base.$containerAll.slideUp();
				}
				else if(animation == 'fade')
				{
					base.$containerAll.fadeOut();
				}
				else
				{
					base.$containerAll.hide();
				}	
			}
		}

		base.loadMore = function()
		{
			$(opt.loadMoreHtml).insertAfter(base.$wpComment.last());

			base.$btnLoadMore = $('#hsc-btn-loadmore');
			base.$wpComment.css('display','none');

			count = 0;

			doLoadMore(true);

			base.$btnLoadMore.click(function(){				
				doLoadMore();				
			})

			function doLoadMore(isFirst)
			{
				var animation = isFirst ? 'none' : opt.loadMoreAnimation;

				for (var i = 1; i <= opt.loadMoreCount; i++) 
				{
					if(animation == 'slide')
					{
						base.$wpComment.eq(count++).slideDown();
					}
					else if(animation == 'fade')
					{
						base.$wpComment.eq(count++).fadeIn();
					}
					else
					{
						base.$wpComment.eq(count++).show();
					}					
				};
				
				if(count >= base.count)
				{
					base.$btnLoadMore.remove();
				}
			}
		}
	}
	
	
	/**
	 * Implementation
	 *
	 * @since 	0.1
	 */	 	 
	$.WPHSC.defaults = {		
	    'hideShow': true,
	    'hideShowHtml': "<a href='javascript:;' id='hsc-btn-hideshow'><span>Comment</span></a>",
	    'hideShowTextShow': "Show Comment",
	    'hideShowTextHide': "Hide Comment",	  
	    'hideShowIdentifierMode': 'auto', // auto, manual
	    'hideShowIdentifier': '#comments', 
	    'hideShowAnimation': 'none', 
	    'loadMore': true,
	    'loadMoreHtml': "<a href='javascript:;' id='hsc-btn-loadmore'><span>Load More</span></a>",
	    'loadMoreCount': 3,
	    'loadMoreAnimation': 'none'
	}
	
	$.fn.WPHSC = function(options) 
	{
		var base = this;
		var opt = $.extend({}, $.WPHSC.defaults, options);
		var plugin = new $.WPHSC(base, opt);

        base.each(function() {
            plugin.initialize();
        });

        return base;
	};

})(jQuery);


// Run
jQuery(document).ready(function($){
	var hsc = $('body').WPHSC({
		'hideShow': hide_show,
		'hideShowHtml': hsc_hideshow_print,
		'hideShowTextShow': hsc_show_button_text,
	    'hideShowTextHide': hsc_hide_button_text,
	    'hideShowIdentifierMode': identifier_type,
	    'hideShowIdentifier': comment_identifier,
	    'hideShowAnimation': hide_show_animation,
		'loadMore': load_more,
	    'loadMoreHtml': hsc_loadmore_print,
	    'loadMoreCount': loadmore_load_number,
	    'loadMoreAnimation': load_more_animation
	});
});