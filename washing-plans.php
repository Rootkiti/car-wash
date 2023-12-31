<?php
error_reporting(0);
include('includes/config.php');

if (isset($_POST['book'])) {
    $ptype = $_POST['packagetype'];
    $wpoint = $_POST['washingpoint'];
    $fname = $_POST['fname'];
    $mobile = $_POST['contactno'];
    $date = $_POST['washdate'];
    $time = $_POST['washtime'];
    $message = $_POST['message'];
    $status = 'New';
    $bno = mt_rand(100000000, 999999999);

    // getting capacity of selected washing point
    $capacity;
    $capacitysql = "SELECT capacity from tblwashingpoints where id='$_POST[washingpoint]'";
    $capacityquery = $dbh->prepare($capacitysql);
    $capacityquery->execute();
    $capacityresults = $capacityquery->fetchAll(PDO::FETCH_OBJ);
    foreach ($capacityresults as $cr) {
        $capacity = $cr->capacity;
    }

    // checking if washing point is availabe for selected date and time 
    $wtime = substr($_POST['washtime'], 0, 2);
    $capacitysql = "SELECT * from tblcarwashbooking where  washTime like '$wtime%' and carWashPoint='$_POST[washingpoint]' and washDate='$_POST[washdate]' and status='new' ";
    $capacityquery = $dbh->prepare($capacitysql);
    // $capacityquery->bindParam(':wtime', $wtime, PDO::PARAM_STR);
    $capacityquery->execute();
    $capacityresults = $capacityquery->fetchAll(PDO::FETCH_OBJ);
    $cnt = $capacityquery->rowCount();
    if ($cnt < $capacity) {

        $sql = "INSERT INTO tblcarwashbooking(bookingId,packageType,carWashPoint,fullName,mobileNumber,washDate,washTime,message,status) VALUES(:bno,:ptype,:wpoint,:fname,:mobile,:date,:time,:message,:status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bno', $bno, PDO::PARAM_STR);
        $query->bindParam(':ptype', $ptype, PDO::PARAM_STR);
        $query->bindParam(':wpoint', $wpoint, PDO::PARAM_STR);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $query->bindParam(':date', $date, PDO::PARAM_STR);
        $query->bindParam(':time', $time, PDO::PARAM_STR);
        $query->bindParam(':message', $message, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {

            echo '<script>alert("Your booking done successfully. Booking number is "+"' . $bno . '")</script>';
            echo "<script>window.location.href ='washing-plans.php'</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('this washing point is full at this time, choose different time or another washing point !!');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CWMS | Washing Plans</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free Website Template" name="keywords">
    <meta content="Free Website Template" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <?php include_once('includes/header.php'); ?>

    <!-- Page Header Start -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Washing Plan</h2>
                </div>
                <div class="col-12">
                    <a href="index.php">Home</a>
                    <a href="washing-plans.php">Price</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Price Start -->
    <div class="price">
        <div class="container">
            <div class="section-header text-center">
                <p>Washing Plan</p>
                <h2>Choose Your Plan</h2>
            </div>
            <div class="row">
                <!-- start test cards -->

             
                <div class="col-md-4">
                    <div class="price-item">
                        <div class="price-header">
                            
                            <img src="img/car.png" alt="" width="70" height="70">
                        </div>
                        <div class="price-body">
                            <ul>
                                <li>Imadoka Ntoya Koza Bisanzwe ..............3000RW</li>
                                <li>Imadoka Ntoya Koza N'imashini ............4000RW </li>
                                <li>Imadoka Ntoya Koza na moteri .............5000RW</li>
                                <li>Imadoka Ntoya General wash ...............12000RW</li>
                              

                            </ul>
                        </div>
                        <div class="price-footer">
                            <a class="btn btn-custom" data-toggle="modal" data-target="#myModal">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="price-item">
                        <div class="price-header">
                            
                            <img src="img/jeep.png" alt="" width="70" height="70">
                        </div>
                        <div class="price-body">
                            <ul>
                                <li>(MIN JEEP) Koza Bisanzwe ..............3500RW</li>
                                <li>(MIN JEEP) Koza N'imashini ............4500RW </li>
                                <li>(MIN JEEP) Koza na moteri .............5500RW</li>
                                <li>(MIN JEEP) General wash ...............15000RW</li>
                              

                            </ul>
                        </div>
                        <div class="price-footer">
                            <a class="btn btn-custom" data-toggle="modal" data-target="#myModal">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="price-item">
                        <div class="price-header">
                            
                            <img src="img/bus.png" alt="" width="70" height="70">
                        </div>
                        <div class="price-body">
                            <ul>
                                <li>MinBus (Coaster) Koza Bisanzwe ..............5000RW</li>
                                <li>MinBus (Coaster) Koza N'imashini ............5000RW </li>
                                <li>MinBus (Coaster) Koza na moteri .............6000RW</li>
                                <li>MinBus (Coaster) General wash ...............15000RW</li>
                              

                            </ul>
                        </div>
                        <div class="price-footer">
                            <a class="btn btn-custom" data-toggle="modal" data-target="#myModal">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="price-item">
                        <div class="price-header">
                            
                            <img src="img/van.png" alt="" width="70" height="70">
                        </div>
                        <div class="price-body">
                            <ul>
                                <li>Van (Hiace) Koza Bisanzwe ..............4000RW</li>
                                <li>Van (Hiace) Koza N'imashini ............5000RW </li>
                                <li>Van (Hiace) Koza na moteri .............6000RW</li>
                                <li>Van (Hiace) General wash ...............15000RW</li>
                              

                            </ul>
                        </div>
                        <div class="price-footer">
                            <a class="btn btn-custom" data-toggle="modal" data-target="#myModal">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="price-item">
                        <div class="price-header">
                            
                            <img src="img/pickup.png" alt="" width="70" height="70">
                        </div>
                        <div class="price-body">
                            <ul>
                                <li>Ick Up (D/C) Koza Bisanzwe ..............4000RW</li>
                                <li>Ick Up (D/C) Koza N'imashini ............5000RW </li>
                                <li>Ick Up (D/C) Koza na moteri .............6000RW</li>
                                <li>Ick Up (D/C) General wash ...............15000RW</li>
                              

                            </ul>
                        </div>
                        <div class="price-footer">
                            <a class="btn btn-custom" data-toggle="modal" data-target="#myModal">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="price-item">
                        <div class="price-header">
                            
                            <img src="img/lorry.png" alt="" width="70" height="70">
                        </div>
                        <div class="price-body">
                            <ul>
                                <li>Small Truck (Dyna) Koza Bisanzwe ..............7000RW</li>
                                <li>Small Truck (Dyna) Koza N'imashini ............8000RW </li>
                            
                              

                            </ul>
                        </div>
                        <div class="price-footer">
                            <a class="btn btn-custom" data-toggle="modal" data-target="#myModal">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="price-item">
                        <div class="price-header">
                            
                            <img src="img/suv.png" alt="" width="70" height="70">
                        </div>
                        <div class="price-body">
                            <ul>
                                <li>SUV(Jeep) Koza Bisanzwe ..............4000RW</li>
                                <li>SUV(Jeep) Koza N'imashini ............5000RW </li>
                                <li>SUV(Jeep) Koza na moteri .............6000RW</li>
                                <li>SUV(Jeep) General wash ...............15000RW</li>
                              

                            </ul>
                        </div>
                        <div class="price-footer">
                            <a class="btn btn-custom" data-toggle="modal" data-target="#myModal">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="price-item">
                        <div class="price-header">
                            
                            <img src="img/pickup.png" alt="" width="70" height="70">
                        </div>
                        <div class="price-body">
                            <ul>
                                <li>Pick Up(S/C) Koza Bisanzwe ..............3000RW</li>
                                <li>Pick Up(S/C) Koza N'imashini ............4000RW </li>
                                <li>Pick Up(S/C) Koza na moteri .............5000RW</li>
                                <li>Pick Up(S/C) General wash ...............12000RW</li>
                              

                            </ul>
                        </div>
                        <div class="price-footer">
                            <a class="btn btn-custom" data-toggle="modal" data-target="#myModal">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="price-item">
                        <div class="price-header">
                            
                            <img src="img/mini-van.png" alt="" width="70" height="70">
                        </div>
                        <div class="price-body">
                            <ul>
                                <li>MIN VAN Koza Bisanzwe ..............3000RW</li>
                                <li>MIN VAN Koza N'imashini ............4000RW </li>
                                <li>MIN VAN Koza na moteri .............5000RW</li>
                                <li>MIN VAN General wash ...............15000RW</li>
                              

                            </ul>
                        </div>
                        <div class="price-footer">
                            <a class="btn btn-custom" data-toggle="modal" data-target="#myModal">Book Now</a>
                        </div>
                    </div>
                </div>



                <!-- end test cards -->
                
                
            </div>
        </div>
    </div>
    <!-- Price End -->

    <?php include_once('includes/footer.php'); ?>

    <!--Model-->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Car Wash Booking</h4>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <p>
                            <select name="packagetype" required class="form-control">
                                <option value="">Package Type</option>
                                <?php $pricesql = "SELECT * from tblprice";
                                $pricequery = $dbh->prepare($pricesql);
                                $pricequery->execute();
                                $priceresults = $pricequery->fetchAll(PDO::FETCH_OBJ);
                                foreach ($priceresults as $priceresult) {               ?>
                                    <option value="<?php echo htmlentities($priceresult->id); ?>"><?php echo htmlentities($priceresult->service); ?> (<?php echo htmlentities($priceresult->cost); ?>)</option>
                                <?php } ?>
                            </select>

                        <p>
                            <select name="washingpoint" required class="form-control">
                                <option value="">Select Washing Point</option>
                                <?php $sql = "SELECT * from tblwashingpoints where is_active=1";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                foreach ($results as $result) {               ?>
                                    <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->washingPointName); ?> (<?php echo htmlentities($result->washingPointAddress); ?>)</option>
                                <?php } ?>
                            </select>
                        </p>
                        <p><input type="text" name="fname" class="form-control" required placeholder="Full Name"></p>
                        <p><input type="text" name="contactno" class="form-control" pattern="[0-9]{10}" title="10 numeric characters only" required placeholder="Mobile No."></p>
                        <p>Wash Date <br /><input type="date" name="washdate" required class="form-control"></p>
                        <p>Wash Time <br /><input type="time" name="washtime" required class="form-control"></p>
                        <p><textarea name="message" class="form-control" placeholder="Message if any"></textarea></p>
                        <p><input type="submit" class="btn btn-custom" name="book" value="Book Now"></p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>