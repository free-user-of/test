<?php
$args = array( 'post_type' => 'slider', 'orderby' => 'date' );
$slider = new WP_Query( $args );
if(!empty($slider->posts) && plsh_gs('use_slider') == 'on')
{
?>
    <!-- BEGIN .main-slider -->
    <section class="main-slider">

        <div class="paging">
            <a href="#" class="previous"></a>
            <a href="#" class="next"></a>
        </div>

        <nav>
            <span id="pager">
            <?php
            if(count($slider->posts) > 1)
            {
                for($i = 1; $i <= count($slider->posts); $i++)
                {
                    echo '<a href="#">' . $i . '</a>';
                }
            }
            ?>
            </span>
        </nav>

        <div id="hompage-slider_content">
        
            <?php while ( $slider->have_posts() ) : $slider->the_post(); ?>
                <?php 
                    $meta = get_post_meta(get_the_ID()); 
                    $title = get_the_title();
                    $excerpt = strip_tags(get_the_excerpt());
                ?>
                <!-- BEGIN .item -->
                <div class="item" style="background-image: url(<?php echo plsh_get_thumbnail('slider_image', true); ?>);">
                    <div class="title-wrapper clearfix">
                        <div class="title">
                            <?php if($title) { ?><p class="clearfix"><a href="<?php echo $meta['slider_url_meta'][0]; ?>" class="headline"><?php echo $title; ?></a></p><?php } ?>
                            <?php if($excerpt) { ?><p class="clearfix"><a href="<?php echo $meta['slider_url_meta'][0]; ?>" class="intro"><?php echo $excerpt; ?></a></p><?php } ?>
                        </div>
                    </div>
                    <img src="<?php echo PLSH_IMG_URL; ?>blank.png" alt="" />
                <!-- END .item -->
                </div>

            <?php endwhile; ?>

        </div>

    <!-- END .main-slider -->
    </section>
<?php } ?>