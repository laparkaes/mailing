<div class="pagetitle mb-3">
	<h1>Sender</h1>
</div>
<section class="section">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Add Sender Email</h5>
					<?php
					$error_msgs = $this->session->flashdata('error_msgs');
					if ($error_msgs) foreach($error_msgs as $msg){ ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<i class="bi bi-exclamation-octagon me-1"></i>
						<?= $msg ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
					<?php } ?>
					<form class="row g-3" method="post" action="<?= base_url() ?>home/add_sender">
						<input type="hidden" name="mailtype" value="html" readonly>
						<input type="hidden" name="charset" value="utf-8" readonly>
						<input type="hidden" name="wordwrap" value="1" readonly>
						<input type="hidden" name="crlf" value="\r\n" readonly>
						<input type="hidden" name="newline" value="\r\n" readonly>
						<input type="hidden" name="smtp_crypto" value="ssl" readonly>
						<div class="col-md-4">
							<label class="form-label">Protocol</label>
							<select class="form-select" name="protocol">
								<option value="">smtp</option>
								<option value="mail">mail</option>
								<option value="sendmail">sendmail</option>
							</select>
						</div>
						<div class="col-md-4">
							<label class="form-label">Host</label>
							<input type="text" name="smtp_host" class="form-control">
						</div>
						<div class="col-md-4">
							<label class="form-label">Port</label>
							<input type="text" name="smtp_port" class="form-control">
						</div>
						<div class="col-md-6">
							<label class="form-label">Sender Email</label>
							<input type="text" name="smtp_user" class="form-control">
						</div>
						<div class="col-md-6">
							<label class="form-label">Sender Password</label>
							<input type="text" name="smtp_pass" class="form-control">
						</div>
						<div class="text-center pt-3">
							<button type="submit" class="btn btn-primary">Save</button>
							<button type="reset" class="btn btn-secondary">Reset</button>
						</div>
					</form>
				</div>
			</div>
		</div>
					
						
	
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<h5 class="card-title">Parameters</h5>
						<div>
							<button type="button" class="btn btn-danger d-none" id="btn_stop">Stop</button>
							<button type="button" class="btn btn-primary" id="btn_start">Start</button>
						</div>
					</div>
					
					<div class="row g-3 mb-0">
						<div class="col-md-4 col-12">
							<label class="form-label">Sender</label>
							<select class="form-select" id="sender">
								<option value="1" selected="">Handok</option>
							</select>
						</div>
						<div class="col-md-4 col-12">
							<label class="form-label">Content</label>
							<select class="form-select" id="content">
								<option value="1" selected="">Handok</option>
							</select>
						</div>
						<div class="col-md-4 col-12">
							<label class="form-label">Email list</label>
							<select class="form-select" id="email_list">
								<option value="1" selected="">Handok</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Time</h5>
					<h3 class="text-center mb-0">00:00:00<h3>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Sent</h5>
					<h3 class="text-center mb-0">12,348<h3>
					<input type="hidden" id="sent" value="0">
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Error</h5>
					<h3 class="text-center mb-0">12,348<h3>
					<input type="hidden" id="error" value="0">
				</div>
			</div>
		</div>
	</div>
</section>