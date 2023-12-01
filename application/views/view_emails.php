<div class="pagetitle mb-3">
	<div class="d-flex justify-content-between">
		<h1><?= $email_list->list ?> email list (<?= number_format($total) ?>)</h1>
		<a class="btn btn-primary" href="<?= base_url() ?>home/email_db"><i class="bi bi-arrow-left"></i></a>
	</div>
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
					<div class="d-flex justify-content-between align-items-center">
						<h5 class="card-title">Emails</h5>
						<ul class="pagination">
							<?php $base_link = base_url()."home/view_emails/".$email_list->list_id."?"; 
							foreach($paging as $p){ ?>
							<li class="page-item <?= $p[2] ?>"><a class="page-link" href="<?= $base_link."p=".$p[0] ?>"><?= $p[1] ?></a></li>
							<?php } ?>
						</ul>
					</div>
					<table class="table table-striped align-middle">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Email</th>
								<th scope="col">Last sent</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($emails as $i => $e){ ?>
							<tr>
								<th scope="row"><?= number_format((($page - 1) * 500) + $i + 1) ?></th>
								<td><?= $e->email ?></td>
								<td><?= $e->last_sent_at ?></td>
								<td class="text-end">
									<a class="btn btn-danger btn_delete_email" href="<?= base_url() ?>home/delete_email/<?= $email_list->list_id ?>/<?= $e->email_id ?>"><i class="bi bi-trash"></i></a>
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