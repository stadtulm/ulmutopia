<?php

class Cortex_Kulturvermittlung_Emailer {
	static $fromHeader = 'From: ulmutopia.de <info@ulmutopia.de>';
	static $admins = ['nobody@noone.none'];

    /* Function that will send the "Wait for activation" Email
    -------------------------------------------------------------------------------*/
	public function sendRegistrationConfirmation($userId) {
		$userInfo  = get_userdata($userId);
		if(!empty($userInfo)){
			add_filter('wp_mail_content_type', array($this, 'setEmailContentType'));
			$to      = $userInfo->user_email;
			$subject = translate('[ulmutopia.de] Danke für deine Anmeldung auf ulmutopia.de', 'teilhabekultur');
			ob_start();
			$salutation = get_field('ansprechperson_1_vorname', 'user_' . $userId) . ' ' . get_field('ansprechperson_1_nachname', 'user_' . $userId);
			include('templates/emails/register_confirm.tpl.php');
			$body    =  ob_get_clean();
			$headers = array('Content-Type: text/html; charset=UTF-8', Cortex_Kulturvermittlung_Emailer::$fromHeader);

			wp_mail($to, $subject, $body, $headers);
			remove_filter('wp_mail_content_type', array($this, 'setEmailContentType'));
		}
	}

    /*  Function that will send the Confirmation email after the user was activated by an admin
    -------------------------------------------------------------------------------*/
	public function sendActivationEmail($userId) {
		$userInfo  = get_userdata($userId);
		if(!empty($userInfo)){
			add_filter('wp_mail_content_type', array($this, 'setEmailContentType'));
			$to      = $userInfo->user_email;
			$subject = translate('[ulmutopia.de] Dein Account wurde freigeschaltet', 'teilhabekultur');
			ob_start();
			$salutation = get_field('ansprechperson_1_vorname', 'user_' . $userId) . ' ' . get_field('ansprechperson_1_nachname', 'user_' . $userId);
			include('templates/emails/register_activation.tpl.php');
			$body    =  ob_get_clean();
			$headers = array('Content-Type: text/html; charset=UTF-8', Cortex_Kulturvermittlung_Emailer::$fromHeader);

			wp_mail($to, $subject, $body, $headers);
			remove_filter('wp_mail_content_type', array($this, 'setEmailContentType'));
		}
	}

    /*  Function that will send an email to all administrator emails, that a new account was created
   -------------------------------------------------------------------------------*/
	public function sendAdminNewAccount() {
		add_filter('wp_mail_content_type', array($this, 'setEmailContentType'));
		$subject = translate('[ulmutopia.de] Es wurde ein neuer Account angelegt', 'teilhabekultur');
		$salutation = 'Admin';
		ob_start();
		include('templates/emails/admin_new_account.tpl.php');
		$body    =  ob_get_clean();
		$headers = array('Content-Type: text/html; charset=UTF-8', Cortex_Kulturvermittlung_Emailer::$fromHeader);

		foreach(Cortex_Kulturvermittlung_Emailer::$admins AS $adminEmail) {
			$to = $adminEmail;
			wp_mail($to, $subject, $body, $headers);
		}
		remove_filter('wp_mail_content_type', array($this, 'setEmailContentType'));
	}

    /*  Function that will send an email to all administrator emails, that a new offer was created
    -------------------------------------------------------------------------------*/
	public function sendAdminNewOffer($offerId) {
		add_filter('wp_mail_content_type', array($this, 'setEmailContentType'));
		$subject = translate('[ulmutopia.de] Es wurde ein neues Angebot angelegt', 'teilhabekultur');
		$salutation = 'Admin';
		$linkToOffer = get_the_permalink($offerId);
		$title = get_the_title($offerId);
		ob_start();
		include('templates/emails/admin_new_offer.tpl.php');
		$body    =  ob_get_clean();
		$headers = array('Content-Type: text/html; charset=UTF-8', Cortex_Kulturvermittlung_Emailer::$fromHeader);

		foreach(Cortex_Kulturvermittlung_Emailer::$admins AS $adminEmail) {
			$to = $adminEmail;
			wp_mail($to, $subject, $body, $headers);
		}
		remove_filter('wp_mail_content_type', array($this, 'setEmailContentType'));
	}

