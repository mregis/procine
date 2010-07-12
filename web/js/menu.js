var timeout    = 500;
var closetimer = 0;
var ddmenuitem = 0;

function mn_open()
{  mn_canceltimer();
   mn_close();
   ddmenuitem = jQuery(this).find('ul').css('visibility', 'visible');}

function mn_close()
{  if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');}

function mn_timer()
{  closetimer = window.setTimeout(mn_close, timeout);}

function mn_canceltimer()
{  if(closetimer)
   {  window.clearTimeout(closetimer);
      closetimer = null;}}

jQuery(document).ready(function()
{  jQuery('#mn > li').bind('mouseover', mn_open)
   jQuery('#mn > li').bind('mouseout',  mn_timer)
});

document.onclick = mn_close;
