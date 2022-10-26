</div></div></div>
<!--Footer-->
			<footer class="footer">
				<div class="container">
					<div class="row align-items-center flex-row-reverse">
						<div class="col-md-12 col-sm-12 mt-3 mt-lg-0 text-center">
							Copyright © 2020 <a href="#"></a> Developed by <a href="#">MK</a><i class="fa fa-heart text-danger"></i> All rights reserved.
						</div>
					</div>
				</div>
			</footer>
			<!-- End Footer-->

		</div>

		<!-- Back to top -->
		<a href="#top" id="back-to-top">
			<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z"/></svg>
		</a>

		<!-- Jquery js-->
		<script src="{{ asset('js/vendors/jquery-3.5.1.min.js') }}"></script>

		<!-- Bootstrap4 js-->
		<script src="{{ asset('plugins/bootstrap/popper.min.js') }}"></script>
		<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>

		<!--Othercharts js-->
		<script src="{{ asset('plugins/othercharts/jquery.sparkline.min.js') }}"></script>

		<!-- Circle-progress js-->
		<script src="{{ asset('js/vendors/circle-progress.min.js') }}"></script>

		<!-- Jquery-rating js-->
		<script src="{{ asset('plugins/rating/jquery.rating-stars.js') }}"></script>

		<!--Sidemenu js-->
		<script src="{{ asset('plugins/sidemenu/sidemenu.js') }}"></script>

		<!-- P-scroll js-->
		<script src="{{ asset('plugins/p-scrollbar/p-scrollbar.js') }}"></script>
		<script src="{{ asset('plugins/p-scrollbar/p-scroll1.js') }}"></script>

		<!-- ECharts js -->
		<script src="{{ asset('plugins/echarts/echarts.js') }}"></script>

		<!-- Peitychart js-->
		<script src="{{ asset('plugins/peitychart/jquery.peity.min.js') }}"></script>
		<script src="{{ asset('plugins/peitychart/peitychart.init.js') }}"></script>

		<!-- Apexchart js-->
		<script src="{{ asset('js/apexcharts.js') }}"></script>

		<!--Moment js-->
		<script src="{{ asset('plugins/moment/moment.js') }}"></script>

		<!-- Daterangepicker js-->
		<script src="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
		<script src="{{ asset('js/daterange.js') }}"></script>

		<!---jvectormap js-->
		<!-- <script src="{{ asset('plugins/jvectormap/jquery.vmap.js') }}"></script>
		<script src="{{ asset('plugins/jvectormap/jquery.vmap.world.js') }}"></script>
		<script src="{{ asset('plugins/jvectormap/jquery.vmap.sampledata.js') }}"></script> -->

		<!-- Index js-->
		<script src="{{ asset('js/index1.js') }}"></script>

		<!-- Data tables js-->
		<script src="{{ asset('plugins/datatable/js/jquery.dataTables.js') }}"></script>
		<script src="{{ asset('plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
		<script src="{{ asset('plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
		<script src="{{ asset('plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('plugins/datatable/js/jszip.min.js') }}"></script>
		<script src="{{ asset('plugins/datatable/js/pdfmake.min.js') }}"></script>
		<script src="{{ asset('plugins/datatable/js/vfs_fonts.js') }}"></script>
		<script src="{{ asset('plugins/datatable/js/buttons.html5.min.js') }}"></script>
		<script src="{{ asset('plugins/datatable/js/buttons.print.min.js') }}"></script>
		<script src="{{ asset('plugins/datatable/js/buttons.colVis.min.js') }}"></script>
		<script src="{{ asset('plugins/datatable/dataTables.responsive.min.js') }}"></script>
		<script src="{{ asset('plugins/datatable/responsive.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('js/datatables.js') }}"></script>

		<!--Counters -->
		<script src="{{ asset('plugins/counters/counterup.min.js') }}"></script>
		<script src="{{ asset('plugins/counters/waypoints.min.js') }}"></script>

		<!--Chart js -->
		<script src="{{ asset('plugins/chart/chart.bundle.js') }}"></script>
		<script src="{{ asset('plugins/chart/utils.js') }}"></script>

		<!-- Custom js-->
		<script src="{{ asset('js/custom.js') }}"></script>
        @stack('datatable-khushbu')
        @stack('mk')
		@stack('autocomp-khushbu')
	</body>
</html>