    /*  Function that will send an email to all administrator emails, that a new tip was created
    -------------------------------------------------------------------------------*/
	public function sendAdminNewTip($tipId) {
		add_filter('wp_mail_content_type', array($this, 'setEmailContentType'));
		$subject = translate('[ulmutopia.de] Es wurde ein neuer Tip angelegt', 'teilhabekultur');
		$salutation = 'Admin';
		$linkToOverview = admin_url('/edit.php?post_type=tip');
		$title = get_the_title($tipId);
		ob_start();
		include('templates/emails/admin_new_tip.tpl.php');
		$body    =  ob_get_clean();
		$headers = array('Content-Type: text/html; charset=UTF-8', Cortex_Kulturvermittlung_Emailer::$fromHeader);

		foreach(Cortex_Kulturvermittlung_Emailer::$admins AS $adminEmail) {
			$to = $adminEmail;
			wp_mail($to, $subject, $body, $headers);
		}
		remove_filter('wp_mail_content_type', array($this, 'setEmailContentType'));
	}

    /*  Function that will send an email to all administrator emails with the content of the contact form
    -------------------------------------------------------------------------------*/
	public function sendContactForm($data) {
		add_filter('wp_mail_content_type', array($this, 'setEmailContentType'));
		$subject = translate('[ulmutopia.de] Neue Nachricht über das Kontaktformular', 'teilhabekultur');
		$salutation = 'Admin';
		ob_start();
		include('templates/emails/contact_form.tpl.php');
		$body    =  ob_get_clean();
		$headers = array('Content-Type: text/html; charset=UTF-8', Cortex_Kulturvermittlung_Emailer::$fromHeader);

		foreach(Cortex_Kulturvermittlung_Emailer::$admins AS $adminEmail) {
			$to = $adminEmail;
			wp_mail($to, $subject, $body, $headers);
		}
		remove_filter('wp_mail_content_type', array($this, 'setEmailContentType'));
	}

    /*  Function that will send an email with all favorites to an user
    -------------------------------------------------------------------------------*/
	public function sendFavorites($profileIds, $offerIds, $email) {
		add_filter('wp_mail_content_type', array($this, 'setEmailContentType'));
		$subject = translate('[ulmutopia.de] Deine Favoriten', 'teilhabekultur');
		ob_start();
		include('templates/emails/favorites.tpl.php');
		$body    =  ob_get_clean();
		$headers = array('Content-Type: text/html; charset=UTF-8', Cortex_Kulturvermittlung_Emailer::$fromHeader);

		wp_mail($email, $subject, $body, $headers);
		remove_filter('wp_mail_content_type', array($this, 'setEmailContentType'));
	}

    /*  Function that will send an email to all administrator emails, that a new offer was created
    -------------------------------------------------------------------------------*/
    public function sendCooperationEnquiry($userId, $requestId) {
        $userInfo  = get_userdata($userId);
        $requestInfo = get_userdata($requestId);

        if(!empty($userInfo) && !empty($requestInfo)){
            add_filter('wp_mail_content_type', array($this, 'setEmailContentType'));
            $to = $requestInfo->user_email;

            $subject = translate('[ulmutopia.de]  Neue Kooperationsanfrage', 'teilhabekultur');
            ob_start();
            $salutation = get_field('ansprechperson_1_vorname', 'user_' . $requestId) . ' ' . get_field('ansprechperson_1_nachname', 'user_' . $requestId);
            $profileName = get_field('name_institution_kuenstlerin', 'user_' . $userId);
            $acceptLink =  add_query_arg('profileId', $userId, get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('confirm_cooperation')));
            include('templates/emails/cooperation_enquiry.tpl.php');
            $body    =  ob_get_clean();
            $headers = array('Content-Type: text/html; charset=UTF-8', Cortex_Kulturvermittlung_Emailer::$fromHeader);

            wp_mail($to, $subject, $body, $headers);
            remove_filter('wp_mail_content_type', array($this, 'setEmailContentType'));
        }
    }

    /*  Filter for Wordress to send HTML Emails
    -------------------------------------------------------------------------------*/
	public function setEmailContentType() {
		return "text/html";
	}
}
