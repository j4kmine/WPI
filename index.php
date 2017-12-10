<?php get_header(); ?>
	<ul class="rslides">
		<?php 
          $temp = $wp_query;
          $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
          $post_per_page = 100; // -1 shows all posts
          $args=array(
            'post_type' => 'slideshow',
            'orderby' => 'date',
            'order' => 'ASC',
           
            'posts_per_page' => $post_per_page
          );
            $wp_query = new WP_Query($args); 
           
            if( have_posts() ) : while ($wp_query->have_posts()) : $wp_query->the_post();
            $custom = get_post_custom($post->ID);
            $url = $custom["url"][0]; 
            $url_open = $custom["url_open"][0];
            $custom_title = "#".$post->ID;
            $post_title = $post->post_title;
            $excerpt = $post->post_excerpt;
            $post_thumbnail_id = get_post_thumbnail_id($post->ID);
            $post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
       
         ?>
		<li>
			<a href="<?php echo isset($url)?$url:'';?>"><img src="<?php echo isset($post_thumbnail_url)?$post_thumbnail_url:'';?>"></a>
		</li>
		
		<?php endwhile; else: ?>
       <?php endif; wp_reset_query(); $wp_query = $temp ?>
	</ul>
	 <?php $args ="";?>
    <?php $hitung =1;?>
   <?php  $product_categories = get_terms( 'product_cat', $args );?>
     <?php if(isset($product_categories) && count($product_categories)>0){ ?>
                <?php foreach ($product_categories as $obj) { ?> 
                <?php if($hitung <= 3){ ?>
                <div class="category-title">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-8 col-sm-12 col-xs-12">
								<h3><a href="<?php echo get_site_url().'/?product_cat='.$obj->slug;?>"><?php echo isset($obj->name)?$obj->name:'';?></a></h3>
								<hr>
							</div>
						</div>
					</div>
				</div>

              <div class="product-sec">
              	<div class="container-fluid">
              		<div class="row">
              <?php 
                  $args = array( 'post_type' => 'product' ,'product_cat' => $obj->slug,'orderby' =>'date','order' => 'DESC', 'post_status'=> 'publish','posts_per_page'=>4);
                  $loop = new WP_Query( $args );
                  $count = 1;

              ?>

              <?php while ( $loop->have_posts() ) : $loop->the_post(); global $product;  ?>
                       <div class="col-sm-6 col-md-3 col-xs-12">
                       		<div class="product-card">
		                        <?php $post_thumbnail_id = get_post_thumbnail_id( $post->ID ); ?>
		                        <?php $full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id ,'single-post-thumbnail'); ?>
		                        <a href="<?php echo get_site_url();?>/product/<?php echo $loop->post->post_name;?>">
		                           <?php if(isset($full_size_image[0]) && count($full_size_image[0])>0){ ?>
		                                  <img src="<?php echo $full_size_image[0];?>" class="img-responsive">
		                          <?php }else{ ?>
		                                  <img src="<?php echo get_site_url();?>/wp-content/plugins/woocommerce/assets/images/placeholder.png" class="img-responsive">
		                          <?php } ?>
		                        </a>
		                        <div class="upper-product">
									<h4 class="text-center"><a href="<?php echo get_site_url();?>/product/<?php echo $loop->post->post_name;?>"><?php echo $loop->post->post_title;?></a></h4>
									<hr>
									<p><?php echo substr($loop->post->post_excerpt,0,150);?></p>
									
									<a href="javascript:void(0)" onclick="addtocart(<?php echo get_the_ID();?>)" class="btn btn-add-cart"><i aria-hidden="true" class="fa fa-shopping-cart"></i>&nbsp; Add to cart</a>
								</div>
		                      
		                    </div>
                      </div>
                    <?php $count++;?>
                    <?php endwhile; wp_reset_query();
                      // Remember to reset ?>
	                      </div>
	                    </div>
	                   </div>
                       <?php $hitung++;?>
            <?php } ?>
            <?php } ?>
           
          <?php } ?>
	
	<?php get_footer(); ?>