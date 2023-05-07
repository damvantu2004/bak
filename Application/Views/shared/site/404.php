<!doctype html>
<html lang="en">

<head>


    <title>Bakya | Page Not Found</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="./public/site/img/bakery-icon.png">
    <link rel="stylesheet" href="./public/admin/dist/css/responsive.css">
    <link rel="stylesheet" href="./public/admin/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="./public/site/css/signup.component.css">
    <link rel="stylesheet" href="./public/site/css/login.component.css">
    <link rel="stylesheet" href="./public/site/css/about.component.css">
    <link rel="stylesheet" href="./public/site/css/blog.component.css">
    <link rel="stylesheet" href="./public/site/css/blog-detail.component.css">
    <link rel="stylesheet" href="./public/site/css/cart.component.css">
    <link rel="stylesheet" href="./public/site/css/checkout.component.css">
    <link rel="stylesheet" href="./public/site/css/contact.component.css">
    <link rel="stylesheet" href="./public/site/css/error.component.css">
    <link rel="stylesheet" href="./public/site/css/product.component.css">
    <link rel="stylesheet" href="./public/site/css/product-detail.component.css">
    <link rel="stylesheet" href="./public/site/css/footer.component.css">
    <link rel="stylesheet" href="./public/site/css/header.component.css">
    <link rel="stylesheet" href="./public/site/css/sidebar-blog.component.css">
    <link rel="stylesheet" href="./public/site/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="./public/site/css/search.css">
    <link rel="stylesheet" href="./public/site/css/styles.css">

</head>

