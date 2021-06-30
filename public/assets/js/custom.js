 //Validate Input Fields Ended

        // Login Form Script
        $('#register').click(function() {
            Swal.fire("Hey! Hey! Boyyyyyy");
        });

        //Google Button Custom Rendered
        function renderButton() {
            gapi.signin2.render('my-signin2', {
                'scope': 'profile email',
                'width': 150,
                'height': 40,
                'theme': 'dark',
                'onSuccess': onSignIn
            });
        }

        //Google Signin Script
        var clicked = false; //Global Variable
        function ClickLogin() {
            clicked = true;
        }

        //Normal Sign-in Functionality

        $("#login-form").submit(function(e) {
            e.preventDefault();
        });


        $("#login-submit").click(function() {

            var mobile = $("#mobile").val();
            var password = $("#password").val();
            var error = true; //Global Variable
            console.log(mobile, password);
            //    Validation of Mobile Field
            if (mobile.length == '') {
                $('#error-user').html("Please enter Mobile Number");
                error = false;
                Swal.fire({
                    title: 'Error!',
                    text: "Please enter Mobile Number",
                    icon: 'error',
                    confirmButtonText: 'OK'
                })

            }
            if (mobile.length > 10) {
                // if (mobile.length < 10 || mobile.length > 10) {
                $('#error-user').html("Please enter Valid Mobile Number");
                error = false;

                Swal.fire({
                    title: 'Error!',
                    text: "Please enter Valid Mobile Number",
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            }


            //Validation of Password Field
            if (password.length == '') {
                $('#error-pass').html("Please enter Password");
                error = false;

                Swal.fire({
                    title: 'Error!',
                    text: "Please enter Password",
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            }
            if (password.length < 3) {
                $('#error-pass').html("Please enter Valid Password");
                error = false;
                Swal.fire({
                    title: 'Error!',
                    text: "Please enter Valid Password",
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            }

            if (error) {

                $('#login-form').submit();

                if (data == 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text: "You have been successfully Logged In",
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    })

                }

            }

        });



        //Google-Signin Functionality
        function onSignIn(googleUser) {

            if (clicked) {
                var profile = googleUser.getBasicProfile();

                var name = profile.getName();
                var image = profile.getImageUrl();
                var email = profile.getEmail();

                $.post('<?php echo base_url() ?>/login', {
                    type: "google",
                    mobile: email,
                    password: ""
                }, function(data) {
                    console.log(data);

                    if (data == "fail") {

                        Swal.fire({
                            title: 'Error!',
                            text: data,
                            icon: 'error',
                            confirmButtonText: 'Signup'
                        })
                    }
                    if (data == 'success') {
                        Swal.fire({
                            title: 'Success!',
                            text: "You have been successfully Logged In",
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })

                    }

                });

                console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
                console.log('Name: ' + profile.getName());
                console.log('Image URL: ' + profile.getImageUrl());
                console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

            }
        }


        //Nice Select Script
        $(document).ready(function() {
            $('select').niceSelect();
        });



        //Signout Functionality
        function signOut() {

            var type = '<?php echo session("type") ?>';

            if (type == 'google') {
                var auth2 = gapi.auth2.getAuthInstance();
                auth2.signOut().then(function() {
                    console.log('User signed out.');
                });
            }
            $.post('<?php echo base_url() ?>/logout', {
                type: type

            }, function(data) {
                console.log(data);

                if (data == "fail") {

                    Swal.fire({
                        title: 'Error!',
                        text: data,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }
                if (data == 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text: "You have been successfully Logged out",
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    })

                }
            });
        }
  