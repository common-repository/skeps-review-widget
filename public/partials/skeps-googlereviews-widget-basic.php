<?php

/**
 * Provide a view for the reviews bagdge
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

<div id="<?= $widget_id ?>" class="sgr-widget type-basic">

<?php if($link): ?>
    <a href="<?= $link; ?>" target="_blank">
<?php endif; ?>

        <div class="widget-container theme-<?= $theme ?> <?php if($link){ echo "linked"; } ?> bg-<?= $background; ?>">

                <div class="row">

                    <?php if($logo): ?>

                        <div class="col col-logo">

                            <svg width="28" height="28" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.5337 10.1871C19.5337 9.36767 19.4672 8.76973 19.3233 8.14966H9.96667V11.848H15.4588C15.3481 12.767 14.7502 14.1512 13.4214 15.0812L13.4028 15.205L16.3612 17.4969L16.5661 17.5173C18.4485 15.7789 19.5337 13.221 19.5337 10.1871Z" fill="#4285F4"/>
                                <path d="M9.96667 19.9313C12.6573 19.9313 14.9162 19.0454 16.5661 17.5174L13.4214 15.0813C12.5799 15.6682 11.4504 16.0779 9.96667 16.0779C7.33133 16.0779 5.09462 14.3394 4.2973 11.9366L4.18043 11.9465L1.10425 14.3272L1.06403 14.4391C2.7028 17.6945 6.06897 19.9313 9.96667 19.9313Z" fill="#34A853"/>
                                <path d="M4.2973 11.9366C4.08692 11.3165 3.96516 10.6521 3.96516 9.96559C3.96516 9.27902 4.08692 8.61467 4.28623 7.9946L4.28066 7.86254L1.16592 5.4436L1.06401 5.49208C0.388595 6.84299 0.0010376 8.36002 0.0010376 9.96559C0.0010376 11.5712 0.388595 13.0881 1.06401 14.439L4.2973 11.9366Z" fill="#FBBC05"/>
                                <path d="M9.96673 3.85336C11.838 3.85336 13.1003 4.66168 13.8201 5.33718L16.6326 2.59107C14.9053 0.985496 12.6574 0 9.96673 0C6.069 0 2.70281 2.23672 1.06403 5.49214L4.28625 7.99466C5.09465 5.59183 7.33137 3.85336 9.96673 3.85336Z" fill="#EB4335"/>
                            </svg>

                        </div>

                    <?php endif; ?>

                    <div class="col col-score">

                        <span class="score_average"><?= $location_info['reviews_summary']['average_rating']; ?></span>
                        <span class="separator">/</span>
                        <span class="score_max">5</span>
                        <span class="text_from"><?php _e('out of', 'skeps-googlereviews'); ?></span>
                        <span class="score_total"><?= $location_info['reviews_summary']['total_reviews']; ?></span>
                        <span class="text_reviews"><?php _e('reviews on Google', 'skeps-googlereviews'); ?></span>

                    </div>

                    <?php if($stars): ?>

                        <div class="col col-stars">

                            <svg class="icon" width="140px" height="50px">
                                    <use xlink:href="#stars-<?= $score_formatted ?>-star">
                            </svg>

                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

<?php if($link): ?>
    </a>
<?php endif; ?>
