<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?php
$this->assign('title', __('Verify Mobile Number'));
$this->assign('description', __('Verify Mobile Number'));
?>

<p class="login-box-msg"><?= __('We have sent a verification code to your mobile number.') ?></p>

<?= $this->Form->create(null, ['id' => 'sms-verify-form']); ?>

<?=
$this->Form->control('sms_code', [
    'label' => false,
    'placeholder' => __('Enter 6-digit Verification Code'),
    'class' => 'form-control',
    'required' => true,
])
?>

<?= $this->Form->button(__('Verify'), [
    'class' => 'btn btn-primary btn-block btn-flat',
]); ?>

<?= $this->Form->end() ?>

<div class="social-auth-links text-center">
    <p>- <?= __("OR") ?> -</p>
    <?= $this->Html->link(__('Resend Code'), ['action' => 'smsResend'], ['class' => 'text-center']) ?>
</div>
