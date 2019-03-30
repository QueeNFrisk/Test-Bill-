(function($, undefined){
    $.nette.ext('autorefresh',{
        init:   function(){
            $(this.selector).each(function(index){
                var url = $(this).data("refresh-url");
                var time = $(this).data("refresh-time")*1000;
                setInterval(function(url) {
                    $.nette.ajax(url);
                }, time, url);
            });
        },
        start:  function(){
            $("#ajax-spinner").hide();
        }
    },{
        selector:    ".autorefresh"     
    });
})(jQuery);
