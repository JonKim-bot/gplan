                        </div>

                        </div>
                        </main>
                        </div>
                        <footer class="c-footer">
                            <!-- <div><a href="#">Gplan.</a> &copy; 2020 Creative Labs.</div> -->
                            <!-- <div class="ml-auto">Powered by&nbsp;<a href="#">wynndarrien</a></div> -->
                        </footer>




                        </div>

                        <script src="<?= base_url() ?>/assets/js/core/bundle.js"></script>

                        <script src="<?= base_url() ?>/assets/js/core/icons.js"></script>

                        <!-- <script src="<?= base_url() ?>assets/plugins/chartjs/js/chartjs.js"></script> -->
                        <script src="<?= base_url() ?>/assets/js/core/utils.js"></script>
                        <!-- <script src="<?= base_url() ?>/assets/js/core/main.js"></script> -->

                        <script src="<?= base_url() ?>/assets/js/core/permission.js"></script>

                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>

                        <script src="<?= base_url() ?>/assets/js/core/custom.js"></script>

                        <script src="<?= base_url() ?>/assets/js/core/customTable.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
                        <!--Slick-Slider-->
                        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>

                        <!-- Flatpickr -->
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                        <!-- </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>

        <script src="<?= base_url('assets/js/core/bundle.js') ?>"></script>
       
        
        <script src="<?= base_url('assets/js/core/icons.js') ?>"></script>
        

        <!-- <script src="<?= base_url() ?>assets/plugins/chartjs/js/chartjs.js"></script> -->
                        <!-- <script src="<?= base_url('assets/js/core/utils.js') ?>"></script> -->

                        <!-- <script src="<?= base_url() ?>/assets/js/core/main.js"></script> -->
                        <!-- 
        <script src="<?= base_url('assets/js/core/permission.js') ?>"></script>

        <script src="<?= base_url('assets/js/core/custom.js') ?>"></script>
        <script src="<?= base_url('assets/js/core/customTable.js') ?>"></script>
                <script src="<?= base_url() ?>/assets/plugins/datatable/js/jquery.dataTables.js"></script> 
        <script src="<?= base_url() ?>/assets/plugins/datatable/js/dataTables.bootstrap4.min.js"></script>  -->

                        <script src="<?= base_url() ?>/assets/plugins/datatable/js/jquery.dataTables.js"></script>
                        <script src="<?= base_url() ?>/assets/plugins/datatable/js/dataTables.bootstrap4.min.js"></script>

                        </body>

                        </html>




                        <script>
                            // $('.dataTable').customTable();
                            $('.datatable').DataTable();

                            $(".minimize-card").on('click', function() {
                                var $this = $(this);
                                var port = $($this.parents('.card'));
                                var card = $(port).children('.card-body').slideToggle();
                                var card = $(port).children('.c-card-body').slideToggle();
                                $(this).toggleClass("cil-arrow-circle-bottom").fadeIn('slow');
                                $(this).toggleClass("cil-arrow-circle-top").fadeIn('slow');
                            });
                            $('.select2').select2();

                            $('.slider-nav').slick({
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                asNavFor: '.slider-nav',
                                dots: false,
                                focusOnSelect: true
                            });

                            $('.slick-slider-promo').slick({
                                // vertical: true,
                                autoplay: true,
                                autoplaySpeed: 5000,
                                dots: true,
                                arrows: false,
                                slidesToShow: 1,
                                slidesToScroll: 1,
                            });
                            //selected only one image

                            // $('.custom-file-input').on('change',function(){
                            //     //get the file name
                            //     var fileName = $(this).val().split("\\").pop(); 		
                            //     //replace the "Choose a file" label
                            //     $(this).next('.custom-file-label').html(fileName);
                            // });


                            $('.datatable5').dataTable({
                                "pageLength": 5
                            });

                            $(document).on("click", ".delete-button", function(e) {
                                e.preventDefault();

                                var delete_record = confirm("Are you sure you want to delete this record?");
                                var path = $(this).attr("href");

                                if (delete_record === true) {
                                    window.location.replace(path);
                                }
                            });



                            // $(document).on("click", ".delete-button", function(e) {
                            //     e.preventDefault();

                            //     var delete_record = confirm("Are you sure you want to delete this record?");
                            //     var path = $(this).attr("href");

                            //     if (delete_record === true) {
                            //         window.location.replace(path);
                            //     }
                            // });
                        </script>



                        <script>
                            //preview image before upload (single image)

                            // function readURL(input) {
                            //     if (input.files && input.files[0]) {
                            //         var reader = new FileReader();

                            //         reader.onload = function(e) {
                            //         $('#blah').attr('src', e.target.result);
                            //         }

                            //         reader.readAsDataURL(input.files[0]);
                            //     }
                            // }

                            // $("#thumbnail").change(function() {
                            //     readURL(this);
                            // });
                        </script>

                        <script>
                            //if you want to display name by name

                            // $('.custom-file-input').change(function (e) {
                            //     var files = [];
                            //     for (var i = 0; i < $(this)[0].files.length; i++) {
                            //         files.push($(this)[0].files[i].name);
                            //     }
                            //     $(this).next('.custom-file-label').html(files.join(', '));
                            // });


                            $('.custom-file input').change(function() {
                                files = $(this)[0].files,

                                    label = files[0].name;
                                if (files.length > 1) {
                                    label = String(files.length) + " files selected"
                                }
                                $(this).next('.custom-file-label').html(label);
                            });
                        </script>