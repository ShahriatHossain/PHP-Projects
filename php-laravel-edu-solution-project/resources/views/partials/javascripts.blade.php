<!-- Javascript files-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"> </script>
    <script src="{{ url('admindashboard/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('admindashboard/vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
    <script src="{{ url('admindashboard/js/grasp_mobile_progress_circle-1.0.0.min.js') }}"></script>
    <script src="{{ url('admindashboard/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ url('admindashboard/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="{{ url('admindashboard/js/charts-home.js') }}"></script>
    <script src="{{ url('admindashboard/js/front.js') }}"></script>
    <script src="{{ url('js/pace.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.7.3/dist/combined/js/gijgo.min.js" type="text/javascript"></script>
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
    <!---->
    <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create','UA-XXXXX-X');ga('send','pageview');
    </script>

    <script>
        $('#semsStartDate').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd'
        });

        $('#semsEndDate').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd'
        });
    </script>

  