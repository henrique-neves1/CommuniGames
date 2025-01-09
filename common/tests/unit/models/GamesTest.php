<?php


namespace common\tests\unit\models;

use common\models\Games;
use common\models\Genres;
use common\models\Platforms;
use common\tests\UnitTester;
use yii\web\UploadedFile;

class GamesTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidation()
    {
        $game = new Games();

        // Test required fields (if there are any)
        $game->name = null;
        $this->assertFalse($game->validate(['name']));

        // Test valid fields
        $game->name = 'Test Game';
        $game->price = 49.99;
        $this->assertTrue($game->validate(['name', 'price']));

        // Test invalid price
        $game->price = 'not a number';
        $this->assertFalse($game->validate(['price']));

        $game->price = -10;
        $this->assertFalse($game->validate(['price']));
    }

    public function testFileUpload()
    {
        $game = new Games();

        // Mock an UploadedFile
        $mockFile = $this->createMock(UploadedFile::class);
        $mockFile->name = 'cover.jpg';
        $mockFile->tempName = __DIR__ . '/test_files/cover.jpg';
        $mockFile->size = 500;
        $mockFile->error = UPLOAD_ERR_OK;

        $game->coverFile = $mockFile;

        // Test uploadCover method
        $this->assertTrue($game->uploadCover());
        $this->assertEquals('cover.jpg', $game->cover_name);
        $this->assertNotNull($game->cover_data);
    }

    public function testRelations()
    {
        $game = Games::findOne(1); // Assuming a game with ID 1 exists in the test database

        // Test genres relation
        $this->assertNotEmpty($game->genres);
        foreach ($game->genres as $genre) {
            $this->assertInstanceOf(Genres::class, $genre);
        }

        // Test platforms relation
        $this->assertNotEmpty($game->platforms);
        foreach ($game->platforms as $platform) {
            $this->assertInstanceOf(Platforms::class, $platform);
        }
    }

    public function testLinkGenres()
    {
        $game = Games::findOne(1); // Assuming a game with ID 1 exists in the test database

        $genreIds = [1, 2]; // Assuming genres with these IDs exist
        $game->linkGenres($genreIds);

        $this->assertCount(2, $game->genres);
        foreach ($game->genres as $genre) {
            $this->assertTrue(in_array($genre->id, $genreIds));
        }
    }

    public function testLinkPlatforms()
    {
        $game = Games::findOne(1); // Assuming a game with ID 1 exists in the test database

        $platformIds = [1, 2]; // Assuming platforms with these IDs exist
        $game->linkPlatforms($platformIds);

        $this->assertCount(2, $game->platforms);
        foreach ($game->platforms as $platform) {
            $this->assertTrue(in_array($platform->id, $platformIds));
        }
    }

    public function testGetCoverBase64()
    {
        $game = Games::findOne(1); // Assuming a game with ID 1 exists

        // Assuming the game has cover data
        $base64 = $game->getCoverBase64();
        $this->assertNotNull($base64);
        $this->assertStringStartsWith('data:image', $base64);
    }
}
