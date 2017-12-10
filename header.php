<!DOCTYPE html>
<html>
<head>
	<title><?php echo get_bloginfo( 'name' ); ?></title>
	  <meta name="viewport" content="width=device-width, initial-scale=1">
 	<?php wp_head();?>
 	<script type="text/javascript">
      function onsearchmobile(e){      
          var keyword =document.querySelector('[name="keywords"]').value;;       
         window.location = "<?php echo get_site_url()?>/?s="+keyword+"&post_type=product";
       }
    </script>
    <script type="text/javascript">
      function onsearchs(e){      
        var keyword =document.querySelector('[name="keyword"]').value;;
        var category_search = '' ;
        if(category_search != ''){
           window.location = "<?php echo get_site_url()?>/product-category/"+category_search+"/?s="+keyword+"&post_type=product";
         }else{
             window.location = "<?php echo get_site_url()?>/?s="+keyword+"&post_type=product";
         }
       
      }
    </script>
</head>
<body>
	<header class="sticky main-header hidden-sm hidden-xs">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-2">
					<a href="<?php echo get_bloginfo('url');?>"><img class="logo img-responsive" src="<?php echo get_template_directory_uri();?>/images/logo.png"></a>
				</div>
				<div class="col-md-7">
					<ul class="navigation">
						<li>
							<a href="<?php echo get_site_url();?>"><span><img src="<?php echo get_template_directory_uri();?>/images/home.png"></span>Home</a>
						</li>
						<?php $args ="";?>
						 <?php  $product_categories = get_terms( 'product_cat' ,$args);?>
							
                 			<?php if(isset($product_categories) && count($product_categories)>0){ ?>
                 				 <?php foreach ($product_categories as $obj) { ?>  
		                        <?php
		                           $thumbnail_id = get_woocommerce_term_meta( $obj->term_id, 'thumbnail_id', true ); 
		                           $image = wp_get_attachment_url( $thumbnail_id ); 
		                        ?>
								<li>
									<a href="<?php echo get_site_url().'/?product_cat='.$obj->slug;?>">
										 <?php if(isset($image) && $image != ''){ ?>
		                                    <span><img src="<?php echo $image;?>"></span>
		                                <?php } ?>
										  <?php echo isset($obj->name)?$obj->name:'';?>
									</a>
								</li>
								<?php } ?>
						  <?php } ?>
					</ul>
				</div>
				 <?php global $woocommerce; ?>
				<div class="col-md-3 nopadding-left">
					<a class="my_cart pull-right" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><span class="logo-cart"><img src="<?php echo get_template_directory_uri();?>/images/cart.png"></span><span class="label-cart">My Cart &nbsp;<?php echo $woocommerce->cart->cart_contents_count;?> item - <?php echo $woocommerce->cart->get_cart_total(); ?></span></a> 
					<form  onsubmit=" event.preventDefault();  onsearchs();">
					<input class="form-control" id="search-desktop" name="keyword" type="text">
				</form>
				</div>
			</div>
		</div>
	</header>
	<header class="sticky main-header visible-sm visible-xs">
			<nav class="navbar nav-mobile navbar-inverse visible-xs visible-sm">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <div class="col-xs-3">
					<a href="<?php echo get_bloginfo('url');?>"><img class="logo-mobile img-responsive" src="<?php echo get_template_directory_uri();?>/images/logo.png"></a>
				</div>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    	  <form id="searchform" name="searchform" onsubmit=" event.preventDefault();  onsearchmobile();">
         
             <input type="search" class="form-control" id="keyword" name="keywords" placeholder="Enter Keywords Here..">
          
      </form>
      <ul class="nav navbar-nav">
        <li class="active"><a href="<?php echo get_site_url();?>">Home</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Product Category<span class="caret"></span></a>
          <ul class="dropdown-menu">
          	<?php if(isset($product_categories) && count($product_categories)>0){ ?>
          		<?php foreach ($product_categories as $obj) { ?>  
            		<li><a href="<?php echo get_site_url().'/?product_cat='.$obj->slug;?>"> <?php echo isset($obj->name)?$obj->name:'';?></a></li>
            	<?php } ?>
            <?php } ?>
          </ul>
        </li>
       
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><span class="fa fa-shopping-cart"></span>&nbsp; My Cart &nbsp;<?php echo $woocommerce->cart->cart_contents_count;?> item - <?php echo $woocommerce->cart->get_cart_total(); ?></a></li>
        <li><a href="<?php echo get_site_url();?>/checkout"><span class="fa fa-credit-card-alt"></span>&nbsp; Checkout</a></li>
      </ul>
    </div>
  </div>
</nav>

	</header>