<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */
?>

<?php
$amcust_debug_content = false;
/* Helper variables for this template */
$is_single          = is_single();
$post_meta_enabled  = kleo_postmeta_enabled();
$post_media_enabled = ( kleo_postmedia_enabled() && kleo_get_post_thumbnail() != '' );
/* Check if we need an extra container for meta and media */
$show_extra_container = $is_single && sq_kleo()->get_option( 'has_vc_shortcode' ) && $post_media_enabled;

$post_class = 'clearfix';
if ( $is_single && get_cfield( 'centered_text' ) == 1 ) {
	$post_class .= ' text-center';
}

?>

<!-- Begin Article -->
<article id="post-<?php the_ID(); ?>" <?php post_class( array( $post_class ) ); ?>>

	<?php if ( ! $is_single ) : ?>
		<h2 class="article-title entry-title">
			<a href="<?php the_permalink(); ?>"
			   title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'kleo_framework' ), the_title_attribute( 'echo=0' ) ) ); ?>"
			   rel="bookmark"><?php the_title(); ?></a>
		</h2>
	<?php endif; //! is_single() ?>

	<?php if ( $show_extra_container ) : /* Small fix for full width layout to center media and meta */ ?>
	<div class="container">
		<?php endif; ?>

		<?php if ( $post_meta_enabled ) : ?>
			<div class="article-meta">
				<span class="post-meta">
				    <?php kleo_entry_meta(); ?>
				</span>
				<?php edit_post_link( esc_html__( 'Edit', 'kleo_framework' ), '<span class="edit-link">', '</span>' ); ?>
			</div><!--end article-meta-->

		<?php endif; ?>

		<?php if ( $post_media_enabled ) : ?>
			<div class="article-media">
				<?php echo kleo_get_post_thumbnail( null, 'kleo-full-width' ); ?>
			</div><!--end article-media-->
		<?php endif; ?>

		<?php if ( $show_extra_container ) : /* Small fix for full width layout to center media and meta */ ?>
	</div>
<?php endif; ?>

	<div class="article-content">
		<div class="container amcust_page-title-container amcust-title-below-media">
			<h1 class="page-title"><?php the_title(); ?></h1>
		</div>
		
		<?php if($amcust_debug_content) echo '<h6>do_action( \'kleo_before_inner_article_loop\' )</h6>'; ?>
		<?php do_action( 'kleo_before_inner_article_loop' ); ?>

		<?php if($amcust_debug_content) echo '<h6>if ( ! $is_single )</h6>'; ?>
		<?php if ( ! $is_single ) : // Only display Excerpts for Search ?>

			<?php if($amcust_debug_content) echo '<h6>kleo_excerpt( 50 )</h6>'; ?>
			<?php echo kleo_excerpt( 50 ); ?>
			
			<?php if($amcust_debug_content) echo '<h6>kleo-continue</h6>'; ?>
			<p class="kleo-continue">
				<a class="btn btn-default"
				   href="<?php the_permalink() ?>">
					<?php esc_html_e( sq_option( 'continue_reading_blog_text', 'Continue reading' ), 'kleo_framework' ); ?>
				</a>
			</p>

			
		<?php else : ?>
			<?php if($amcust_debug_content) echo '<h6>(OLD) the_content</h6>'; ?>
			<?php
				//the_content( esc_html__( 'Continue reading <span class="meta-nav">&rarr;</span>', 'kleo_framework' ) );
			?>
			<?php if($amcust_debug_content) echo '<h6>wp_link_pages</h6>'; ?>
			<?php wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kleo_framework' ),
				'after'  => '</div>',
			) ); ?>
			
			<?php if($amcust_debug_content) echo '<h6>START cust...</h6>'; ?>
			
<?php 
// $meta_print_value=get_post_meta(get_the_ID(),'',true);
// print_r($meta_print_value);
// echo "<h6>amcust_books_author: " + $post_meta_enabled + "</h6>";

function array_push_assoc($array, $key, $value){
	$array[$key] = $value;
	return $array;
}

function filter_gpm($array){
	$mk = array();
	foreach($array as $k => $v){
		if(is_array($v) && count($v) == 1){
		$mk = array_push_assoc($mk, $k, $v[0]);
	} else {
		$mk = array_push_assoc($mk, $k, $v);
		}
	}
	return $mk;
}

$mk = filter_gpm( get_post_meta( get_the_ID() ) );
//print_r($mk);

// check if the post has a Post Thumbnail assigned to it.
// if ( has_post_thumbnail() ) {
// 	the_post_thumbnail();
// } 

$post_type = get_post_type($post_id);
// $page_object = get_page($post->ID );
// echo $page_object->post_content;
// echo '-???';
// echo get_the_content($post->ID);
// echo '-????';
// echo get_post_field('post_content',$post->ID);
// echo '-?????';
// echo the_content();

//echo '<p><strong>Post Type: </strong>' . $post->post_type . '</p>';
//echo '<p><strong>Post ID: </strong>' . get_the_ID() . '</p>';


