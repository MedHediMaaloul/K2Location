        <footer class="footer text-center">
          2022 © 
          <a href="http://k2group.fr">K2 Group</a>
        </footer>

   
    <script src="plugins/bower_components/jquery/dist/jquery1-9.min.js"></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
    <script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    





    <!-- Bootstrap tether Core JavaScript -->
    <script src="plugins/bower_components/popper.js/dist/umd/popper.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="js/app-style-switcher.js"></script>
    <script src="plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.js"></script>
    <script src="js/entretien.js"></script>
    <script src="js/myjs.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="plugins/bower_components/chartist/dist/chartist.min.js"></script>
    <script src="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="js/pages/dashboards/dashboard1.js"></script>
    <!--select2 input-->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> 

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->
    <script>
      function reply_click1(clicked_id)
      {  
          console.log(clicked_id);
          $.ajax({
              url: "ListeNotifEntretienUpdate.php",
              method: "POST",
              data: {
                clicked_id: clicked_id
              },
              dataType: "json",
              success: function (data) {
              },
            });
      }
    </script> 
    
