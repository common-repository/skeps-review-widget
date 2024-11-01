<?php

/**
 * Provide a view for the reviews carousel
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.skeps.nl/wordpress
 * @since      1.0.0
 *
 * @package    Skeps_GoogleReviews
 * @subpackage Skeps_GoogleReviews/public/partials
 */
?>

<?php

$slides_mobile = $atts['slides_mobile'] ? $atts['slides_mobile'] : 1;
$slides_desktop = $atts['slides_desktop'] ? $atts['slides_desktop'] : 3;

?>

<div id="sgr-carousel-<?= $id ?>" class="sgr-carousel owl-carousel owl-theme" data-slides-mobile="<?= $slides_mobile; ?>" data-slides-desktop="<?= $slides_desktop; ?>">

<?php

    foreach($reviews as $key => $item):  ?>

    <div class="item">

        <div class="review">
            
            <header>
                    
                    <div class="reviewer">
                        
                        <div class="reviewer__photo">
                            <img src="<?= $item['reviewer_photo']; ?>">
                        </div>
                        
                        <div class="reviewer__user">
                            <span class="reviewer__name"><?= $item['reviewer_name']; ?></span>
                            <span class="reviewer__postdate"><?= $item['review_date']; ?></span>
                        </div>
                  
                    </div>

            </header>

            <div class="review__body">
                
                <span class="review__description">
                    <?= $item['review_comment']; ?>
                </span>

                <span class="review__rating">
                    <svg class="icon">
                        <use xlink:href="#stars-<?= $item['review_rating']; ?>-0-star">
                    </svg>
                </span>

            </div>

        </div>

    </div>

    <?php endforeach; ?>

</div>


<svg id="sgr-icons" style="display: none;" version="1.1">

    <symbol id="prev-icon" viewBox="0 0 256 512">
        <path fill="currentColor" d="M231.293 473.899l19.799-19.799c4.686-4.686 4.686-12.284 0-16.971L70.393 256 251.092 74.87c4.686-4.686 4.686-12.284 0-16.971L231.293 38.1c-4.686-4.686-12.284-4.686-16.971 0L4.908 247.515c-4.686 4.686-4.686 12.284 0 16.971L214.322 473.9c4.687 4.686 12.285 4.686 16.971-.001z"></path>
    </symbol>

    <symbol id="next-icon" viewBox="0 0 256 512">
        <path fill="currentColor" d="M24.707 38.101L4.908 57.899c-4.686 4.686-4.686 12.284 0 16.971L185.607 256 4.908 437.13c-4.686 4.686-4.686 12.284 0 16.971L24.707 473.9c4.686 4.686 12.284 4.686 16.971 0l209.414-209.414c4.686-4.686 4.686-12.284 0-16.971L41.678 38.101c-4.687-4.687-12.285-4.687-16.971 0z"></path>
    </symbol>

	<symbol id="stars-full-star" viewBox="0 0 102 18">
		<path d="M9.5 14.25l-5.584 2.936 1.066-6.218L.465 6.564l6.243-.907L9.5 0l2.792 5.657 6.243.907-4.517 4.404 1.066 6.218" />
	</symbol>

	<symbol id="stars-all-star" viewBox="0 0 102 18">
		<use xlink:href="#stars-full-star" />
		<use xlink:href="#stars-full-star" transform="translate(20)" />
		<use xlink:href="#stars-full-star" transform="translate(40)" />
		<use xlink:href="#stars-full-star" transform="translate(60)" />
		<use xlink:href="#stars-full-star" transform="translate(80)" />
	</symbol>

	<symbol id="stars-0-0-star" viewBox="0 0 102 18">
		<use xlink:href="#stars-all-star" fill="#9b9b9b" />
	</symbol>

	<symbol id="stars-1-0-star" viewBox="0 0 102 18">
		<use xlink:href="#stars-0-0-star" />
		<use xlink:href="#stars-full-star" fill="#e9ba26" />
	</symbol>

	<symbol id="stars-2-0-star" viewBox="0 0 102 18">
		<use xlink:href="#stars-1-0-star" />
		<use xlink:href="#stars-full-star" fill="#e9ba26" transform="translate(20)" />
	</symbol>

	<symbol id="stars-3-0-star" viewBox="0 0 102 18">
		<use xlink:href="#stars-2-0-star" />
		<use xlink:href="#stars-full-star" fill="#e9ba26" transform="translate(40)" />
	</symbol>

	<symbol id="stars-4-0-star" viewBox="0 0 102 18">
		<use xlink:href="#stars-3-0-star" />
		<use xlink:href="#stars-full-star" fill="#e9ba26" transform="translate(60)" />
	</symbol>

	<symbol id="stars-5-0-star" viewBox="0 0 102 18">
		<use xlink:href="#stars-all-star" fill="#e9ba26" />
    </symbol>
    
</svg>