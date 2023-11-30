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
					<h5 class="card-title">Asign Content File</h5>
					<form class="row g-3" method="post" action="<?= base_url() ?>home/add_content">
						<div class="col-md-4">
							<label class="form-label">Title</label>
							<input type="text" name="title" class="form-control">
						</div>
						<div class="col-md-8">
							<label class="form-label">File name</label>
							<input type="text" name="filename" class="form-control">
						</div>
						<div class="col-md-12 text-danger">
							<div><small>* File name has to be without .php</small></div>
							<div><small>* The file should already be uploaded at the path view/contents/</small></div>
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
								<th scope="col">Title</th>
								<th scope="col">File name</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($contents as $i => $c){ ?>
							<tr>
								<th scope="row"><?= number_format($i + 1) ?></th>
								<td><?= $c->title ?></td>
								<td><?= $c->filename ?></td>
								<td class="text-end">
									<a class="btn btn-primary" href="<?= base_url() ?>home/view_content/<?= $c->content_id ?>" target="_blank"><i class="bi bi-search"></i></a>
									<a class="btn btn-primary" href="<?= base_url() ?>home/send_content_sample/<?= $c->content_id ?>" target="_blank"><i class="bi bi-send"></i></a>
									<a class="btn btn-danger btn_delete_content" href="<?= base_url() ?>home/delete_content/<?= $c->content_id ?>"><i class="bi bi-trash"></i></a>
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