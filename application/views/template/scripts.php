        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
      <!--  <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script> -->
<!-- Core theme JS-->
      <!-- <script src="<?php echo base_url()?>public/js/scripts.js"></script>-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>


        <!--ALERTS-->
        <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js
"></script>


<?php
            if(isset($scripts)){
                foreach($scripts as $scripts_name){

                    $src = base_url() . "public/js/" . $scripts_name; ?>
                       <script src="<?= $src ?>"></script>
                    <?php 
                    

                }
            } 
        ?>
        
    </body>
</html>