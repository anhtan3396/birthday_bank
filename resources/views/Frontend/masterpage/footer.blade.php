<footer class="main-footer">
  <div class="footer">
    <strong>Copyright © 2017 <a href="#"></a>.</strong> All rights
    reserved.
  </div>
</footer>


<!-- bootstrap datepicker -->
<script src="{{ URL::asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

<script>
  $(function () {
    if (!Modernizr.inputtypes.date) {
      $('input[type=date]').datepicker({
        dateFormat: 'yy-mm-dd'
      }
      );
    }
  });
</script>

<script src="{{ URL::asset('bower_components/jquery/dist/jquery-confirm.min.js') }}"></script>