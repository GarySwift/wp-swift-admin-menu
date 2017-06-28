<pre class="prettyprint">
&lt;?php if (function_exists('get_social_media')): ?&gt;
	&lt;?php $social_media_links = get_social_media(); ?&gt;

	&lt;?php if ( count($social_media_links) ) : ?&gt;		     
	   	&lt;ul class=&quot;menu&quot;&gt;
	   		&lt;?php foreach ($social_media_links as $key =&gt; $link): 
	   		?&gt;&lt;li&gt;&lt;a href=&quot;&lt;?php echo $link['link']; ?&gt;&quot; class=&quot;icon-link&quot; target=&quot;_blank&quot;&gt;
	        		&lt;i class=&quot;fa &lt;?php echo $link['icon'].' '. $link['slug']; ?&gt;&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;
	        		&lt;span class=&quot;hide&quot;&gt;Social Media Link &lt;?php echo $link['name']; ?&gt;&lt;/span&gt;
	        	&lt;/a&gt;&lt;/li&gt;&lt;?php 
	        endforeach ?&gt;
	   	&lt;/ul&gt;
	&lt;?php endif; ?&gt;	

&lt;?php endif ?&gt;
</pre>
<h5>SASS Varibales</h5>
<pre class="prettyprint">
$twitter: #00aced;
$facebook: #3b5998;
$linkedin: #007bb6;
$youtube: #bb0000;
$google-plus: #dd4b39;
</pre>