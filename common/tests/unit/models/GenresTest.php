<?php


namespace common\tests\unit\models;

use common\models\Games;
use common\models\Genres;
use common\tests\UnitTester;

class GenresTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidation()
    {
        $genre = new Genres();

        // Test invalid name
        $genre->name = str_repeat('a', 46); // Exceeds max length of 45
        $this->assertFalse($genre->validate(['name']));

        // Test valid name
        $genre->name = 'Action';
        $this->assertTrue($genre->validate(['name']));
    }

    public function testSaveGenre()
    {
        $genre = new Genres();
        $genre->name = 'Adventure';

        // Test save
        $this->assertTrue($genre->save());

        // Verify saved data
        $savedGenre = Genres::findOne(['name' => 'Adventure']);
        $this->assertNotNull($savedGenre);
        $this->assertEquals('Adventure', $savedGenre->name);
    }

    public function testGamesRelation()
    {
        // Create a genre
        $genre = new Genres();
        $genre->name = 'RPG';
        $genre->save();

        // Create a game associated with the genre
        $game = new Games();
        $game->name = 'Final Fantasy';
        $game->save();

        // Link the game to the genre
        $game->link('genres', $genre);

        // Test relation
        $this->assertCount(1, $genre->games);
        $this->assertInstanceOf(Games::class, $genre->games[0]);
        $this->assertEquals('Final Fantasy', $genre->games[0]->name);
    }

    public function testDeleteGenreWithGames()
    {
        // Create a genre
        $genre = new Genres();
        $genre->name = 'Shooter';
        $genre->save();

        // Create a game associated with the genre
        $game = new Games();
        $game->name = 'Call of Duty';
        $game->save();
        $game->link('genres', $genre);

        // Delete genre
        $this->assertTrue($genre->delete());

        // Verify the genre is deleted
        $deletedGenre = Genres::findOne(['name' => 'Shooter']);
        $this->assertNull($deletedGenre);

        // Verify the game is still present
        $remainingGame = Games::findOne(['name' => 'Call of Duty']);
        $this->assertNotNull($remainingGame);

        // Ensure the link is broken
        $this->assertEmpty($remainingGame->genres);
    }
}
