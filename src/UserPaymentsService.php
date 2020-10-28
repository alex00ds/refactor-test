<?php


namespace Kl;


class UserPaymentsService
{
    private $userPaymentsDbTable;

    private $userDbTable;

    public function getUserPaymentsDbTable()
    {
        if (!$this->userPaymentsDbTable) {
            $this->userPaymentsDbTable = new UserPaymentDbTable();
        }

        return $this->userPaymentsDbTable;
    }

    public function getUserDbTable()
    {
        if (!$this->userDbTable) {
            $this->userDbTable = new UserDbTable();
        }

        return $this->userDbTable;
    }

    public function changeBalance(User $user, float $amount)
    {
        $userDbTable = $this->getUserDbTable();

        $userPaymentsDbTable = $this->getUserPaymentsDbTable();

        $paymentType = $amount >= 0 ? 'in' : 'out';

        $userBalance = $user->balance;

        $payment = new UserPayment($user->id, $paymentType, $userBalance, abs($amount));

        // add payment transaction
        $paymentId = $userPaymentsDbTable->add($payment->toArray());
        if (!$paymentId) {
            $msg = sprintf('Failed to pop up user balance');

            error_log($msg);

            throw new \Exception($msg);
        }

        $user->balance += $amount;

        // update user balance in db
        $userDbTable->updateUser($user->toArray());

        // send email
        if (!$this->sendEmail($user->email)) {
            $msg = sprintf('Failed to send email for payment id ' . $paymentId);

            error_log($msg);
        }

        return true;
    }

    public function sendEmail($userEmail)
    {
        $adminEmail = 'admin@test.com';

        $subject = 'Balance update';

        $message = 'Hello! Your balance has been successfully updated!';

        $headers = 'From: ' . $adminEmail . "\r\n" .
            'Reply-To: ' . $adminEmail . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        return mail($userEmail, $subject, $message, $headers);
    }
}
