<?php 
	$form = Loader::helper('form');
	$fh = Loader::helper('ms_field', 'multisite');
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
			<strong><?php echo t('Pretty URLs are not enabled.') ?></strong>
			<?php echo t('It is strongly recommended that you enable pretty URLs in order for this module to work correctly!') ?><br />
			<a href="<?php echo $this->url('/dashboard/system/seo/urls/') ?>"><?php echo t('Click here to enable pretty URLs') ?></a>
		</div>
	<?php endif; ?>
	<?php if ($errors): ?>
		<div class="alert-message block-message error">
			<strong><?php echo t('There were some problems saving the site.') ?></strong>
			<ul style="margin-top: 5px;">
				<?php foreach ($errors as $e): ?>
					<li><?php echo $e ?></li>
				<?php endforeach ?>
			</ul>
		</div>
	<?php endif; ?>
	<div class="ccm-pane">
		<div class="ccm-pane-header">
			<h3><?php echo t('Manage Websites') ?></h3>
		</div>
		<div class="ccm-pane-body ccm-pane-body-footer">
			<?php if (!$showForm): ?>
				<div style="margin-bottom: 10px; text-align: right;">
					<a id="openForm" href="#" class="btn primary"><?php echo t('Add New Site') ?></a>
				</div>
			<?php endif ?>
			<form id="newSite" action="<?php echo $this->action('saveData') ?>" method="post">
				<table class="zebra-striped">
					<thead>
						<tr>
							<th colspan="2"><?php echo t('Add New Site') ?></th>
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
								<?php if (!$data && !empty($sites)): ?>
									<a id="closeForm" href="#" class="btn"><?php echo t('Cancel') ?></a>	
								<?php elseif ($data): ?>
									<a href="<?php echo $this->url('/dashboard/multisite/sites') ?>" class="btn"><?php echo t('Cancel') ?></a>
								<?php endif ?>
							</td>
						</tr>
					</tbody>
				</table>
				<?php if ($data): ?>
					<?php echo $form->hidden('id', $data['id']) ?>
				<?php endif; ?>
			</form>
			<?php if (!empty($sites) && !$data): ?>
				<table class="zebra-striped">
					<thead>
						<tr>
							<th><?php echo t('Home Page') ?></th>						
							<th><?php echo t('URL') ?></th>
							<th width="250"><?php echo t('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($sites as $site): ?>
							<tr>
								<?php $_page = $site->getPage(); ?>
								<td>
									<a href="<?php echo $_page->getCollectionPath() ?>">
										<?php echo $_page->getCollectionName() ?>
									</a>
								</td>
								<td><?php echo $site->url ?></td>
								<td>
									<!-- <a href="<?php echo $site->getPage()->getCollectionPath() ?>" class="btn"><?php echo t('Visit') ?></a> -->
									<a href="<?php echo $site->getUrl() ?>" class="btn"><?php echo t('Visit') ?></a>
									<a href="<?php echo $this->url('/dashboard/multisite/sites/edit', $site->id) ?>" class="btn"><?php echo t('Edit Settings') ?></a>
									<a href="<?php echo $this->action('delete', $site->id) ?>" class="btn danger" onclick="return deleteConfirm()"><?php echo t('Delete') ?></a>
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
	
	function deleteConfirm() {
		return confirm('<?php echo t("Are you sure you want to delete this site?") ?>');
	}
</script>