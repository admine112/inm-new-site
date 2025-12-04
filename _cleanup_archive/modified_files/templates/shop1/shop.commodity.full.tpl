        <div class="mainframe">
            <div class="mfrhld_mn">
                <div class="dmy mn content_box">
                
                
<input type="hidden" class="item_id" value="{$com_id}">
<div class="main-content">
	<div class="product-page">
	
		<div class="product-page-wrap">
			
			<div class="single-product-body">

				<div class="prod-content">
					<h1>{$com_name}</h1>
					
				<div class="photo-block gallery_in" style='float:left;'>
					<a href="{$com_src}" class="prod-photo" rel='prettyPhoto[gallery2]'><img src="{$com_src}" rel='{$com_src}' alt='{$com_name}' id='id_img_{$com_id}'></a>			
					
				</div>
					<div class="inline_buy" align="right"><div class="price">{$com_price} <small>{$cur_show}</small></div><a class="buy" href="#"  onclick='javascript:buy({$com_id})'><img id="ida2960" src="/templates/{$theme_name}/images/buybtn.png"></a></div>
					
					
				
					{$com_fulldesc}
				</div>
			</div>
			
		</div>
	</div>					
</div>


</div>
            </div>
        </div>
        		        <div class="comments_box">
            <div class="cbholder">
                <div class="dmy">

                <a href="/" class="comments_sw_vk"></a>
                <a href="/" class="comments_sw_fb comments_sw_active"></a>

                <div class="like_holder">
                </div>

                <div class="comments_holder">
                    <div id="fb_cm">
                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>

                        <div class="fb-comments" data-href="{$request_domain}" data-width="940" data-num-posts="10"></div>
                    </div>

                    <!--<div id="vk_cm" style="display: none;">
                        <div id="vk_comments"></div>
                        <script type="text/javascript">
                        VK.Widgets.Comments("vk_comments", {limit: 20, width: "940", attach: "*"});

                        </script>
                    </div>-->
                </div>
                </div>
            </div>
        </div>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "{$com_name|escape:'html'}",
  "image": "https://inmunoflam.com.ua{$com_src}",
  "description": "{$com_fulldesc|strip_tags|truncate:300|escape:'html'}",
  "brand": {
    "@type": "Brand",
    "name": "Инмунофлам"
  },
  "offers": {
    "@type": "Offer",
    "url": "https://inmunoflam.com.ua/",
    "priceCurrency": "UAH",
    "price": "{$com_price|replace:' ':''}",
    "availability": "https://schema.org/InStock",
    "seller": {
      "@type": "Organization",
      "name": "Инмунофлам"
    }
  }
}
</script>
