<pre class="prettyprint">
if(is_array(get_field('link', 'option'))): ?&gt;
&lt;ul&gt;
    &lt;?php
    $media = get_field('link', 'option');
    foreach ($media as $link): 
    ?&gt;
&lt;li&gt;&lt;a class=&quot;social-media-link&quot; href=&quot;&lt;?php echo $link['link']; ?&gt;&quot; title=&quot;&lt;?php echo $link['title']; ?&gt;&quot; target=&quot;_blank&quot;&gt;&lt;i class=&quot;fa &lt;?php echo $link['icon']; ?&gt; social&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt; &lt;?php echo $link['name']; ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php 
    endforeach;
    ?&gt;
&lt;/ul&gt;
    &lt;?php 
endif;
</pre>