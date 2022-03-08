<?php include(dirname(__FILE__) . '/header.tpl.php');?>

	<p><strong>Hallo,</strong></p>

	<p>Es wurde eine neue Nachricht über das Kontaktformular geschickt.</p>

	<table>
		<tr>
			<td>
				Vorname:
			</td>
			<td>
				<?php echo $data['firstName'];?>
			</td>
		</tr>

		<tr>
			<td>
				Nachname:
			</td>
			<td>
				<?php echo $data['lastName'];?>
			</td>
		</tr>

		<tr>
			<td>
				E-Mailadresse:
			</td>
			<td>
				<a href="mailto:<?php echo $data['email'];?>"><?php echo $data['email'];?></a>
			</td>
		</tr>

		<?php if(!empty($data['institution'])) {?>
			<tr>
				<td>
					Institution:
				</td>
				<td>
					<?php echo $data['institution'];?>
				</td>
			</tr>
		<?php } ?>

		<tr>
			<td>
				Nachricht:
			</td>
			<td>
				<?php echo $data['message'];?>
			</td>
		</tr>
	</table>

<?php include(dirname(__FILE__) . '/footer.tpl.php');?>