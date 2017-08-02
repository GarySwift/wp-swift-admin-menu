<?php
function wp_swift_add_after_content( $content ) {   
	$acf_content = the_acf_content();
    return $content.$acf_content;
}
add_filter( 'the_content', 'wp_swift_add_after_content' );


/** Custom Functions */
function the_acf_content($image_size='', $row_class='') {
	$acf_content = '';
	if( have_rows('modules') ):
	    while ( have_rows('modules') ) : the_row();

	        if( get_row_layout() == 'video' ):

	        	$acf_content = get_acf_video();

	        elseif( get_row_layout() == 'gallery' ): 
	        	if( get_sub_field('images') ) {
	        	    $acf_content = get_acf_gallery( get_sub_field('images'), $row_class );
	        	}
	        endif;

	    endwhile;
	endif;
	return $acf_content;	
}

function get_acf_video($row_class='') {
	$acf_content = '';
	if(is_single()) :
		$iframe = get_sub_field('video');
		ob_start();
		?>
		<div class="row">
			<div class="embed-container">
				<?php echo $iframe ?>
			</div>
		</div>
		<?php
		
		$acf_content = ob_get_contents();
		ob_end_clean();
	else:

		$url = get_sub_field('video', false, false);
		$url = strtok($url, '?');
		$url = urldecode(rawurldecode($url));
	    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
		if (isset($matches[1])):
			ob_start();
			?><div class="row">
				<div class="embed-container-placeholder">
					<div class="youtube-player" data-id="<?php echo $matches[1] ?>"></div>
				</div>
			</div><?php
			$acf_content = ob_get_contents();
			ob_end_clean();
		endif;//@end isset($matches[1])
	endif;//@end is_single

return $acf_content;
}
function get_acf_gallery($images, $row_class='') {
	$acf_content = '';
	$diff= false;
	$count = 0;	
	$limit = count($images);

	// Limit the amount of images shown if shown in blog view to save loading time
	$single_post = is_single();
	if(!$single_post) {
		$limit=4;
		$totalImgs = count($images);
		if($totalImgs>$limit) {
			$diff = $totalImgs - $limit;
		}	
	} 

	$thumbnail_size = 'medium_large';
	if (!$row_class) {
		$row_class= 'small-up-2 medium-up-2 large-up-2';
	}
	
	if (!$single_post) {
	 	$thumbnail_size = 'thumbnail';
	 	$row_class= 'small-up-2 medium-up-4 large-up-4';
	}
	ob_start();
	?>
	<div class="row <?php echo $row_class ?> lightbox-gallery">
		<?php 
		foreach( $images as $image ): 
            $defaultImgCaption = '';
            $defaultImgTitle = '';
            $image_caption = '';
			// if (isset($image['caption']) && $image['caption']) {
			// 	$image_caption = ' title="'.$image['caption'].'"';
			// }
			// else
			if (isset($image['alt']) && $image['alt']) { 
				$image_caption = ' title="'.$image['alt'].'"';
			}

	    	?>
			<div class="column gallery-item">   
			    <a href="<?php echo $image['sizes']['fp-large']; ?>" class="lightbox"<?php echo $image_caption; ?>>
					<img class="thumbnail" src="<?php echo $image['sizes'][$thumbnail_size]; ?>" alt="<?php echo ($image['alt'] ? $image['alt']  : 'Image'); ?>" />
					<?php /* title="<?php echo ($image['alt'] ? $image['alt']  : $defaultImgTitle); ?>"  */ ?>
				</a>
			</div>
			<?php
			if (++$count == $limit) {
				break;
			}		
		endforeach; ?>

		<?php if($diff): ?>
			<div class="text-right">
				<i class="fa fa-plus"></i>
				<span class=" badge "><?php echo $diff; ?></span>
			</div>
		<?php endif; ?>	
	</div>
	<?php
	
	$acf_content = ob_get_contents();
	ob_end_clean();
	return $acf_content;
}

function featured_image_check() {
	if( !have_rows('modules') ) {
		the_image();
	}
}

function the_image() {
global $post;
// If a featured image is set, insert into layout
if ( has_post_thumbnail( $post->ID ) ) : 
	$post_thumbnail_id = get_post_thumbnail_id( $post );
	$thumb = get_post( $post_thumbnail_id );
	$alt = get_post_meta( $thumb->ID, '_wp_attachment_image_alt', true ); //alt text 
	if (!$alt) {
		$alt = get_the_title();
	}
	?>
	<div id="featured-image-posts">
		
		<?php if (is_single()): ?>
			<div class="gallery-item">
				<a href="<?php echo the_post_thumbnail_url('large'); ?>" class="lightbox"><img class="thumbnail" alt="<?php echo $alt; ?>" src="<?php echo the_post_thumbnail_url('large'); ?>"></a>
			</div>
		<?php else: ?>
			
				<a href="<?php echo get_permaLink($post->ID) ?>"><img class="thumbnail" alt="<?php echo $alt; ?>" src="<?php echo the_post_thumbnail_url('large'); ?>"></a>
			
		<?php endif ?>
		
	</div>
<?php endif;
}