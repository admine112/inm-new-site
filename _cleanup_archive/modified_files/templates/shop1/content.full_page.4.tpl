        <script type="text/javascript">
			$(document).ready(function(){
			 $('.spoiler_links').click(function(){
			  $(this).parent().children('div.spoiler_body').toggle('normal');
			  return false;
			 });
			});
		</script>
		<div class="mainframe">
            <div class="mfrhld_mn">
                <div class="dmy mn content_box">
			
			<h1>{$center_name}</h1>
			{$center_text}
			{$lines}
		 </div>
            </div>
        </div>
		
		<div class="comments_box">
            <div class="cbholder">
                <div class="dmy">
                <a href="/" class="comments_sw_fb comments_sw_active"></a>
                <div class="like_holder"></div>
                <div class="comments_holder" style="width:500px;">
                    <div id="fb_cm">
						<div id="fb-root"></div>
						<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v8.0" nonce="YZaYFUzG"></script>
						<div class="fb-page" data-href="https://www.facebook.com/inmunoflam" data-tabs="timeline" data-width="500" data-small-header="true" data-hide-cover="true">
							<blockquote cite="https://www.facebook.com/inmunoflam" class="fb-xfbml-parse-ignore">
								<a href="https://www.facebook.com/inmunoflam">Inmunoflam.com.ua</a>
							</blockquote>
						</div>
                    </div>
                </div>
                </div>
            </div>
        </div>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "{$center_name|escape:'html'}",
  "author": {
    "@type": "Organization",
    "name": "Инмунофлам"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Инмунофлам",
    "logo": {
      "@type": "ImageObject",
      "url": "https://inmunoflam.com.ua/templates/shop1/images/logo.png"
    }
  },
  "image": "https://inmunoflam.com.ua/templates/shop1/images/logo.png",
  "description": "{$center_text|strip_tags|truncate:160|escape:'html'}"
}
</script>
