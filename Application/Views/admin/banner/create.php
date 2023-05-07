<?php view('shared.admin.header', [
	'title' => 'Add Banner'
]); ?>
<?php if (!empty($message)) { ?>
	<div class="alert alert-success" id="success-add-banner">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="document.getElementById('success-add-banner').style.display='none'">&times;</button>
		<?= $message ?? 'null' ?>
	</div>
<?php } ?>

<form action="./?module=admin&controller=banner&action=store" method="POST" name="bannerForm" role="form" enctype="multipart/form-data" onsubmit="return validateBannerForm();">

	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<div class="form-group">
				<label for="ad-bn-cr-name">Name</label>
				<small id="ad-bn-cr-name-err"></small>
				<input type="text" class="form-control" id='ad-bn-cr-name' name="name" placeholder="Input name" onkeyup="validateNotEmpty(this, 'Banner name');">

			</div>

			<div class="form-group">
				<label for="ad-bn-cr-site">Site</label>
				<select name="site" class="form-control" id='ad-bn-cr-site'>
					<option value="Home" selected>Home</option>
					<option value="About">About</option>
					<option value="Blog">Blog</option>
					<option value="Blog Detail">Blog Detail</option>
					<option value="Product">Product</option>
					<option value="Product Detail">Product Detail</option>
					<option value="Contact">Contact</option>
					<option value="Cart">Cart</option>
					<option value="Checkout">Checkout</option>
				</select>
			</div>

			<div class="form-group">
				<label for="ad-bn-cr-description">Description</label>
				<textarea class="form-control" id="ad-bn-cr-description" name="description" placeholder="Banner description" style="height: 46px;"></textarea>
			</div>
		</div>

		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<div class="form-group">
				<label for="ad-bn-cr-status">Status</label>
				<select name="status" class="form-control" id='ad-bn-cr-status'>
					<option value="1" selected>Visible</option>
					<option value="0">Hidden</option>
				</select>
			</div>

			<div class="form-group">
				<label for="ad-bn-cr-priority">Priority</label>
				<small id="ad-bn-cr-priority-err"></small>
				<input type="number" id="ad-bn-cr-priority" class="form-control" name="priority" placeholder="Input priority" onkeyup="validateInt(this, 'Priority');">

			</div>

			<div class="form-group">
				<label for=""> Banner Image</label>
				<small id="actual-btn-err"></small>
				<br>
				<input type="file" name="image" id="actual-btn" hidden onchange="readURL(this);">

				<div class="input-group">
					<span class="form-control" id="file-chosen">No file chosen</span>
					<div class="input-group-append">
						<label for="actual-btn" id='file-label' class="btn btn-sm btn-danger">
							<i class="fa fa-folder-open"></i>
						</label>
					</div>
				</div>

			</div>
		</div>

		<div class="row">
			<img src="#" alt="no-image" style="width:100%; padding: 15px" id="blah">
		</div>
	</div>

	<button type="submit" class="btn btn-primary">Save Data</button>
</form>


<?php view('shared.admin.footer'); ?>