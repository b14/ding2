!function($){function e(e,t){return e.length>t-3?e.substring(0,t-3)+"...":e}Drupal.behaviors.ding_ting_search_filters={attach:function(e,t){$("<div class='expand-search'>Afgræns din søgning</div>").insertAfter($(".pane-search-result-count")),$(".page-search-ting").find(".mobile-hide").wrapAll("<div class='hide-wrap'></div>"),$(".expand-search",e).click(function(){$(this).toggleClass("expanded"),$(this).parent().find(".hide-wrap").slideToggle("fast")})}},Drupal.behaviors.ding_ting_teaser_hover={attach:function(e,t){$(".ting-object.view-mode-teaser > .inner .group_text",e).mouseenter(function(){var e=$(this);setTimeout(function(){$(".ting-object.view-mode-teaser > .inner .group_text").css("z-index",""),e.css("z-index","1000")},300)})}},Drupal.behaviors.ding_ting_teaser_short_title={attach:function(t,i){$(".ting-object.view-mode-teaser > .inner .field-name-ting-title h2").each(function(){this.innerText=e(this.innerText,45)})}},Drupal.behaviors.ding_ting_teaser_image_width={attach:function(e,t){var i=$(".ting-object.view-mode-teaser img");$(i).each(function(){var e=new Image;e.src=$(this).attr("src");var t=$(this);e.onload=function(){var e=this.height,i=this.width,n=i/e,a=.7692;n>=a?t.addClass("scale-height"):i<e&&t.addClass("scale-width")}})}},Drupal.behaviors.ding_ting_object_list_mobile={attach:function(e,t){$(".ting-object.view-mode-search-result .inner",e).each(function(){$(this).find(".field-name-ting-details-genre, .field-name-ting-abstract, .field-name-ting-series, .search-result--availability").addClass("hidden"),$(this).find(".hidden").wrapAll("<div class='hide-wrap'></div>")}),$(".search-result--heading-type",e).click(function(){$(window).width()<600&&($(this).toggleClass("js-toggled"),$(this).parent().parent().find(".hide-wrap").slideToggle("fast"))})}},Drupal.behaviors.ding_ting_object_scrollto_other_formats={attach:function(e,t){var i=$("a.other-formats",e),n=$(".pane-ting-ting-object-types",e),a=$("html, body");i.on("click",function(e){e.preventDefault(),a.animate({scrollTop:n.offset().top-148},400)})}}}(jQuery);