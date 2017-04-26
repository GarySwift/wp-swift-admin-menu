<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam corrupti, deserunt optio maiores. Nemo quasi voluptate, doloremque. Ipsum vero, pariatur sequi libero, velit exercitationem totam est omnis. Maxime iure, voluptatem.</p>
<h4>PHP Code</h4>
<pre class="prettyprint lang-php custom">
if ( function_exists('get_phone') )  {

    $phone_readable = get_phone('office_phone');
    $phone = get_phone('office_phone', true);

    $mobile_readable = get_phone('mobile');
    $mobile = get_phone('mobile', true);

}
</pre>
<h4>HTML/PHP Code</h4>
<i><small>Sample output</small></i>
<pre class="prettyprint lang-html custom">
&lt;div class=&quot;key-value&quot;&gt;&lt;span class=&quot;key&quot;&gt;Tel&lt;/span&gt;&lt;span class=&quot;value&quot;&gt;&lt;a href=&quot;tel:&lt;?php echo $phone; ?&gt;&quot;&gt;&lt;?php echo $phone_readable; ?&gt;&lt;/a&gt;&lt;/span&gt;&lt;/div&gt;
</pre>