if ( $post->post_type == 'post' && $post->post_status == 'publish' ) {
	$item_table = '';
	$item_table_arr = array();

	if($mk['amcust_books_shortcode_amazon-code']){
		$item_table_arr[] = array('Buy',do_shortcode(get_post_field('amcust_books_shortcode_amazon-code', $postid)));
	}

	if($mk['amcust_books_author']) {
		$item_table_arr[] = array('Author',$mk['amcust_books_author']);
	}
	if($mk['amcust_books_book_journey']) {
		$item_table_arr[] = array('Book Journey',$mk['amcust_books_book_journey']);
	}
	if($mk['amcust_books_places_visited']) {
		$item_table_arr[] = array('Places Visited',wpautop($mk['amcust_books_places_visited']));
	}
	if($mk['amcust_news_source_url']) {
		$amcust_news_source = $mk['amcust_news_source'] ? $mk['amcust_news_source'] : $mk['amcust_news_source_url'];
		$amcust_news_source_url = $mk['amcust_news_source_url'] ? $mk['amcust_news_source_url'] : '';
		$amcust_news_link = '<a href="'.$amcust_news_source_url.'" title="'.$amcust_news_source.'" class="new-window" target="_blank">' . $amcust_news_source . '</a>';
		$item_table_arr[] = array('Source',$amcust_news_link);
	}
	if($mk['amcust_quotes_author']) {
		$item_table_arr[] = array('By',$mk['amcust_quotes_author']);
	}

	$item_table .= '<table class="table item-spec">';

	if(sizeof($item_table_arr)>0){
		$x = 0;
		while($x<sizeof($item_table_arr)){
			$item_table .= '<tr>';
			$item_table .= '<td><strong>'. $item_table_arr[$x][0] .'</strong></td>';
			$item_table .= '<td>'. $item_table_arr[$x][1] .'</td>';
			$item_table .= '</tr>';
			$x++;
		}		
	}

	$item_table .= '</table>';
	echo $item_table;
	
	

	//	echo do_shortcode(get_post_field('post_content', $postid));//https://stackoverflow.com/questions/22270147/wordpress-shortcode-doesnt-work-when-getting-post-content-using-function-get-p
	if( '' !== get_post()->post_content ) {
		//echo '<h2>My Book Journey</h2>';
		echo do_shortcode(get_post_field('post_content', $postid));
	}

	//171112
	//http://blog.teamtreehouse.com/adding-custom-fields-to-a-custom-post-type-the-right-way
	

	//http://www.wpbeginner.com/wp-themes/how-to-get-all-post-attachments-in-wordpress-except-for-featured-image/
	//https://wordpress.stackexchange.com/questions/142163/how-can-i-return-multiple-image-attachments-with-wp-get-attachment-image-src
	//https://codex.wordpress.org/Template_Tags/get_posts
	//https://developer.wordpress.org/reference/functions/image_downsize/
	$attachments = get_posts( array(
		'post_type' => 'attachment',
		'posts_per_page' => -1,
		'post_parent' => $post->ID,
		'orderby' => 'ID',
		'order' => 'ASC'
	) );
	//            'exclude'     => get_post_thumbnail_id()

	if ( count($attachments) > 1 ) {
		echo '<div class="amcust-wrap-thumbs">';
		echo '<div class="hr-title hr-long"><abbr>More Images</abbr></div>';
		echo '<ul class="ul-thumbnails has-' . count($attachments) . '-thumbs">';
		foreach ( $attachments as $attachment ) {
			
			$class = "";// "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
			$thumbimg = wp_get_attachment_image_src( $attachment->ID, 'full', false );
			if ( $image = image_downsize($attachment->ID, 'thumbnail') ) $thumb = $image;
			$thumb_title = get_the_title($attachment->ID);
			//print_r($thumb);
			echo '<li>';
			echo '<a href="'. $thumbimg[0] .'" title="'. $thumb_title .'" data-title="'. $thumb_title .'" rel="img-lightbox">';
			echo '<img src="'. $thumb[0] .'" alt="'. $thumb_title .'" title="'. $thumb_title .'">';
			echo '<span class="hover-element"><i>+</i></span>';
			echo '</a>';			
			echo '</li>';
		}
		echo '</ul>';
		echo '</div>';
	}

	

	

	if($mk['amcust_books_shortcode_googlemap']){
		echo '<div class="amcust-wrap-thumbs">';
		echo '<div class="hr-title hr-long"><abbr>My Book Journey</abbr></div>';
		echo do_shortcode($mk['amcust_books_shortcode_googlemap']);
		echo '</div>';
	}


}

			?>

		<?php endif; ?>

		<?php if($amcust_debug_content) echo '<h6>do_action( \'kleo_after_inner_article_loop\' )</h6>'; ?>
		<?php do_action( 'kleo_after_inner_article_loop' ); ?>

	</div><!--end article-content-->

</article><!--end article-->
