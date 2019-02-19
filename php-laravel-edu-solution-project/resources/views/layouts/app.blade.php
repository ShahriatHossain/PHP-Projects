<!DOCTYPE html>
<html>
  <head>
    @include('partials.head')
  </head>
  <body>
    @include('partials.sidebar')
    <div class="page home-page">
      @include('partials.header')
      @include('partials.breadcrumb')
      <section class="charts">
        <div class="container-fluid">
          @yield('content')
        </div>
      </section>
      
      <footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <p>Your company &copy; 2017-2019</p>
            </div>
            <div class="col-sm-6 text-right">
              <p>Design by <a href="https://bootstrapious.com" class="external">Bootstrapious</a></p>
              <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
            </div>
          </div>
        </div>
      </footer>
    </div>
    @include('partials.javascripts')
  </body>
</html>