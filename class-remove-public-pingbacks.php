<?php
/**
 * Remove Public Pingbacks.
 *
 * @package   Remove_Public_Pingbacks
 * @author    Tom McFarlin <tom@tommcfarlin.com>
 * @license   GPL-2.0+
 * @link      http://tommcfarlin.com/remove-public-pingbacks/
 * @copyright 2014 Tom McFarlin
 */

/**
 * Remove Public Pingbacks.
 *
 * This class will remove the count and listing of public-facing pingbacks from
 * your WordPress blog; however, if your blog or website renders a heading element
 * for the 'Trackbacks' and/or 'Pings' heading, then you can use the bundled
 * CSS to hide them.
 *
 * @package   Remove_Public_Pingbacks
 * @author    Tom McFarlin <tom@tommcfarlin.com>
 */
class Remove_Public_Pingbacks {

	/**
	 * A hyphenated version of the name of this plugin.
	 *
	 * @since    1.0.0
	 * @type     string
	 */
	private $plugin_slug;

	/**
	 * The semantic version of this plugin.
	 *
	 * @since    1.0.0
	 * @type     string
	 */
	private $version;

	/**
	 * A reference to an instance of this class.
	 *
	 * @since    1.0.0
	 * @type     object
	 */
	private static $instance = NULL;

	/**
	 * If an instance of this class hasn't already been created, then
	 * this will create an instance of the plugin and return it to the caller.
	 *
	 * @since    1.0.0
	 * @return   object    A reference to an instance of this class.
	 */
	public static function run() {

		if ( NULL === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

	/**
	 * Initializes the plugin's properties and defines the hookes to run the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function __construct() {

		$this->plugin_slug = 'remove-public-pingbacks';
		$this->version = '1.0.0';

		$this->setup_hooks();

	}

	/**
	 * Enqueues the stylesheet that will be used to hide the trackback
	 * and ping headings from the blog.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_script(
			$this->get_plugin_slug(),
			plugins_url( 'public/css/public.css', __FILE__ ),
			array(),
			$this->get_version()
		);

	}

	/**
	 * Removes all of the pingbacks from the comment feed of the current post.
	 *
	 * @since    1.0.0
	 * @param    array    $comments    The array of comments for the given post.
	 * @param    int      $post_id     The ID of the given post.
	 * @return   array                 An array that includes *only* the $comments of the post.
	 */
	function remove_pingbacks( $comments , $post_id ) {

		$comments_only = array();
		for ( $i = 0; $i < count( $comments ); $i++ ) {

			$comment = $comments[ $i ];
			if ( 0 === strlen( trim( $comment->comment_type ) ) ) {
				$comments_only[] = $comment;
			}

		}

		return $comments_only;

	}

	/**
	 * Counts the number of comments (less trackpbacks and pings that exist for a given post).
	 *
	 * @since    1.0.0
	 * @return   int    The number of comments that exist on a post.
	 */
	function comment_count() {

		$comments = get_approved_comments( get_the_ID() );

		$comment_count = 0;
		foreach ( $comments as $comment ) {

			if( 0 === strlen( trim( $comment->comment_type ) ) ) {
				$comment_count++;
			}

		}

		return $comment_count;

	}

	/**
	 * Registers the filters and actions for removing the pingbacks and the
	 * pingback count from the comment feed of a given post. Registers the
	 * stylesheet for hiding parts of the blog as well.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function setup_hooks() {

		add_filter( 'comments_array' , array( $this, 'remove_pingbacks' ), 10, 2 );
		add_filter( 'get_comments_number', array( $this, 'comment_count' ), 0 );

		add_action( 'wp_enqueue_script', array( $this, 'enqueue_styles' ) );

	}

	/**
	 * @since    1.0.0
	 * @access   private
	 * @return   string    The hyphenated slug of the plugin.
	 */
	private function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * @since    1.0.0
	 * @access   private
	 * @return   string    The semantic version number of the plugin.
	 */
	private function get_version() {
		return $this->version;
	}

}
