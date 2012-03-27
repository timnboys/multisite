<?php 
	$form = Loader::helper('form');
	$fh = Loader::helper('field', 'multisite');
	$showForm = (empty($sites) || !empty($errors) || $data);
?>
<style type="text/css" media="screen">
	.form-label { width: 130px; }
	.ccm-ui td small {
		font-size: 11px;
		font-style: italic;
		display: block;
		margin: 5px 0;
	}
	<?php if (!$showForm): ?>
		#newSite { display: none; }
	<?php endif; ?>
</style>
<div class="ccm-ui">
	<?php if (!$prettyUrls): ?>
		<div class="alert-message block-message error">
			<strong>Pretty URLs are not enabled.</strong>
			It is strongly recommended that you enable pretty URLs
			in order for this module to work correctly! <br />
			<a href="<?php echo $this->url('/dashboard/system/seo/urls/') ?>">Click here to enable pretty URLs</a>
		</div>
	<?php endif; ?>
	<?php if ($errors): ?>
		<div class="alert-message block-message error">
			<strong>There were some problems saving the site.</strong>
			<ul style="margin-top: 5px;">
				<?php foreach ($errors as $e): ?>
					<li><?php echo $e ?></li>
				<?php endforeach ?>
			</ul>
		</div>
	<?php endif; ?>
	<div class="ccm-pane">
		<div class="ccm-pane-header">
			<h3>Manage Websites</h3>
		</div>
		<div class="ccm-pane-body ccm-pane-body-footer">
			<?php if (!$showForm): ?>
				<div style="margin-bottom: 10px; text-align: right;">
					<a id="openForm" href="#" class="btn primary">Add New Site</a>
				</div>
			<?php endif ?>
			<form id="newSite" action="<?php echo $this->action('saveData') ?>" method="post">
				<table class="zebra-striped">
					<thead>
						<tr>
							<th colspan="2">Add New Site</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($fields as $key => $field): ?>
							<tr>
								<td class="form-label">
									<?php echo $field['label'] ?>
									<?php if ($field['required']): ?>
										<span class="req">*</span>
									<?php endif; ?>
								</td>
								<td>
									<?php echo $fh->output($key, $field, $data) ?>
								</td>
							</tr>
						<?php endforeach; ?>
						<tr>
							<td colspan="2">
								<?php echo $form->submit('submit', 'Save Website', array('class' => 'btn primary')) ?>
								<?php if (!empty($sites)): ?>
									<a id="closeForm" href="#" class="btn">Cancel</a>									
								<?php endif ?>
							</td>
						</tr>
					</tbody>
				</table>
				<?php if ($data): ?>
					<?php echo $form->hidden('id', $data['id']) ?>
				<?php endif; ?>
			</form>
			<?php if (!empty($sites)): ?>
				<table class="zebra-striped">
					<thead>
						<tr>
							<th>Home Page</th>						
							<th>URL</th>
							<th width="250">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($sites as $site): ?>
							<tr>
								<td><?php echo $site->getPage()->getCollectionName() ?></td>
								<td><?php echo $site->url ?></td>
								<td>
									<a href="<?php echo $site->getPage()->getCollectionPath() ?>" class="btn">Visit</a>
									<a href="<?php echo $this->url('/dashboard/multisite/sites/edit', $site->id) ?>" class="btn">Edit Settings</a>
									<a href="<?php echo $this->action('delete', $site->id) ?>" class="btn danger">Delete</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>				
			<?php endif ?>
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	var formOpen = false;
	$('#openForm').click(function(e){
		e.preventDefault();
		toggleForm();
	});

	$('#closeForm').click(function(e){
		e.preventDefault();
		toggleForm();
	});

	function toggleForm() {
		if (!formOpen) {
			$('#openForm').hide();	
			formOpen = true;
		}
		else {
			$('#openForm').show();
			formOpen = false;
		}
		$('#newSite').slideToggle();
	}
</script>