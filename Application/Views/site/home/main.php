<main>
    <!-- Start of main banner -->
    <section class="banner container-fluid p-0">
        <div class="banner-frame row m-0 p-0">
            <div class="bannercontainer">
                <img src="./public/uploads/<?= $banners[0]['image'] ?>" alt="" class="col-md-12 m-0 p-0 bread-img">
                <!-- <div class="overlay"></div>
                <div class="bannertitle">
                    <img src="./public/site/img/home/wheat1.png" alt="" class="wheat-img">
                    <p id="motto">FRESHLY BAKED BREAD</p>
                    <h6>MADE WITH THE LOVE OF THE BEST BAKERS</h6>
                </div> -->
            </div>
        </div>
    </section>

    <section class="quickshopping">
        <div class="container-fluid section-main">
            <div class="content-title-block">
                <p class="block-title">High-quality products</p>
                <p class="block-motto"><span>BUY NOW</span></p>
            </div>

            <div class="container" style="margin-top: 40px;">
                <div class="content-block">
                    <ul id='quick-shop-list'>
                        <li>

                            <div class="bread-desc">
                                <h3>Bakery</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do.
                                </p>
                                <a href="./?controller=product&action=allProducts"><button><span>SHOP NOW</span><img src="./public/site/img/home/logo/right.png" alt=""></button></a>
                                <div class="basket">
                                    <img src="./public/site/img/home/images/basket6.png" alt="">
                                </div>
                            </div>

                        </li>

                        <li>

                            <div class="bread-desc">
                                <h3>Bread</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do.</p>
                                <a href="./?controller=product&action=allProducts"><button><span>SHOP NOW</span><img src="./public/site/img/home/logo/right.png" alt=""></button></a>
                                <div class="basket">
                                    <img src="./public/site/img/home/images/basket7.png" alt="">
                                </div>
                            </div>

                        </li>

                        <li>

                            <div class="bread-desc">
                                <h3>Muffins</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do.</p>
                                <a href="./?controller=product&action=allProducts"><button><span>SHOP NOW</span><img src="./public/site/img/home/logo/right.png" alt=""></button></a>
                                <div class="basket">
                                    <img src="./public/site/img/home/images/basket1.png" alt="">
                                </div>
                            </div>
                            <!-- <div class="trapezoid">
                                    <div class="basket">
                                        <img src="./public/site/img/home/images/basket1.png" alt="">
                                    </div>
                                </div> -->

                        </li>
                    </ul>
                </div>


            </div>
        </div>


    </section>
    <!-- Start of why choose us -->
    <section class="why-choose-us p-50">
        <div class="container-fluid section-main">
            <div class="title-block">
                <p class="block-title">Why choose us</p>
                <p class="block-motto"><span>GREAT QUALITY</span></p>
            </div>

            <div class="container content-block">
                <ul id="why-list">
                    <li>
                        <div class="why-block">
                            <div class="circle">
                                <img src="./public/site/img/home/whychooseus/payment.png" alt="">
                            </div>
                            <div class="why-reason">
                                <h5>Secure payment</h5>
                                <p>Payment with security</p>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="why-block">
                            <div class="circle">
                                <img src="./public/site/img/home/whychooseus/organic.png" alt="">
                            </div>
                            <div class="why-reason">
                                <h5>100% organic</h5>
                                <p>Available Quality Foods</p>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="why-block">
                            <div class="circle">
                                <img src="./public/site/img/home/whychooseus/24-hours-support.png" alt="">
                            </div>
                            <div class="why-reason">
                                <h5>Customer support</h5>
                                <p>Very helpful support 24/7</p>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="why-block">
                            <div class="circle">
                                <img src="./public/site/img/home/whychooseus/free-delivery.png" alt="">
                            </div>
                            <div class="why-reason">
                                <h5>Free shipping</h5>
                                <p>All orders over $100</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- End of why choose us -->

    <!-- Start of promotion -->
    <section class="promotion">
        <div class="promotion-block container-fluid content-block">
            <ul>
                <li class="offer-image">
                    <div class="imgcontainer">
                        <img src="./public/uploads/<?= $offer_pro['image'] ?>" alt="">
                    </div>
                </li>
                <li class="offer-info">
                    <div>
                        <p class="block-title">This week offer</p>
                        <p class="offer-deal">
                            GET <span style="font-weight: bold"><?= $offer_pro['percent'] ?></span>% OFF THIS PRODUCT
                            NOW
                        </p>

                        <h3><?= $offer_pro['name'] ?></h3>
                        <h5 class="offer-price"><span class="strikeout">$<?= number_format($offer_pro['price'], 2, '.', '') ?></span> Now only
                            $<?= number_format($offer_pro['sale_price'], 2, '.', '') ?></h5>

                        <p class="p-lorem">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. </p>

                        <!-- <div class="countdown" data-date="2021-12-28" data-time="12:00"></div> -->

                        <a class="offer-btn btn-root ptc-btn border-root" style="margin-top: 15px; position: absolute" href="./?controller=product&action=productDetail&id=<?= $offer_pro['id'] ?>">
                            BUY NOW
                        </a>

                    </div>





                </li>

            </ul>

        </div>
    </section>
    <!-- End of promotion -->

    <!-- Start of latest products -->
    <section class="latest-products p-50">
        <div class="container-fluid section-main">
            <div class="content-title-block">
                <p class="block-title">Our latest bakery products</p>
                <p class="block-motto"><span>OUR BEST CAKES</span></p>
            </div>

            <div class="container">

                <ul class="pro-category">
                    <?php foreach ($categories as $cat) : ?>
                        <li><a href="./?controller=product&action=allProducts&id=<?= $cat['id'] ?>">
                                <h5><?= $cat['name'] ?></h5>
                            </a></li>

                        <p>/</p>
                    <?php endforeach; ?>

                </ul>

                <div class="content-block">
                    <ul id='pro-list'>
                        <?php foreach ($latest_products8 as $product) : ?>
                            <li>
                                <a href="./?controller=product&action=productDetail&id=<?= $product['id'] ?>">
                                    <div class="pro-block">
                                        <div class="pro-img">
                                            <?php
                                            $productImage = !empty($product['image']) ? $product['image'] : 'no-image.png';
                                            ?>
                                            <img src="./public/uploads/<?= $productImage; ?>" alt="<?= $product['name']; ?>">
                                        </div>
                                        <div class="pro-info">
                                            <h5><?= $product['name'] ?? '' ?></h5>
                                            <h5>$<?= number_format($product['sale_price'] > 0 ? $product['sale_price'] : $product['price'], 2, '.', '') ?>
                                            </h5>
                                        </div>
                                    </div>
                                </a>

                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>


            </div>
        </div>
    </section>
    <!-- End of latest products -->


    <section class="cookie-banner">

        <img src="./public/uploads/<?= $banners[1]['image'] ?>" alt="">

    </section>

    <!-- Start of product for you -->
    <section class="product-for-you p-50">
        <div class="container-fluid section-main">
            <div class="content-title-block">
                <p class="block-title">Product for you</p>
                <p class="block-motto"><span>NEW PRODUCT</span></p>
            </div>

            <div class="container" style="margin-top: 40px;">

                <div class="content-block">
                    <div id="add-product-to-cart-ajax" style="margin: 0 auto 20px auto; width: 90%"></div>
                    <ul id='new-pro-list'>
                        <!-- <input type="text" id="success-message"> -->
                        <?php foreach ($latest_products4 as $product) : ?>
                            <li>

                                <div class="new-pro-block">
                                    <div class="new-pro-img">
                                        <?php
                                        $productImage = !empty($product['image']) ? $product['image'] : 'no-image.png';
                                        ?>
                                        <img src="./public/uploads/<?= $productImage; ?>" alt="<?= $product['name']; ?>">
                                    </div>
                                    <div class="new-pro-info">
                                        <h5> <?= $product['name'] ?? '' ?> </h5>
                                        <p><?= $product['description'] ?> </p>
                                        <h5>$<?= number_format($product['sale_price'] > 0 ? $product['sale_price'] : $product['price'], 2, '.', '') ?>
                                        </h5>
                                    </div>
                                    <a id="add-to-cart-btn<?= $product['id'] ?>" class="swalDefaultSuccess " onclick="onAddToCartAjax(<?= $product['id'] ?>)">
                                        <button><i class="fas fa-shopping-basket" style="font-size:13px"></i><span> ADD TO
                                                CART</span></button>
                                    </a>

                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>


            </div>
        </div>
    </section>
    <!-- End of profuct for you -->

    <!-- Start of testimonial -->
    <section class="testimonial">
        <div class="container-fluid section-main">
            <div class="content-title-block">
                <p class="block-title">What our customers saying?</p>
                <p class="block-motto"><span>TESTIMONIALS</span></p>
            </div>
            <div class="container">
                <div class="carousel-inner" id="testimonial-list" role="listbox">
                    <div class="mySlides fade testimonial-item">
                        <div class="testimonial-block">

                            <div class="customer-info">
                                <img src="./public/site/img/home/customer/testimonial.png">
                                <p> Do ullamco dolor occaecat do pariatur enim mollit ad dolor nisi eu dolor. Culpa do
                                    ut aliqua enim culpa excepteur elit consequat occaecat commodo ullamco consectetur.
                                    <br>
                                </p>
                                <span id="star-icon"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                                <h5> Dan Gheesling </h5>
                                <span id="job"> Food blogger </span>
                            </div>
                            <div class="customer-img">
                                <img src=" ./public/site/img/home/customer/comment_1.png ">
                            </div>
                        </div>
                    </div>

                    <div class="mySlides fade testimonial-item">
                        <div class="testimonial-block">

                            <div class="customer-info">
                                <img src="./public/site/img/home/customer/testimonial.png">
                                <p> Do ullamco dolor occaecat do pariatur enim mollit ad dolor nisi eu dolor. Culpa do
                                    ut aliqua enim culpa excepteur elit consequat occaecat commodo ullamco consectetur.
                                    <br>
                                </p>
                                <span id="star-icon"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                                <h5> Ian Terry </h5>
                                <span id="job"> Pastry chef </span>
                            </div>
                            <div class="customer-img">
                                <img src=" ./public/site/img/home/customer/comment_2.png ">
                            </div>
                        </div>
                    </div>

                    <div class="mySlides fade testimonial-item">
                        <div class="testimonial-block">

                            <div class="customer-info">
                                <img src="./public/site/img/home/customer/testimonial.png">
                                <p> Do ullamco dolor occaecat do pariatur enim mollit ad dolor nisi eu dolor. Culpa do
                                    ut aliqua enim culpa excepteur elit consequat occaecat commodo ullamco consectetur.
                                    <br>
                                </p>
                                <span id="star-icon"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                                <h5> Kaysar Ridha </h5>
                                <span id="job"> Model </span>
                            </div>
                            <div class="customer-img">
                                <img src=" ./public/site/img/home/customer/comment_3.png ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div style="text-align:center">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>

        </div>
    </section>
    <!-- End of testimonial -->

    <section class="bottom-banner">
        <img src="./public/site/img/about/logo-banner.png" alt="">
    </section>
</main>