<?php


namespace Kl;


class UserDbTable
{
    private $storage = [
        [
            'id' => 1,
            'email' => 'testuser1@test.com',
            'balance' => 120.45
        ],
        [
            'id' => 2,
            'email' => 'testuser2@test.com',
            'balance' => 9999.45
        ],
        [
            'id' => 3,
            'email' => 'testuser3@test.com',
            'balance' => 0.45
        ]
    ];

    public function updateUser($data)
    {
        foreach ($this->storage as $index => $item) {
            if ($item['id'] == $data['id']) {
                $data['id'] = $item['id'];

                $this->storage[$index] = $data;
                return true;
            }
        }

        $msg = sprintf('User %s not found', $data['id']);

        error_log($msg);

        throw new \Exception($msg);
    }
}
