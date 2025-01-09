<?php


namespace common\tests\unit\models;

use common\models\User;
use common\tests\Unit\Yii;
use common\tests\UnitTester;

class UserTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidation()
    {
        $user = new User();

        // Test required fields
        $this->assertFalse($user->validate(['username']));
        $user->username = 'testuser';
        $this->assertTrue($user->validate(['username']));

        // Test username uniqueness
        $existingUser = new User();
        $existingUser->username = 'testuser';
        $existingUser->status = User::STATUS_ACTIVE;
        $existingUser->save();

        $this->assertFalse($user->validate(['username'])); // Duplicate username
        $user->username = 'uniqueuser';
        $this->assertTrue($user->validate(['username']));
    }

    public function testPasswordManagement()
    {
        $user = new User();

        // Test password hashing
        $password = 'password123';
        $user->setPassword($password);
        $this->assertNotEmpty($user->password_hash);

        // Test password validation
        $this->assertTrue($user->validatePassword($password));
        $this->assertFalse($user->validatePassword('wrongpassword'));
    }

    public function testAuthKeyGeneration()
    {
        $user = new User();
        $user->generateAuthKey();

        $this->assertNotEmpty($user->auth_key);
    }

    public function testPasswordResetToken()
    {
        $user = new User();

        // Generate token
        $user->generatePasswordResetToken();
        $this->assertNotEmpty($user->password_reset_token);

        // Validate token
        $this->assertTrue(User::isPasswordResetTokenValid($user->password_reset_token));

        // Simulate an expired token
        $user->password_reset_token = Yii::$app->security->generateRandomString() . '_' . (time() - 3600);
        $this->assertFalse(User::isPasswordResetTokenValid($user->password_reset_token));

        // Remove token
        $user->removePasswordResetToken();
        $this->assertNull($user->password_reset_token);
    }

    public function testFindIdentity()
    {
        $user = new User();
        $user->username = 'activeuser';
        $user->status = User::STATUS_ACTIVE;
        $user->save();

        $foundUser = User::findIdentity($user->id);
        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertEquals($user->id, $foundUser->id);

        $nonexistentUser = User::findIdentity(9999);
        $this->assertNull($nonexistentUser);
    }

    public function testFindByUsername()
    {
        $user = new User();
        $user->username = 'findme';
        $user->status = User::STATUS_ACTIVE;
        $user->save();

        $foundUser = User::findByUsername('findme');
        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertEquals('findme', $foundUser->username);

        $nonexistentUser = User::findByUsername('unknown');
        $this->assertNull($nonexistentUser);
    }

    public function testFindByPasswordResetToken()
    {
        $user = new User();
        $user->username = 'resetuser';
        $user->status = User::STATUS_ACTIVE;
        $user->generatePasswordResetToken();
        $user->save();

        $foundUser = User::findByPasswordResetToken($user->password_reset_token);
        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertEquals($user->id, $foundUser->id);

        $nonexistentUser = User::findByPasswordResetToken('invalid_token');
        $this->assertNull($nonexistentUser);
    }

    public function testFindByVerificationToken()
    {
        $user = new User();
        $user->username = 'inactiveuser';
        $user->status = User::STATUS_INACTIVE;
        $user->generateEmailVerificationToken();
        $user->save();

        $foundUser = User::findByVerificationToken($user->verification_token);
        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertEquals($user->id, $foundUser->id);

        $nonexistentUser = User::findByVerificationToken('invalid_token');
        $this->assertNull($nonexistentUser);
    }

    public function testProfileRelation()
    {
        $user = new User();
        $user->username = 'relateduser';
        $user->status = User::STATUS_ACTIVE;
        $user->save();

        $profile = new \common\models\Profiles();
        $profile->user_id = $user->id;
        $profile->save();

        $this->assertInstanceOf(\common\models\Profiles::class, $user->profile);
        $this->assertEquals($user->id, $user->profile->user_id);
    }
}
