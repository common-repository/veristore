<?php

/**
 * Veristore-Widget public
 *
 * @link       http://www.veristore.de/
 * @since      1.0.0
 *
 * @package    Veristore
 * @subpackage veristore/widget/partials
 */

echo !empty( $instance['title'] ) ? $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'] : '';

$vs_app_data = get_transient( 'vs_app_data' );

$image = 'https://www.veristore.de/app/s/' . $vs_app_data->token . '/logo.png';
?>
<p>
<a href="https://www.veristore.de/app/shop/<?php echo $vs_app_data->token; ?>" target="_blank">Kundenbewertungen für <?php echo $vs_app_data->url; ?></a><br />
<?php echo $vs_app_data->ratings; ?> <?php _e( 'Bewertungen:', 'veristore' ); ?> 
<?php echo $vs_app_data->score; ?> <?php _e( 'of' ); ?> 
5,0 <?php _e( 'Sternen', 'veristore' ); ?>
</p>

<script type="application/ld+json">
{
"@context": "http://schema.org",
"@type": "LocalBusiness",
"url": "<?php echo $vs_app_data->url; ?>",
"name": "<?php echo $vs_app_data->name; ?>",
"image": "<?php echo $image; ?>",
"aggregateRating": {
  "@type": "AggregateRating",
  "ratingValue": "<?php echo $vs_app_data->score; ?>",
  "bestRating": "5,0",
  "reviewCount": "<?php echo $vs_app_data->ratings; ?>"
  }
}
</script>
