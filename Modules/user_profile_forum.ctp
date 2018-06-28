<?php
/**
 * Kenshimdev : Développeur web et administrateur système (https://kenshimdev.fr/)
 * @author        Kenshimdev - https://kenshimdev.fr
 * @copyright     Kenshimdev - All rights reserved
 * @link          http://mineweb.org/market
 * @since         23.01.2017
 */

App::import('XenBridge.Controller/Component', 'UserprofileComponent');

$profileComponent = new UserprofileComponent($user['pseudo']);

if($profileComponent->isEnable()){
?>
<p>
<div class="well" style="background-color: #fff;">
	 <div class="panel-body">
		<div class="box no-mb">
            <div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label><?= $Lang->get('XENBRIDGE_STATS_FORUM_USER_ID') ?></label>
                        <input type="text" class="form-control" value="<?= $profileComponent->getID(); ?>" disabled>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?= $Lang->get('XENBRIDGE_STATS_FORUM_RANK') ?></label>
                        <input type="text" class="form-control" value="<?= $profileComponent->getRank(); ?>" disabled>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?= $Lang->get('XENBRIDGE_STATS_FORUM_MESS_POSTED') ?></label>
                        <input type="text" class="form-control" value="<?= $profileComponent->getMessages(); ?>" disabled>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?= $Lang->get('XENBRIDGE_STATS_FORUM_LAST_ACT') ?></label>
                        <input type="text" class="form-control" value="<?= $profileComponent->getLastActivity(); ?>" disabled>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?= $Lang->get('XENBRIDGE_STATS_FORUM_CONVO_UNREAD') ?></label>
                        <input type="text" class="form-control" value="<?= $profileComponent->getConversationsUnread(); ?>" disabled>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?= $Lang->get('XENBRIDGE_STATS_FORUM_TROPHIES') ?></label>
                        <input type="text" class="form-control" value="<?= $profileComponent->getTrophies(); ?>" disabled>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?= $Lang->get('XENBRIDGE_STATS_FORUM_LIKE') ?></label>
                        <input type="text" class="form-control" value="<?= $profileComponent->getLikes(); ?>" disabled>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?= $Lang->get('XENBRIDGE_STATS_FORUM_WARNING') ?></label>
                        <input type="text" class="form-control" value="<?= $profileComponent->getWarnings(); ?>" disabled>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>

<?php } ?>