<?php
    $meta = get_post_meta(get_the_ID());
?>
<a href="<?php echo $meta['banner_url_meta'][0]; ?>" target="_blank" class="<?php echo $meta['banner_background_meta'][0]; ?>">
    <span class="title"><?php the_title(); ?></span>
    <span class="description"><?php echo strip_tags(get_the_excerpt('')); ?></span>
    
    <?php if($meta['banner_background_meta'][0] != 'image') { ?>
        <span class="background"></span>
    <?php } else { ?>
        <span class="background" style="background-image: url('<?php echo plsh_get_thumbnail('banner_image', true); ?>');"></span>
    <?php } ?>
</a>