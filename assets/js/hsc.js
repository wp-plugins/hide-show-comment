jQuery(document).ready(function()
{
	jQuery(hsc_identifier).wrapInner("<div class='hsc-comment-container' />")
	jQuery(hsc_identifier).prepend(hsc_print)

	jQuery('[hsc-comment-button]').click(function()
	{
		if(jQuery('.hsc-comment-container').hasClass('active'))
		{
			jQuery('.hsc-comment-container').removeClass('active')
			jQuery('[hsc-comment-button]').html('<span>' + hsc_show_button_text + '</span>')
		}
		else
		{
			jQuery('.hsc-comment-container').addClass('active')
			jQuery('[hsc-comment-button]').html('<span>' + hsc_hide_button_text + '</span>')
		}

		return false;
	})

	jQuery('[hsc-comment-count]').click(function()
	{
		if(jQuery('.hsc-comment-container').hasClass('active'))
		{
			jQuery('.hsc-comment-container').removeClass('active')
		}
		else
		{
			jQuery('.hsc-comment-container').addClass('active')
		}

		return false;
	})
})