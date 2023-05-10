<?php view('shared.site.header', [
    'title' => 'About'
]); ?>
<style>
    .banner {
        background-image: url("./public/uploads/<?= $banners[0]['image'] ?>");
    }
</style>
<!-- Start of banner -->
<section class="banner">
    <div class="container-fluid banner-title">
        <div class="row">
            <div class="col-md-12">
                <h2 id="motto">About us</h2>
                <span>Home</span> &nbsp;<span>\\</span> &nbsp;<span>About</span>
            </div>

        </div>
    </div>

    <div class="container-fluid banner-share">
        <div class="row">
            <span>Share this page:</span>
            <div class="banner-social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-google-plus-g"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
        </div>

    </div>

</section>
<!-- End of banner -->


<!-- Start of history -->
<section class="history">
    <div class="container-fluid content-block">

        <ul>
            <li>
                <div class="cupcake-img">
                    <img src="./public/site/img/about/cupcake.png" alt="">
                </div>
            </li>
            <li>
                <div class="intro">
                    <div class="content-title-block">
                        <h2 class="block-title">Bakery is one of the oldest in Wakanda</h2>
                        <p class="block-motto"><span>HISTORY OF THE STORE</span></p>
                    </div>

                    <div class="content">
                        <p>With 25 years of work consectetur adipisicing elit, sed do eius ex veniam nulla optio
                            praesentium
                            deleniti possimus porro aperiam tempora. Quaerat veniam quibusdam ad aliquam facere? Quam
                            adipisci quas error ut </p>
                        <p>Non non ad aliquip duis ullamco. Officia dolor proident excepteur pariatur enim velit
                            adipisicing
                            tempor nulla excepteur quis ad laboris incididunt. Do proident quis laborum non voluptate.
                            Veniam occaecat officia et reprehenderit aliquip occaecat.</p>
                        <p>Cillum amet adipisicing ullamco ullamco nulla esse labore deserunt ullamco nostrud fugiat do
                            cillum. Elit qui officia in officia qui et consequat. In culpa incididunt enim sit magna
                            anim
                            consequat sint. Amet eu reprehenderit non laborum mollit ea adipisicing minim non
                            reprehenderit
                            est in.</p>

                    </div>

                    <div class="signature">
                        <img src="./public/site/img/about/sign.png" alt="">
                        <div>
                            <h6>Stephen Strange</h6> <span> - Store owner</span>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</section>
<!-- End of history -->


<!-- Start of why choose us -->
<section class="why-choose-us p-50">
    <div class="container-fluid section-main">
        <div class="title-block">
            <p class="block-title">Why choose us</p>
            <p class="block-motto"><span>BEST PRODUCTS</span></p>
        </div>

        <div class="container content-block">
            <ul id="why-list">
                <li class="list-item">
                    <ul>
                        <li>
                            <div class="why-block left">
                                <div class="circle">
                                    <img src="./public/site/img/about/healthy.png" alt="">
                                </div>
                                <div class="why-reason">
                                    <h5>Good for health</h5>
                                    <p>Made with care for your health</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="why-block left">
                                <div class="circle">
                                    <img src="./public/site/img/home/whychooseus/organic.png" alt="">
                                </div>
                                <div class="why-reason">
                                    <h5>100% organic</h5>
                                    <p>Available Quality Foods</p>
                                </div>
                            </div>
                        </li>
                    </ul>

                </li>


                <li class="list-item">
                    <img src="./public/site/img/home/images/basket5.png" alt="">
                </li>
                <li class="list-item">
                    <ul>
                        <li>
                            <div class="why-block right">
                                <div class="circle">
                                    <img src="./public/site/img/home/whychooseus/free-delivery.png" alt="">
                                </div>
                                <div class="why-reason">
                                    <h5>Free shipping</h5>
                                    <p>All orders over $100</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="why-block right">
                                <div class="circle">
                                    <img src="./public/site/img/about/quality.png" alt="">
                                </div>
                                <div class="why-reason">
                                    <h5>High-quality products</h5>
                                    <p>Deliver incredible standards</p>
                                </div>
                            </div>
                        </li>
                    </ul>



                </li>
            </ul>
        </div>
    </div>
</section>

<!-- End of why choose us -->

<!-- Start of Meet our chef -->
<section class="meet p-50">
    <div class="container-fluid section-main">
        <div class="title-block">
            <p class="block-title">Meet our chefs</p>
            <p class="block-motto"><span>THE BEST BAKERS</span></p>
        </div>

        <div class="container-fluid" style="margin-top: 40px;">
            <div class="content-block">
                <ul id="chef-list">


                    <li>
                        <div class="chef-block">
                            <div class="chef-img">
                                <img src="./public/site/img/about/chef-1.png" alt="" style=" border-radius: 100%">
                            </div>
                            <div class="chef-info">
                                <h5>Duiga</h5>
                                <p>UwU</p>
                            </div>
                            <div class="chef-social">
                                <a href="https://www.facebook.com/Duiga.Da.Den"><i class="fab fa-facebook-f"></i></a>
                                
                                
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="chef-block">
                            <div class="chef-img">
                                <img src="./public/site/img/about/chef-1.png" alt="" style=" border-radius: 100%">
                            </div>
                            <div class="chef-info">
                                <h5>Duong Dinh</h5>
                                <p>UwU</p>
                            </div>
                            <div class="chef-social">
                                <a href="https://www.facebook.com/DuongDinh1703"><i class="fab fa-facebook-f"></i></a>
                                
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="chef-block">
                            <div class="chef-img">
                                <img src="./public/site/img/about/chef-1.png" alt="" style=" border-radius: 100%">
                            </div>
                            <div class="chef-info">
                                <h5>Tuan Kiet </h5>
                                <p>UwU</p>
                            </div>
                            <div class="chef-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                
                            </div>
                        </div>
                    </li>
                    
                </ul>

            </div>
        </div>
    </div>
</section>
<!-- End of Meet our chef -->


<section class="bottom-banner">
    <img src="./public/site/img/about/logo-banner.png" alt="">
</section>

<?php view('shared.site.footer'); ?>