<!-- <!DOCTYPE html> -->
<html>
	<head>

		<meta name="viewport" content="width=device-width, initial-scale=1">


		<?php
		$array_list = array_slice(scandir(getcwd()), 2);

		function formatSizeUnits($bytes) {
			if ($bytes >= 1073741824) {
				$bytes = number_format($bytes / 1073741824, 2) . ' GB';
			} elseif ($bytes >= 1048576) {
				$bytes = number_format($bytes / 1048576, 2) . ' MB';
			} elseif ($bytes >= 1024) {
				$bytes = number_format($bytes / 1024, 2) . ' KB';
			} elseif ($bytes > 1) {
				$bytes = $bytes . ' bytes';
			} elseif ($bytes == 1) {
				$bytes = $bytes . ' byte';
			} else {
				$bytes = '0 bytes';
			}

			return $bytes;
		}

		function dirSize($directory) {
			$size = 0;
			foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file) {
				if ($file->getFileName() != '..')
					$size += $file->getSize();
			}
			return $size;
		}
		?>

		<?php include 'include.html'; ?>

		<title>Projekty by Janusz Ładecki</title>
	</head>

	<body>
		<div class="container">
			<table class="table table-hover">

				<tbody>
					<tr>
						<th class="name col-md-4">
							<span>Name</span>
						</th>
						<th class="access-time">
							<span>Access time</span>
						</th>
						<th class="edit-time">
							<span>Edit time</span>
						</th>
						<th class="create-time">
							<span>Create time</span>
						</th>
						<th class="size col-md-1">
							<span>Size</span>
						</th>
					</tr>
					<?php foreach ($array_list as $object): ?>
						<?php if (($object !== 'index.php') && ($object !== "include.html") && ($object !== "style.css") && ($object !== "xampp")): ?>

							<?php
//						$date = shell_exec("stat $object");
							$date_format = "H:i D j/n/Y";
							$date = stat($object);

							if (is_dir($object)) {
								$weight = formatSizeUnits(dirSize($object));
							} else {
								$weight = formatSizeUnits($date['size']);
							}
							?>

							<tr class="clickable-row" data-href='<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" . $object; ?>'>
								<td>
									<p><?= $object; ?></p>
								</td>
								<td>
									<?php echo date($date_format, $date['atime']) ?>
								</td>
								<td>
									<?php echo date($date_format, $date['mtime']) ?>
								</td>
								<td>
									<?php echo date($date_format, $date['ctime']) ?>
								</td>
								<td class="col-md-1">
									<?php echo $weight ?>
								</td>
							</tr>
							<?php
						endif;
					endforeach;
					?>
				</tbody>
			</table>
		</div>
		<div id="footer" class="col-md-12"></div>

		<script>

			jQuery(document).ready(function ($) {
				$(".clickable-row").click(function () {
					window.document.location = $(this).data("href");
				});
			});

		</script>

	</body>
</html>
