!function(e,$){Drupal.behaviors.social_share={attach:function(e,o){$("a.twitter-share",e).click(function(e){e.preventDefault();var o=location.href,t={},n="socials";o="https://twitter.com/share?url="+encodeURIComponent(o)+"&amp;text="+encodeURIComponent(document.title),t.width=720,t.height=460;var a=[];for(var i in t)a.push(i+"="+t[i]);window.open(o,n,a.join(","))}),$("a.fb-share",e).click(function(e){e.preventDefault();var o=location.href,t={},n="socials";o="http://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(o)+"&amp;t="+encodeURIComponent(document.title),t.width=720,t.height=460;var a=[];for(var i in t)a.push(i+"="+t[i]);window.open(o,n,a.join(","))}),$("a.mail-share",e).click(function(e){e.preventDefault();var o=location.href,t="";o=encodeURIComponent(o),t=encodeURIComponent(document.title),document.location.href="mailto:?subject="+t+"&body="+t+"%0D%0A"+o})}}}(this,jQuery);