<?php


namespace common\tests\unit\models;

use common\models\Games;
use common\models\TeamLists;
use common\tests\UnitTester;

class TeamListsTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidation()
    {
        $teamList = new TeamLists();

        // Test invalid name
        $teamList->name = str_repeat('a', 46); // Exceeds max length of 45
        $this->assertFalse($teamList->validate(['name']));

        // Test valid name
        $teamList->name = 'Developers';
        $this->assertTrue($teamList->validate(['name']));
    }

    public function testSaveTeamList()
    {
        $teamList = new TeamLists();
        $teamList->name = 'Game Designers';

        // Test save
        $this->assertTrue($teamList->save());

        // Verify saved data
        $savedTeamList = TeamLists::findOne(['name' => 'Game Designers']);
        $this->assertNotNull($savedTeamList);
        $this->assertEquals('Game Designers', $savedTeamList->name);
    }

    public function testGamesRelation()
    {
        // Create a TeamList
        $teamList = new TeamLists();
        $teamList->name = 'Producers';
        $teamList->save();

        // Create a Game associated with the TeamList
        $game = new Games();
        $game->name = 'Game A';
        $game->save();

        // Link the game to the team list
        $teamList->link('games', $game);

        // Test relation
        $this->assertCount(1, $teamList->games);
        $this->assertInstanceOf(Games::class, $teamList->games[0]);
        $this->assertEquals('Game A', $teamList->games[0]->name);
    }

    public function testLinkAllGames()
    {
        // Create a TeamList
        $teamList = new TeamLists();
        $teamList->name = 'Artists';
        $teamList->save();

        // Create multiple games
        $game1 = new Games();
        $game1->name = 'Game B';
        $game1->save();

        $game2 = new Games();
        $game2->name = 'Game C';
        $game2->save();

        $game3 = new Games();
        $game3->name = 'Game D';
        $game3->save();

        // Link all games to the team list
        $teamList->linkAllGames([$game1->id, $game2->id, $game3->id]);

        // Test relation
        $this->assertCount(3, $teamList->games);
        $this->assertEquals('Game B', $teamList->games[0]->name);
        $this->assertEquals('Game C', $teamList->games[1]->name);
        $this->assertEquals('Game D', $teamList->games[2]->name);
    }

    public function testDeleteTeamListWithGames()
    {
        // Create a TeamList
        $teamList = new TeamLists();
        $teamList->name = 'QA Team';
        $teamList->save();

        // Create a Game associated with the TeamList
        $game = new Games();
        $game->name = 'Game E';
        $game->save();
        $teamList->link('games', $game);

        // Delete TeamList
        $this->assertTrue($teamList->delete());

        // Verify the team list is deleted
        $deletedTeamList = TeamLists::findOne(['name' => 'QA Team']);
        $this->assertNull($deletedTeamList);

        // Verify the game is still present
        $remainingGame = Games::findOne(['name' => 'Game E']);
        $this->assertNotNull($remainingGame);

        // Ensure the link is broken
        $this->assertEmpty($remainingGame->teamLists);
    }
}
