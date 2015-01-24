<div class="item">
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <div class="title-details">
        <a href="<?php the_permalink(); ?>" class="time"><?php the_date(); ?></a>
        <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('0', '1', '%'); ?></a>
    </div>
    <p>
        <?php echo strip_tags(get_the_excerpt()) . ' '; ?>
        <a href="<?php the_permalink(); ?>" class="more-link">Read more <b>+</b></a>
    </p>
</div>