function ajaxSetStatus(elem, id){
	$.ajax({
		url: $(elem).attr('href'),
		success: function(){
			$('#'+id).yiiGridView.update(id);
		}
	});
}

function ajaxMoveRequest(url, tableId){
	$.ajax({
		url: url,
		data: {ajax:1},
		method: "get",
		success: function(){
			$("#"+tableId).yiiGridView.update(tableId);
		}
	});
}

(function ($) {
    $.fn.extend({
        //pass the options variable to the function
        confirmModal: function (options) {
            var html = '<div class="modal" id="confirmContainer"><div class="modal-header"><a class="close" data-dismiss="modal">×</a>' +
            '<h3>#Heading#</h3></div><div class="modal-body">' +
            '#Body#</div><div class="modal-footer">' +
            '<a href="javascript: void(0);" class="btn btn-primary" id="confirmYesBtn">#Confirm#</a>' +
            '<a href="javascript: void(0);" class="btn" data-dismiss="modal">#Close#</a></div></div>';

            var defaults = {
                heading: 'Please confirm',
                body:'Body contents',
				confirmButton: 'Да',
				closeButton: 'Нет',
                callback : null
            };

            var options = $.extend(defaults, options);
            html = html.replace('#Heading#',options.heading).replace('#Body#',options.body).replace('#Confirm#',options.confirmButton).replace('#Close#',options.closeButton);
            $(this).html(html);
            $(this).modal('show');
            var context = $(this);
            $('#confirmYesBtn',this).click(function(){
                if(options.callback!=null)
                    options.callback();
                $(context).modal('hide');
            });
        }
    });

})(jQuery);