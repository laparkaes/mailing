<div class="pagetitle mb-3">
	<h1>Email DB</h1>
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
					<h5 class="card-title">Insert Emails</h5>
					<form class="row g-3" method="post" action="<?= base_url() ?>home/add_emails">
						<div class="col-md-3">
							<label class="form-label">List name</label>
							<select class="form-select mb-3" name="list_id">
								<option value="">Create new list</option>
								<?php foreach($email_lists as $l){ ?>
								<option value="<?= $l->list_id ?>"><?= $l->list ?></option>
								<?php } ?>
							</select>
							<input type="text" name="list" class="form-control">
						</div>
						<div class="col-md-9">
							<label class="form-label">Emails (separate with ,)</label>
							<textarea name="emails" class="form-control" rows="10"></textarea>
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
					<h5 class="card-title">Content list</h5>
					<table class="table table-striped align-middle">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">List name</th>
								<th scope="col">Email qty</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($email_lists as $i => $l){ ?>
							<tr>
								<th scope="row"><?= number_format($i + 1) ?></th>
								<td><?= $l->list ?></td>
								<td><?= number_format($l->qty) ?></td>
								<td class="text-end">
									<a class="btn btn-primary" href="<?= base_url() ?>home/view_emails/<?= $l->list_id ?>"><i class="bi bi-search"></i></a>
									<a class="btn btn-danger btn_delete_email_list" href="<?= base_url() ?>home/delete_email_list/<?= $l->list_id ?>"><i class="bi bi-trash"></i></a>
									<!--
									<a class="btn btn-primary" href="<?= base_url() ?>home/view_content/<?= $l->list_id ?>" target="_blank"><i class="bi bi-search"></i></a>
									<a class="btn btn-primary" href="<?= base_url() ?>home/send_content_sample/<?= $l->list_id ?>" target="_blank"><i class="bi bi-send"></i></a>
									-->
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