<div class="pagetitle mb-3">
	<h1>Auto Mailing</h1>
</div>
<section class="section">
	<div class="row">
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
					<h3 class="text-center mb-0">00:00:00</h3>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Sent</h5>
					<h3 class="text-center mb-0">12,348</h3>
					<input type="hidden" id="sent" value="0">
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Error</h5>
					<h3 class="text-center mb-0">12,348</h3>
					<input type="hidden" id="error" value="0">
				</div>
			</div>
		</div>
	</div>
</section>