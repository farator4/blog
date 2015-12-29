<?php get_header(); ?>    
    
     
            
<div class="container">
<div class="row-fluid">
<div class="span8">
      
<?php get_template_part('loop'); ?>

</div>
<div class="span4">

<?php dynamic_sidebar('Archive Page'); ?>
</div>
</div>
</div>
      
<?php get_footer(); ?>
