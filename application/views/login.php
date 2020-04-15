<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Smartans House | Login</title>
        <base href="<?php echo base_url() ?>">

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/login/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/login/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/login/css/form-elements.css">
        <link rel="stylesheet" href="assets/login/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <!-- <link rel="shortcut icon" href="assets/login/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/login/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/login/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/login/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/login/ico/apple-touch-icon-57-precomposed.png"> -->

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
            
            <div class="inner-bg">
                <div class="container" id="login">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>APLIKASI</strong> SMARTANS HOUSE</h1>
                            <div class="description">
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                            <div class="form-top">
                                <div class="form-top-left">
                                    <h3>Silahkan Login</h3>
                                    <p>Enter your username and password to log on:</p>
                                </div>
                                <div class="form-top-right">
                                    <i class="fa fa-key"></i>
                                </div>
                            </div>
                            <div class="form-bottom">
                                <form action="login/aksi_login" method="POST">
                                    <div class="form-group">
                                        <label class="sr-only" for="form-username">Username</label>
                                        <input type="text" name="username" placeholder="Email..." class="form-username form-control" id="form-username">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-password">Password</label>
                                        <input type="password" name="password" placeholder="Password..." class="form-password form-control" id="form-password">
                                    </div>
                                    <button id="btnLogin" class="btn">LOGIN!</button>
                                    <p>
                                        <b>Belum punya akun, </p><a class="btn btn-primary" id="btndaftar">DAFTAR DISINI</a></b>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>


                <div class="container" id="daftar" style="display: none;">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>APLIKASI</strong> SMARTANS HOUSE</h1>
                            <div class="description">
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                            <div class="form-top">
                                <div class="form-top-left">
                                    <h3>FORM PENDAFTARAN</h3>
                                    <p>Silahkan isi form berikut untuk mendaftar :</p>
                                </div>
                                <div class="form-top-right">
                                    <i class="fa fa-key"></i>
                                </div>
                            </div>
                            <div class="form-bottom">
                                <form action="login/daftar" method="POST">
                                    <div class="form-group">
                                        <label class="sr-only" for="form-nama">Nama Depan</label>
                                        <input type="text" name="first_name" placeholder="Nama Depan..." class="form-nama form-control" id="form-nama">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-lastname">Nama Belakang</label>
                                        <input type="text" name="last_name" placeholder="Nama Belakang..." class="form-lastname form-control" id="form-lastname">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-notelp">No Telp</label>
                                        <input type="text" name="mobile_no" placeholder="No Telp..." class="form-notelp form-control" id="form-notelp">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="sr-only" for="form-email">Email</label>
                                        <input type="text" name="email" placeholder="Email..." class="form-email form-control" id="form-email">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="sr-only" for="form-password">Password</label>
                                        <input type="password" name="password" placeholder="Password..." class="form-password form-control" id="form-password">
                                    </div>
                                    <div class="form-group" >
                                        <select class="form-control" name="location_id" required>
                                            <option value="">--Pilih Lokasi--</option>
                                            <?php 
                                            $this->db->where('ACTIVE_FLAG', '1');
                                            foreach ($this->db->get('smartans_location')->result() as $key => $value): ?>
                                                <option value="<?php echo $value->LOCATION_ID ?>"><?php echo $value->LOCATION_ID ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>

                                    <div class="form-group" >
                                        <select class="form-control" name="room_id" required>
                                            <option value="">--Pilih Room--</option>
                                            <?php 
                                            foreach ($this->db->get('v_cek_room')->result() as $key => $value): ?>
                                                <option value="<?php echo $value->ROOM_ID ?>"><?php echo $value->ROOM_ID ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>


                                    <button id="btnLogin" class="btn">SIMPAN!</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>

            </div>
            
        </div>


        <!-- Javascript -->
        <script src="assets/login/js/jquery-1.11.1.min.js"></script>
        <script src="assets/login/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/login/js/jquery.backstretch.min.js"></script>
        <script src="assets/login/js/scripts.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#btndaftar').click(function(event) {
                    $('#daftar').show();
                    $('#login').hide();
                });
            });
            // $(document).ready(function() {
            //     $('#btnLogin').click(function() {
            //         var username = $('#form-username').val();
            //         var password = $('#form-password').val();
            //         console.log(username);
            //         console.log(password);
            //         $.ajax({
            //             url: '<?php echo base_url() ?>login/aksi_login',
            //             type: 'POST',
            //             // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
            //             data: {username: username, password: password},
            //         })
            //         .done(function() {
            //             console.log("success");
            //         })
            //         .fail(function() {
            //             console.log("error");
            //         })
            //         .always(function() {
            //             console.log("complete");
            //         });
                    
            //     });
            // });
        </script>
        <script type="text/javascript"><?php echo $this->session->userdata('message') ?></script>
        
        <!--[if lt IE 10]>
            <script src="assets/login/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>