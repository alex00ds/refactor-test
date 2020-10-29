<?php


namespace Kl;

use Kl\Traits\Logger;
use Kl\Interfaces\IUserPaymentRepository;
use Kl\Interfaces\IUserRepository;

class UserPaymentsService
{
    use Logger;

    private $userPaymentRepository;

    private $userRepository;

    public function getUserPaymentRepository()
    {
        if (!$this->userPaymentRepository) {
            $this->setUserPaymentRepository(new UserPaymentDbTable());
        }

        return $this->userPaymentRepository;
    }

    public function setUserPaymentRepository(IUserPaymentRepository $repository)
    {
        $this->userPaymentRepository = $repository;
    }

    public function getUserRepository()
    {
        if (!$this->userRepository) {
            $this->setUserRepository(new UserDbTable());
        }

        return $this->userRepository;
    }

    public function setUserRepository(IUserRepository $repository)
    {
        $this->userRepository = $repository;
    }

    public function changeBalance(User $user, float $amount)
    {
        $userDbTable = $this->getUserRepository();

        $userPaymentsDbTable = $this->getUserPaymentRepository();

        $logger = $this->getLogger();

        $paymentType = $amount >= 0 ? 'in' : 'out';

        $userBalance = $user->balance;

        $payment = new UserPayment($user->id, $paymentType, $userBalance, abs($amount));

        // add payment transaction
        $paymentId = $userPaymentsDbTable->add($payment);
        if (!$paymentId) {
            $msg = sprintf('Failed to pop up user balance');

            $logger->reportError($msg);

            throw new \Exception($msg);
        }

        $user->balance += $amount;

        // update user balance in db
        $userDbTable->updateUser($user);

        // send email
        if (!$this->sendEmail($user->email)) {
            $msg = sprintf('Failed to send email for payment id ' . $paymentId);

            $logger->reportError($msg);
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
