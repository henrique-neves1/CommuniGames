<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use common\models\User;

/**
 * Class LoginCest
 */
class LoginCest
{

    public function _before(FunctionalTester $I)
    {
        // Ensure database has a valid user for login
        $this->user = new User();
        $this->user->username = 'testuser';
        $this->user->setPassword('password123');
        $this->user->status = User::STATUS_ACTIVE;
        $this->user->generateAuthKey();
        $this->user->save();
    }

    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }
    
    /**
     * @param FunctionalTester $I
     */
    public function testLoginPage(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->see('Login', 'h1');
        $I->see('Username');
        $I->see('Password');
    }

    public function testSuccessfulLogin(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->fillField('Username', 'testuser');
        $I->fillField('Password', 'password123');
        $I->click('Login');

        $I->see('Dashboard'); // Adjust this to match the expected post-login landing page
        $I->dontSee('Login');
    }

    public function testFailedLogin(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->fillField('Username', 'testuser');
        $I->fillField('Password', 'wrongpassword');
        $I->click('Login');

        $I->see('Incorrect username or password.');
        $I->seeInCurrentUrl('/site/login');
    }

    public function testEmptyFields(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->fillField('Username', '');
        $I->fillField('Password', '');
        $I->click('Login');

        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function _after(FunctionalTester $I)
    {
        // Clean up user after tests
        $this->user->delete();
    }
}
