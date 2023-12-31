<div class="pagetitle mb-3">
	<h1>Sender</h1>
</div>
<section class="section">
	<div class="row">
		<div class="col-md-12">
			<?php
			$msgs = $this->session->flashdata('msgs');
			if ($msgs){
				$success_msgs = $msgs["success_msgs"];
				$error_msgs = $msgs["error_msgs"];
				if ($success_msgs) foreach($success_msgs as $msg){ ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<i class="bi bi-check-circle me-1"></i>
					<?= $msg ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
				<?php } 
				if ($error_msgs) foreach($error_msgs as $msg){ ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<i class="bi bi-exclamation-octagon me-1"></i>
					<?= $msg ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php }
			} ?>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Add Sender Email</h5>
					<form class="row g-3" method="post" action="<?= base_url() ?>home/add_sender">
						<input type="hidden" name="smtp_crypto" value="ssl" readonly>
						<div class="col-md-4">
							<label class="form-label">Protocol</label>
							<select class="form-select" name="protocol">
								<option value="smtp">smtp</option>
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
						<div class="col-md-12">
							<label class="form-label">Title</label>
							<input type="text" name="title" class="form-control">
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
					<h5 class="card-title">Sender list</h5>
					<table class="table table-striped align-middle">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Title</th>
								<th scope="col">Email</th>
								<th scope="col">Host</th>
								<th scope="col">Port</th>
								<th scope="col">Other</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($senders as $i => $s){ ?>
							<tr>
								<th scope="row"><?= number_format($i + 1) ?></th>
								<td><?= $s->title ?></td>
								<td><?= $s->smtp_user ?></td>
								<td><?= $s->smtp_host ?></td>
								<td><?= $s->smtp_port ?></td>
								<td><?= $s->protocol ?>, <?= $s->smtp_crypto ?></td>
								<td class="text-end">
									<a class="btn btn-primary" href="<?= base_url() ?>home/exec_send_test_email/<?= $s->sender_id ?>" target="_blank"><i class="bi bi-send"></i></a>
									<a class="btn btn-danger btn_delete_sender" href="<?= base_url() ?>home/delete_sender/<?= $s->sender_id ?>"><i class="bi bi-trash"></i></a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>