<body>

    <header class="header">
        <div class="top-bar">
            <div class="container-fluid p-0" style="background-color: white;">
                <div class="row contact-block m-0">

                    <ul class="contact-span m-0 hidden-xs hidden-sm">
                        <li><i class="fas fa-map-marker-alt"></i><span>0010 Avenue of the Moon, New York, NY 10018
                                US</span>
                        </li>
                        <li><i class="fas fa-phone-alt"></i><span>(883) 153 8591</span></li>
                    </ul>

                    <div class="login-signup">


                        <ul class="social-span m-0 hidden-xs hidden-sm">
                            <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
                            <li><a href=""><i class="fab fa-twitter"></i></a></li>
                            <li><a href=""><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <nav class="navbar nav-main navbar-expand-md bg-light navbar-light">
            <div class="logo">
                <a class="navbar-brand" href="./"><img src="./public/site/img/home/logo/logo.png" alt="Bakya"></a>
            </div>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ml-auto my-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="./" title="home">Home<span class="sr-only">(current)</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href='./?controller=home&action=about' title="about">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href='./?controller=product&action=allProducts' title="product">Product</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href='./?controller=contact' title="contact">Contact</a>
                    </li>

                    <li class="nav-item">
                        <div class="dropdown">
                            <a onclick="showSearchBar()" class="dropbtn nav-link" title="search"><i class="fas fa-search"></i></a>
                            <div id="myDropdown" class="dropdown-content">
                                <input type="text" placeholder="Search Product Name" id="myInput" onkeyup="showSearchResult(this.value)">
                                <div id="searched-items">
                                </div>

                            </div>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " href='./?controller=cart' title="cart"><i class="fas fa-shopping-basket"></i><span class="badge badge-warning navbar-badge" id="cart-quantity"><?= $_SESSION['total_quantity'] ?? 0 ?></span></a>
                    </li>

                </ul>
            </div>
        </nav>

    </header>
    <section class="error-404">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="error-block">
                        <h3>404</h3>
                        <h4>Oops ! Something's missing</h4>
                        <p>This page is missing or you assembled the link incorrectly <a href="./">Back to the home
                                page</a>
                        </p>
                        <div class="img-container">
                            <img src="./public/site/img/home/images/404.png" alt="">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-7">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a><img src="./public/site/img/home/logo/logo-white.png" alt="" style="width: 111px; height: 56px;"></a>
                        </div>
                        <p>ThemeMu comes with powerful theme options, which empowers you to quickly and easily build
                            incredible stores.</p>
                        <div class="footer__social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-google-plus-g"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-5">
                    <div class="footer__widget">
                        <h5>Contact</h5>
                        <ul id="contact-list">
                            <li><span><i class="fas fa-map-marker-alt"></i>Address:</span><span>0010 Avenue of the Moon, New
                                    York, NY 10018 US</span></li>
                            <li><span><i class="fas fa-phone-alt"></i>Phone:</span><span>(883) 153 8591</span></li>
                            <li><span><i class="far fa-envelope"></i>Email:</span><span>bakery@support.com</span></li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="footer__widget">
                        <h5>Recent post</h5>
                        <ul id="recent-post-list">
                            <li>
                                <div><img src="./public/site/img/home/footer/recent-post-1.png" alt=""></div>
                                <div>
                                    <p>Lorem ipsum dolor sit amet consectetur</p>
                                    <br>
                                    <span>Aug 20, 2020</span>
                                </div>
                            </li>
                            <li>
                                <div><img src="./public/site/img/home/footer/recent-post-2.png" alt=""></div>
                                <div>
                                    <p>Lorem ipsum dolor sit amet consectetur</p>
                                    <br>
                                    <span>Aug 10, 2020</span>
                                </div>
                            </li>

                            <!-- <li><a href="#">Orders Tracking</a></li> -->
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="footer__widget">
                        <h5>Photo on Instagram</h5>
                        <ul id="insta-list">
                            <li>
                                <div><img src="./public/site/img/home/footer/insta-1.png" alt=""></div>

                            </li>
                            <li>
                                <div><img src="./public/site/img/home/footer/insta-2.png" alt=""></div>

                            </li>
                            <li>
                                <div><img src="./public/site/img/home/footer/insta-3.png" alt=""></div>

                            </li>
                            <li>
                                <div><img src="./public/site/img/home/footer/insta-4.png" alt=""></div>

                            </li>
                            <li>
                                <div><img src="./public/site/img/home/footer/insta-5.png" alt=""></div>

                            </li>
                            <li>
                                <div><img src="./public/site/img/home/footer/insta-6.png" alt=""></div>

                            </li>


                            <!-- <li><a href="#">Orders Tracking</a></li> -->
                        </ul>
                    </div>
                </div>

            </div>

            <hr>

            <div class="footer__newsletter">
                <ul>
                    <li>
                        <div class="footer__newsletter__text">
                            <span>Enter your email below to get our</span><br>
                            <h5>Recipe of the day</h5>
                        </div>
                    </li>

                    <li>
                        <form action="#">
                            <input type="text" placeholder="Enter your email">

                            <button type="submit" class="site-btn">Submit</button>

                        </form>
                    </li>
                </ul>

            </div>



        </div>


        <div class="container-fluid">
            <div class="row copyright">
                <div class="col-md-12 p-0">
                    <div class=" footer__copyright__text">
                        <p>Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | This
                            template is made by Nguyen Manh Phuc
                        </p>
                    </div>
                </div>
            </div>
        </div>



    </footer>
    <!-- Footer Section End -->

</body>

<script src="./public/site/js/addToCartMsgHandle.js" type="text/javascript"></script>
<script src="./public/site/js/validate.js" type="text/javascript"></script>
<script src="./public/site/js/countdown.js" type="text/javascript"></script>
<script>
    /* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
    function showSearchBar() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    function showSearchResult(str) {
        str = str.trim();

        // locate element
        var x = document.getElementById("searched-items");

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("searched-items").innerHTML = this.responseText;
                // var option = document.createElement("option");
                // option.text = "Kiwi " + str;
                // x.add(option);

            }
        }
        // xmlhttp.open("GET", "?controller=product&action=search&product=" + str, true);
        xmlhttp.open("GET", "/bakya_mvc/?controller=product&action=ajaxSearch&product=" + str, true);
        xmlhttp.send();
    }
</script>

</html>