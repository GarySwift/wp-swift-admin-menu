<p>To render the <b>Google Map</b> onto a webpage ther are two options: PHP code and WordPress <a href="https://codex.wordpress.org/Shortcode" target="_blank">Shortcodes</a>.</p>

<h4>PHP Code</h4>
<pre class="prettyprint lang-php custom">
// Render the Google Map

if (function_exists('get_google_map')) {
  echo get_google_map();
}

// Or you can optionally use parameters

if (function_exists('get_google_map')) {
  echo get_google_map( array('address' => true) );
}
</pre>

<h4>WordPress Shortcodes</h4>
Using shortcodes, you have the following options:
<pre class="prettyprint custom">
// WordPress shortcode

[google_map]

// This also accepts parameters

[google-map address="true"]
</pre>
<br>
<p>In both examples, code and shortcode, the parameters are used to display additonal content.</p>