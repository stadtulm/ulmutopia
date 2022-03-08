<h1>Profile</h1>

<div class="wrap">
    <div id="private-user-notice" class="notice <?php if($success) {?> notice-success <?php } else if($error){?> notice-error <?php } ?> is-dismissible" style="<?php if(empty($success) && empty($error)) {?> display: none;<?php } ?>">
        <?php
            if(!empty($success)) {
                if($successCode == 1) {
	                echo "Das Profil wurde erfolgreich aktiviert.";
                } else if($successCode == 2) {
	                echo "Das Profil wurde erfolgreich stillgelegt.";
                } else if($successCode == 3) {
	                echo "Das Profil wurde erfolgreich gelöscht.";
                } else if($successCode == 4) {
	                echo "Das Profil wurde erfolgreich als Highlight entfernt.";
                } else if($successCode == 5) {
	                echo "Das Profil wurde erfolgreich als Highlight markiert.";
                }

            } if(!empty($error)) {
                if($errorCode == 1) {
                    echo "Das Profil konnte nicht gefunden werden.";
                }
            }
        ?>
    </div>

	<h1 class="wp-heading-inline">Alle registrierten Profile</h1>
	<hr class="wp-header-end" style="margin-bottom: 32px;">

	<table class="wp-list-table widefat fixed striped posts">
		<thead>
		<tr>
			<th scope="col" id="title" class="manage-column column-title column-primary">
				<span>Name Institution / Künstler*in</span>
			</th>
			<th scope="col" id="email" class="manage-column">E-Mail</th>
			<th scope="col" id="registered_on" class="manage-column">Registriert am</th>
			<th scope="col" id="active" class="manage-column">Aktiv?</th>
		</tr>
		</thead>

		<tbody id="the-list">
		<?php foreach($users AS $user) { ?>
			<tr id="user-<?php echo $user->ID; ?>" class="format-standard has-post-thumbnail hentry <?php if(get_field('highlightprofil', 'user_' . $user->ID)) {?>highlight<?php } ?>">
				<td>
					<strong>
						<a class="row-title" href="<?php echo get_edit_user_link($user->ID);?>"><?php echo get_field('name_institution_kuenstlerin', 'user_' . $user->ID);?></a>
					</strong>
					<div class="row-actions">
						<span class="view"><a target="_blank" href="<?php echo Cortex_Kulturvermittlung_Profiles::generateProfileLink($user->ID);?>">Profil anschauen</a> | </span>
                        <span class="edit"><a target="_blank" href="<?php echo get_edit_user_link($user->ID);?>">Profil editieren</a> | </span>
                        <?php if(get_field('aktiv', 'user_' . $user->ID)) {?>
                            <span class="edit"><a href="<?php echo admin_url('admin.php');?>?page=<?php echo Cortex_Kulturvermittlung_Admin::$menuSlug;?>&cortex_kulturvermittlung_action=deactivate&user_id=<?php echo $user->ID;?>">Profil stilllegen</a> | </span>
                        <?php } else { ?>
                            <span class="edit"><a href="<?php echo admin_url('admin.php');?>?page=<?php echo Cortex_Kulturvermittlung_Admin::$menuSlug;?>&cortex_kulturvermittlung_action=activate&user_id=<?php echo $user->ID;?>">Profil aktivieren</a> | </span>
                        <?php } ?>

						<?php if(get_field('highlightprofil', 'user_' . $user->ID)) {?>
                            <span class="edit"><a href="<?php echo admin_url('admin.php');?>?page=<?php echo Cortex_Kulturvermittlung_Admin::$menuSlug;?>&cortex_kulturvermittlung_action=removeHightlight&user_id=<?php echo $user->ID;?>">Highlight entfernen</a> | </span>
						<?php } else { ?>
                            <span class="edit"><a href="<?php echo admin_url('admin.php');?>?page=<?php echo Cortex_Kulturvermittlung_Admin::$menuSlug;?>&cortex_kulturvermittlung_action=setHightlight&user_id=<?php echo $user->ID;?>">Als Highlight markieren</a> | </span>
						<?php } ?>

						<span class="delete"><a class="submitdelete" href="<?php echo admin_url('admin.php');?>?page=<?php echo Cortex_Kulturvermittlung_Admin::$menuSlug;?>&cortex_kulturvermittlung_action=delete&user_id=<?php echo $user->ID;?>">Profil Löschen</a></span>
					</div>
				</td>
				<td><?php echo $user->user_email;?></td>
				<td><?php echo $user->user_registered;?></td>
				<td>
					<?php
						if(get_field('aktiv', 'user_' . $user->ID)) {?>
                            <span class="dashicons dashicons-yes green"></span>
						<?php } else {?>
                            <span class="dashicons dashicons-no-alt red"></span>
					<?php }
					?>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>