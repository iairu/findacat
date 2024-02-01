<?php

namespace Tests\Unit;

use App\Cat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonRelationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create_user_model_with_factory()
    {
        $person = factory(User::class)->create();

        $this->seeInDatabase('users', [
            'nickname' => $person->nickname,
            'gender_id' => $person->gender_id,
        ]);
    }

    /** @test */
    public function person_can_have_a_sire()
    {
        $person = factory(User::class)->create();
        $sire = factory(User::class)->states('male')->create();
        $person->setSire($sire);

        $this->seeInDatabase('users', [
            'id' => $person->id,
            'sire_id' => $sire->id,
        ]);

        $this->assertEquals($sire->name, $person->sire->name);
    }

    /** @test */
    public function person_can_have_a_dam()
    {
        $person = factory(User::class)->create();
        $dam = factory(User::class)->states('female')->create();
        $person->setDam($dam);

        $this->seeInDatabase('users', [
            'id' => $person->id,
            'dam_id' => $dam->id,
        ]);

        $this->assertEquals($dam->name, $person->dam->name);
    }

    /** @test */
    public function person_can_many_childs()
    {
        $dam = factory(User::class)->states('female')->create();
        $person = factory(User::class)->create();
        $person->setDam($dam);
        $person = factory(User::class)->create();
        $person->setDam($dam);

        $this->assertCount(2, $dam->childs);
    }
}
