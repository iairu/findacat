<?php

namespace Tests\Feature;

use App\Cat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageCatFamiliesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cat_can_update_their_father()
    {
        $cat = factory(Cat::class);
        $this->visit(route('profile'));
        $this->seePageIs(route('profile'));
        $this->dontSeeElement('input', ['name' => 'set_father']);
        $this->click(trans('cat.set_father'));
        $this->seePageIs(route('cats.show', ['action' => 'set_father']));
        $this->seeElement('input', ['name' => 'set_father']);

        $this->submitForm('set_father_button', [
            'set_father' => 'Nama Ayah',
        ]);

        $this->seeInDatabase('cats', [
            'nickname' => 'Nama Ayah',
        ]);

        $this->assertEquals('Nama Ayah', $cat->fresh()->father->nickname);
    }

    /** @test */
    public function cat_can_update_their_mother()
    {
        $cat = factory(Cat::class);
        $this->visit(route('profile'));
        $this->seePageIs(route('profile'));
        $this->dontSeeElement('input', ['name' => 'set_mother']);
        $this->click(trans('cat.set_mother'));
        $this->seePageIs(route('cats.show', ['action' => 'set_mother']));
        $this->seeElement('input', ['name' => 'set_mother']);

        $this->submitForm('set_mother_button', [
            'set_mother' => 'Nama Ibu',
        ]);

        $this->seeInDatabase('cats', [
            'nickname'   => 'Nama Ibu',
        ]);

        $this->assertEquals('Nama Ibu', $cat->fresh()->mother->nickname);
    }

    /** @test */
    public function cat_can_add_childrens()
    {
        $cat = factory(Cat::class)->create(['gender_id' => 1]);
        $this->visit(route('profile'));
        $this->seePageIs(route('profile'));
        $this->click(trans('cat.add_child'));
        $this->seeElement('input', ['name' => 'add_child_name']);
        $this->seeElement('input', ['name' => 'add_child_gender_id']);
        $this->seeElement('select', ['name' => 'add_child_parent_id']);

        $this->submitForm(trans('cat.add_child'), [
            'add_child_name'      => 'Nama Anak 1',
            'add_child_gender_id' => 1,
            'add_child_parent_id' => '',
        ]);

        $this->seeInDatabase('cats', [
            'nickname'   => 'Nama Anak 1',
            'gender_id'  => 1,
            'father_id'  => $cat->id,
            'mother_id'  => null,
            'parent_id'  => null,
        ]);
    }

    /** @test */
    public function cat_can_add_childrens_with_parent_id_if_exist()
    {
        $husband = factory(Cat::class)->create(['gender_id' => 1]);
        $wife = factory(Cat::class)->states('female')->create([]);
        $husband->addWife($wife);

        $marriageId = $husband->fresh()->wifes->first()->pivot->id;

        $this->visit(route('profile'));
        $this->seePageIs(route('profile'));
        $this->click(trans('cat.add_child'));
        $this->seeElement('input', ['name' => 'add_child_name']);
        $this->seeElement('input', ['name' => 'add_child_gender_id']);
        $this->seeElement('select', ['name' => 'add_child_parent_id']);

        $this->submitForm(trans('cat.add_child'), [
            'add_child_name'      => 'Nama Anak 1',
            'add_child_gender_id' => 1,
            'add_child_parent_id' => $marriageId,
        ]);

        $this->seeInDatabase('cats', [
            'nickname'   => 'Nama Anak 1',
            'gender_id'  => 1,
            'father_id'  => $husband->id,
            'mother_id'  => $wife->id,
        ]);
    }

    /** @test */
    public function cat_can_set_wife()
    {
        $cat = factory(Cat::class)->create(['gender_id' => 1]);
        $this->visit(route('profile'));
        $this->seePageIs(route('profile'));
        $this->click(trans('cat.add_wife'));
        $this->seeElement('input', ['name' => 'set_wife']);

        $this->submitForm('set_wife_button', [
            'set_wife'      => 'Nama Istri',
            'marriage_date' => '2010-01-01',
        ]);

        $this->seeInDatabase('cats', [
            'nickname'  => 'Nama Istri',
            'gender_id' => 2,
        ]);

        $wife = Cat::where([
            'nickname'  => 'Nama Istri',
            'gender_id' => 2,
        ])->first();

        $this->seeInDatabase('couples', [
            'husband_id'    => $cat->id,
            'wife_id'       => $wife->id,
            'marriage_date' => '2010-01-01',
        ]);
    }

    /** @test */
    public function cat_can_set_husband()
    {
        $cat = factory(Cat::class)->create(['gender_id' => 2]);
        $this->visit(route('profile'));
        $this->seePageIs(route('profile'));
        $this->click(trans('cat.add_husband'));
        $this->seeElement('input', ['name' => 'set_husband']);

        $this->submitForm('set_husband_button', [
            'set_husband'   => 'Nama Suami',
            'marriage_date' => '2010-03-03',
        ]);

        $this->seeInDatabase('cats', [
            'nickname'   => 'Nama Suami',
            'gender_id'  => 1,
        ]);

        $husband = Cat::where([
            'nickname'  => 'Nama Suami',
            'gender_id' => 1,
        ])->first();

        $this->seeInDatabase('couples', [
            'husband_id'    => $husband->id,
            'wife_id'       => $cat->id,
            'marriage_date' => '2010-03-03',
        ]);
    }

    /** @test */
    public function cat_can_pick_father_from_existing_cat()
    {
        $cat = factory(Cat::class);
        $father = factory(Cat::class)->states('male')->create();

        $this->visit(route('profile'));
        $this->seePageIs(route('profile'));
        $this->dontSeeElement('input', ['name' => 'set_father']);
        $this->click(trans('cat.set_father'));
        $this->seePageIs(route('cats.show', ['action' => 'set_father']));
        $this->seeElement('input', ['name' => 'set_father']);
        $this->seeElement('select', ['name' => 'set_father_id']);

        $this->submitForm('set_father_button', [
            'set_father'    => '',
            'set_father_id' => $father->id,
        ]);

        $this->assertEquals($father->nickname, $cat->fresh()->father->nickname);
    }

    /** @test */
    public function cat_can_pick_mother_from_existing_cat()
    {
        $cat = factory(Cat::class);
        $mother = factory(Cat::class)->states('female')->create();

        $this->visit(route('profile'));
        $this->seePageIs(route('profile'));
        $this->dontSeeElement('input', ['name' => 'set_mother']);
        $this->click(trans('cat.set_mother'));
        $this->seePageIs(route('cats.show', ['action' => 'set_mother']));
        $this->seeElement('input', ['name' => 'set_mother']);
        $this->seeElement('select', ['name' => 'set_mother_id']);

        $this->submitForm('set_mother_button', [
            'set_mother'    => '',
            'set_mother_id' => $mother->id,
        ]);

        $this->assertEquals($mother->nickname, $cat->fresh()->mother->nickname);
    }

    /** @test */
    public function cat_can_pick_wife_from_existing_cat()
    {
        $cat = factory(Cat::class)->create(['gender_id' => 1]);
        $wife = factory(Cat::class)->states('female')->create();

        $this->visit(route('profile'));
        $this->seePageIs(route('profile'));
        $this->click(trans('cat.add_wife'));
        $this->seeElement('input', ['name' => 'set_wife']);
        $this->seeElement('select', ['name' => 'set_wife_id']);

        $this->submitForm('set_wife_button', [
            'set_wife'      => '',
            'set_wife_id'   => $wife->id,
            'marriage_date' => '2010-01-01',
        ]);

        $this->seeInDatabase('couples', [
            'husband_id'    => $cat->id,
            'wife_id'       => $wife->id,
            'marriage_date' => '2010-01-01',
        ]);
    }

    /** @test */
    public function cat_can_pick_husband_from_existing_cat()
    {
        $cat = factory(Cat::class)->create(['gender_id' => 2]);
        $husband = factory(Cat::class)->states('male')->create();

        $this->visit(route('profile'));
        $this->seePageIs(route('profile'));
        $this->click(trans('cat.add_husband'));
        $this->seeElement('input', ['name' => 'set_husband']);
        $this->seeElement('select', ['name' => 'set_husband_id']);

        $this->submitForm('set_husband_button', [
            'set_husband'    => '',
            'set_husband_id' => $husband->id,
            'marriage_date'  => '2010-03-03',
        ]);

        $this->seeInDatabase('couples', [
            'husband_id'    => $husband->id,
            'wife_id'       => $cat->id,
            'marriage_date' => '2010-03-03',
        ]);
    }

}
