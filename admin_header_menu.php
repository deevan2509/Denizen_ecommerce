<!--Navigation bar start-->
<nav class="navbar fixed-top navbar-expand-sm navbar-dark" style="background-color:rgba(0,0,0,0.5)">
    <div class="container">
        <a href="admin_dashboard.php" class="navbar-brand" style="font-family: 'Delius Swash Caps'; color: #fff;">DENIZEN</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="nav navbar-nav">
                <li class="nav-item"><a href="product_management.php" class="nav-link">Products</a></li>
                <li class="nav-item"><a href="order_management.php" class="nav-link">Orders</a></li>
                <li class="nav-item"><a href="customer_management.php" class="nav-link">Customers</a></li>
            </ul>
            <?php if (isset($_SESSION['email'])) { ?>
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item"><a href="logout_script.php" class="nav-link"><i class="fa fa-sign-out"></i>Logout</a></li>
                    <li class="nav-item"><a class="nav-link" data-placement="bottom" data-toggle="popover" data-trigger="hover" data-content="<?php echo $_SESSION['email'] ?>"><i class="fa fa-user-circle "></i></a></li>
                </ul>
            <?php } else { ?>
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item "><a href="#signup" class="nav-link" data-toggle="modal"><i class="fa fa-user"></i> Sign Up</a></li>
                    <li class="nav-item "><a href="#login" class="nav-link" data-toggle="modal"><i class="fa fa-sign-in"></i> Login</a></li>
                </ul>
            <?php } ?>
        </div>
    </div>
</nav>