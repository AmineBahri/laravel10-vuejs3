<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
    <script type="text/javascript">
        let lang = localStorage.getItem('lang');
        if (!lang || lang=="ar") 
        {
            localStorage.setItem("lang","ar");
            var x = document.getElementsByTagName("link");
            for (var i = 0; i<x.length;i++) {
                if (x[i].getAttribute("href") == "css/sb-admin-2.min.css") 
                {
                    x[i].setAttribute("href","css/sb-admin-rtl.min.css")

                }
            }
        } else {
            var x = document.getElementsByTagName("link");
            for (var i = 0; i<x.length;i++) {
                if (x[i].getAttribute("href") == "css/sb-admin-rtl.min.css") 
                {
                    x[i].setAttribute("href","css/sb-admin-2.min.css")

                }
            }
        }
    </script>
</head>
@vite('resources/js/app.js')
<body id="page-top">
    <div id="app">
        <home-component /> </home-component>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>    
    
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    {{-- <script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script> --}}

    <!-- Page level custom scripts -->
    {{-- <script src="{{asset('js/demo/chart-area-demo.js')}}"></script>
    <script src="{{asset('js/demo/chart-pie-demo.js')}}"></script> --}}
</body>
</html>