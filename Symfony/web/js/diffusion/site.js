$(document).ready(function() 
{
    $(".close").css("display", "none");
 
    var isMenuOpen = false;
 
    $('.menu_btn').click(function()
    {
        if (isMenuOpen == false)
        {
            $("#menu").clearQueue().animate({
                left : '0'
            })
             
            $(this).fadeOut(200);
            $(".close").fadeIn(300);
             
            isMenuOpen = true;
        } 
    });
     
    $('.close').click(function()
    {
        if (isMenuOpen == true)
        {
            $("#menu").clearQueue().animate({
                left : '-245px'
            })
            $("#page").clearQueue().animate({
                "margin-right" : '0px',
                "margin-left" : '0px'
            })
             
            $(this).fadeOut(200);
            $(".menu_btn").fadeIn(300);
             
            isMenuOpen = false;
        }
    });

    $('.lien').click(function()
    {
        $('.barre').remove();
        $(this).parent().prepend('<div class="barre"></div>');
    });

});