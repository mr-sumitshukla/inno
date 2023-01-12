<?php
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$page = $components[2];

$page_id = $this->input->get('page_id');


?>
<div class="vertical-menu">
	<div data-simplebar class="h-100">
		<div id="sidebar-menu">
			<ul class="metismenu list-unstyled" id="side-menu">
				<li class="menu-title" key="t-menu">Menu</li>

				<li>
					<a href="<?= base_url('dashboard') ?>" class="waves-effect">
						<i class="bx bx-home-circle"></i>
						<span key="t-dashboards">Dashboards</span>
					</a>
				</li>
				<li class="menu-title" key="t-apps">Apps</li>


				<li>
					<a href="<?= base_url('banner') ?>" class="waves-effect">
						<i class="bx bx-file"></i>
						<span key="t-file-manager">Banner</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url('changePassword') ?>" class="waves-effect">
						<i class="fas fa-lock"></i>
						<span key="t-file-manager">Change Password</span>
					</a>
				</li>

				<li class="<?php if ($page == "storeAll" || $page == 'storeAdd') {
								echo "mm-active";
							} ?>">
					<a href="<?= base_url('storeAll') ?>" class="waves-effect">
						<i class="fas fa-store"></i>
						<span key="t-file-manager">Store</span>
					</a>
				</li>


				<li class="<?php if ($page == "serviceAll" || $page == 'serviceAdd' || $page == 'subServiceAll' || $page == 'subServiceAdd' || $page == 'formFieldTypeAll' || $page == 'formFieldTypeAdd' || $page == 'formFieldAll' || $page == 'formFieldAdd' || $page == 'serviceHospitalAll' || $page == 'serviceHospitalAdd' || $page == 'subServiceHospitalAll' || $page == 'subServiceHospitalAdd' || $page == 'categoryAll' || $page == 'categoryAdd' || $page == 'productAll' || $page == 'productAdd') {
								echo "mm-active";
							} ?>">
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="fab fa-product-hunt"></i>
						<span key="t-ecommerce">Add On Data</span>
					</a>
					<ul class="sub-menu" aria-expanded="false">
						<li>
							<a href="<?= base_url('serviceAll') ?>" class="<?php if ($page == "serviceAll" || $page == 'serviceAdd') {
																				echo 'active';
																			} ?>" key="t-category">Service
							</a>
						</li>
						<li>
							<a href="<?= base_url('subServiceAll') ?>" class="<?php if ($page == "subServiceAll" || $page == 'subServiceAdd') {
																					echo 'active';
																				} ?>" key="t-category">Sub Service
							</a>
						</li>
						<li>
							<a href="<?= base_url('formFieldTypeAll') ?>" class="<?php if ($page == "formFieldTypeAll" || $page == 'formFieldTypeAdd') {
																						echo 'active';
																					} ?>" key="t-category">Form Field Type
							</a>
						</li>
						<li>
							<a href="<?= base_url('formFieldAll') ?>" class="<?php if ($page == "formFieldAll" || $page == 'formFieldAdd') {
																					echo 'active';
																				} ?>" key="t-category">Form Field
							</a>
						</li>
						<li>
							<a href="<?= base_url('serviceHospitalAll') ?>" class="<?php if ($page == "serviceHospitalAll" || $page == 'serviceHospitalAdd') {
																						echo 'active';
																					} ?>" key="t-category">Hospital Service
							</a>
						</li>
						<li>
							<a href="<?= base_url('subServiceHospitalAll') ?>" class="<?php if ($page == "subServiceHospitalAll" || $page == 'subServiceHospitalAdd') {
																							echo 'active';
																						} ?>" key="t-category">Hospital Sub Service
							</a>
						</li>
						<li>
							<a href="<?= base_url('categoryAll') ?>" class="<?php if ($page == "categoryAll" || $page == 'categoryAdd') {
																				echo 'active';
																			} ?>" key="t-category">Product Category
							</a>
						</li>
						<li>
							<a href="<?= base_url('productAll') ?>" class="<?php if ($page == "productAll" || $page == 'productAdd') {
																				echo 'active';
																			} ?>" key="t-category">Rental Product
							</a>
						</li>
					</ul>
				</li>

				<li class="<?php if ($page == "activePartner" || $page == 'inactivePartner' || $page == 'partnerDetails' || $page == 'verifyPartner' || $page == 'verifyCancelPartner' || $page == 'partnerPayOut' || $page == 'partnerPayoutDetails' || $page == 'payOutHistory' || $page == "interViewRequest" || $page == 'allInterViewRequest') {
								echo "mm-active";
							} ?>">
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="fab fa-product-hunt"></i>
						<span key="t-ecommerce">Partner</span>
					</a>
					<ul class="sub-menu" aria-expanded="false">
						<li>
							<a href="<?= base_url('activePartner') ?>" class="<?php if ($page == "activePartner") {
																					echo 'active';
																				} ?>" key="t-category">Active Partner
							</a>
						</li>
						<li>
							<a href="<?= base_url('inactivePartner') ?>" class="<?php if ($page == "inactivePartner") {
																					echo 'active';
																				} ?>" key="t-category">Inactive Partner
							</a>
						</li>
						<li>
							<a href="<?= base_url('interViewRequest') ?>" class="<?php if ($page == "interViewRequest") {
																						echo 'active';
																					} ?>" key="t-category">New Interview Request
							</a>
						</li>
						<li>
							<a href="<?= base_url('allInterViewRequest') ?>" class="<?php if ($page == "allInterViewRequest") {
																						echo 'active';
																					} ?>" key="t-category">All Interview Request
							</a>
						</li>
						<li>
							<a href="<?= base_url('verifyPartner') ?>" class="<?php if ($page == "verifyPartner") {
																					echo 'active';
																				} ?>" key="t-category">Verify Partner
							</a>
						</li>
						<li>
							<a href="<?= base_url('verifyCancelPartner') ?>" class="<?php if ($page == "verifyCancelPartner") {
																						echo 'active';
																					} ?>" key="t-category">Verify Cancel Partner
							</a>
						</li>
						<li>
							<a href="<?= base_url('partnerPayOut') ?>" class="<?php if ($page == "partnerPayOut" || $page == 'partnerPayoutDetails' || $page == 'payOutHistory') {
																					echo 'active';
																				} ?>" key="t-category">Partner Payout
							</a>
						</li>
					</ul>
				</li>

				<li class="<?php if ($page == "partnerTraining" || $page == 'partnerTrainingSend') {
								echo "mm-active";
							} ?>">
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="fab fa-product-hunt"></i>
						<span key="t-ecommerce">Partner Training</span>
					</a>
					<ul class="sub-menu" aria-expanded="false">
						<li>
							<a href="<?= base_url('partnerTrainingSend') ?>" class="<?php if ($page == "partnerTrainingSend") {
																					echo 'active';
																				} ?>" key="t-category">Send Training
							</a>
						</li>
						<li>
							<a href="<?= base_url('partnerTraining') ?>" class="<?php if ($page == "partnerTraining") {
																						echo 'active';
																					} ?>" key="t-category">Send History
							</a>
						</li>
					</ul>
				</li>

				<li class="<?php if ($page == "activeUser" || $page == 'inactiveUser' || $page == 'userDetails') {
								echo "mm-active";
							} ?>">
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="fab fa-product-hunt"></i>
						<span key="t-ecommerce">Users</span>
					</a>
					<ul class="sub-menu" aria-expanded="false">
						<li>
							<a href="<?= base_url('activeUser') ?>" class="<?php if ($page == "activeUser") {
																				echo 'active';
																			} ?>" key="t-category">Active Users
							</a>
						</li>
						<li>
							<a href="<?= base_url('inactiveUser') ?>" class="<?php if ($page == "inactiveUser") {
																					echo 'active';
																				} ?>" key="t-category">Inactive Users
							</a>
						</li>
					</ul>
				</li>

				<li class="<?php if ($page == "newPartnerBooking" || $page == 'assignPartner') {
								echo "mm-active";
							} ?>">
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="fab fa-product-hunt"></i>
						<span key="t-ecommerce">Partner Booking</span>
					</a>
					<ul class="sub-menu" aria-expanded="false">
						<li>
							<a href="<?= base_url('newPartnerBooking') ?>" class="<?php if ($page == "newPartnerBooking") {
																						echo 'active';
																					} ?>" key="t-category">New Booking
							</a>
						</li>
						<li>
							<a href="<?= base_url('assignPartner') ?>" class="<?php if ($page == "assignPartner") {
																					echo 'active';
																				} ?>" key="t-category">Assign Partner for Home
							</a>
						</li>
					</ul>
				</li>

				<li class="<?php if ($page == "newPartnerBookingForHospital" || $page == 'assignPartnerForHospital') {
								echo "mm-active";
							} ?>">
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="fab fa-product-hunt"></i>
						<span key="t-ecommerce">Partner for Hospital</span>
					</a>
					<ul class="sub-menu" aria-expanded="false">
						<li>
							<a href="<?= base_url('newPartnerBookingForHospital') ?>" class="<?php if ($page == "newPartnerBookingForHospital") {
																									echo 'active';
																								} ?>" key="t-category">New Booking
							</a>
						</li>
						<li>
							<a href="<?= base_url('assignPartnerForHospital') ?>" class="<?php if ($page == "assignPartnerForHospital") {
																								echo 'active';
																							} ?>" key="t-category">Assign Partner for Hospital
							</a>
						</li>
					</ul>
				</li>

				<li class="<?php if ($page == "newProductBooking" || $page == 'assignProductBooking') {
								echo "mm-active";
							} ?>">
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="fab fa-product-hunt"></i>
						<span key="t-ecommerce">Book Rental Product</span>
					</a>
					<ul class="sub-menu" aria-expanded="false">
						<li>
							<a href="<?= base_url('newProductBooking') ?>" class="<?php if ($page == "newProductBooking") {
																						echo 'active';
																					} ?>" key="t-category">New Booking
							</a>
						</li>
						<li>
							<a href="<?= base_url('assignProductBooking') ?>" class="<?php if ($page == "assignProductBooking") {
																							echo 'active';
																						} ?>" key="t-category">Assign Booking
							</a>
						</li>
					</ul>
				</li>

				<li>
					<a href="<?= base_url('formData') ?>" class="waves-effect">
						<i class="fas fa-lock"></i>
						<span key="t-file-manager">Care Recipient</span>
					</a>
				</li>

				<li>
					<a href="<?= base_url('viewTree') ?>" class="waves-effect">
						<i class="fas fa-lock"></i>
						<span key="t-file-manager">Chat Bot QA</span>
					</a>
				</li>

				<li>
					<a href="<?= base_url('charBotQuery') ?>" class="waves-effect">
						<i class="fas fa-lock"></i>
						<span key="t-file-manager">Char Bot Query</span>
					</a>
				</li>

				<li class="<?php if ($page == "videoCallRequest" || $page == 'allVideoCallRequest') {
								echo "mm-active";
							} ?>">
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="fab fa-product-hunt"></i>
						<span key="t-ecommerce">Video Call Request</span>
					</a>
					<ul class="sub-menu" aria-expanded="false">
						<li>
							<a href="<?= base_url('videoCallRequest') ?>" class="<?php if ($page == "videoCallRequest") {
																						echo 'active';
																					} ?>" key="t-category">New Video Call Request
							</a>
						</li>
						<li>
							<a href="<?= base_url('allVideoCallRequest') ?>" class="<?php if ($page == "allVideoCallRequest") {
																						echo 'active';
																					} ?>" key="t-category">Video Call Request
							</a>
						</li>
					</ul>
				</li>

				<li>
					<a href="<?= base_url('adminLogout') ?>" class="waves-effect">
						<i class="fas fa-sign-out-alt"></i>
						<span>Logout</span>
					</a>
				</li>

			</ul>
		</div>
	</div>
</div>